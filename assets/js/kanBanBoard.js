import Sortable from 'sortablejs';

$(function () {





    let areaForProgressCards = $('.progress__body--contents');

    // Handle drag and drop, and sorting the cards
    for (const area of areaForProgressCards) {
        new Sortable(
            area, {
                group: 'shared',
                animation: 150,
                onEnd: function (e) {
                    // Change color when dropped to that column
                    let $parentColumn = $(e.to).parent();
                    let $columnTitleBackgroundColor = $parentColumn.find(".progress__body--title").css("background-color");

                    // Set the background color to card
                    $(e.item).css("background-color", $columnTitleBackgroundColor);
                }
        })
    }

    // Handle the making of a new card
    let plusIcons = $(".fa-plus");

    plusIcons.on('click', function () {

        let $plusIcon = $(this);

        let $containerOfProgresses = $plusIcon.closest('.progress__body');

        let $parentOfPlusIcon = $plusIcon.parent('.progress__body--title');

        // Get background-color of .progress__body--title

        let $color = $parentOfPlusIcon.css('background-color');
        console.log($color);

        // create new div
        let $areaForNewProgressCard = $containerOfProgresses.find(".progress__body--contents");
        console.log($areaForNewProgressCard);

        $areaForNewProgressCard.append(
            "<div class=\"progress__card\" style=\"background-color: " + $color + "\">\n" +
            "                                        <div class=\"progress__card--name\">\n" +
            "                                                <div class='input-group progress__card--input-text'>\n" +
            "                                                    <input type='text' placeholder='Add a Title' class='form-control'>\n" +
            "                                                 </div>\n" +
            "                                            <div class=\"progress__card--icons\">\n" +
            "                                                <i class='fa fa-check' aria-hidden='true'></i>\n" +
            "                                                <div id=\"tooltip\">\n" +
            "                                                    You cannot have blank title or description!\n" +
            "                                                </div>\n" +
            "                                                <svg class=\"svg-inline--fa fa-trash-alt fa-w-14\" aria-hidden=\"true\" focusable=\"false\" data-prefix=\"fas\" data-icon=\"trash-alt\" role=\"img\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 448 512\" data-fa-i2svg=\"\"><path fill=\"currentColor\" d=\"M32 464a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128H32zm272-256a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zm-96 0a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zm-96 0a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zM432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16z\"></path></svg><!-- <i class=\"fas fa-trash-alt\"></i> Font Awesome fontawesome.com -->\n" +
            "                                            </div>\n" +
            "                                        </div>\n" +
            "                                        <hr>\n" +
            "                                        <div class=\"progress__card--description\">\n" +
            "                                            <div class='form-group progress__card--textarea-text'>" +
            "                                                  <textarea class='form-control'  rows='2'></textarea>" +
            "                                            </div>\n" +
            "                                        </div>\n" +
            "                                    </div>"
        )
    })

    
    let $progressCardsBodies = $(".progress__body--contents");

    // Accept new card with data and initialize card
    //  CREATE NEW TASK
    $progressCardsBodies.on("click", ".fa-check", function (e) {
        e.stopPropagation();

        let $initializedProgressCard = $(this).closest(".progress__card");



        // TODO - SANITIZE
        let $inputText = $initializedProgressCard.find("input").val();

        // Grab any text that already existed in textarea
        let $descpriptionBeforeInitialization = $initializedProgressCard.find("textarea").val();

        if ($inputText !== "" && $descpriptionBeforeInitialization !== "") {

            // continue with the creation process
            let $color = $initializedProgressCard.css("background-color");
            let $progressId = $initializedProgressCard.closest(".progress__body").data("id");
            let $workspaceId = $(".main-page__container").find(".workspace__title").data("id");
            let $priority = $(".progress__body--contents.connected-sortable .progress__card").length;

            // Replace check icon with edit icon
            $initializedProgressCard.find(".fa-check").replaceWith("<i class='fas fa-pencil-alt'></i>")

            // take the data from the input
            $initializedProgressCard.find(".fa-times-circle").replaceWith("<i class='fas fa-trash-alt'></i>")

            // Replace input with a span element
            $initializedProgressCard.find(".input-group.progress__card--input-text input").replaceWith($(document.createElement("span")).text($inputText))
            $initializedProgressCard.find(".input-group.progress__card--input-text").attr("class", "progress__card--text")



            // reset to p element
            // todo sanitize
            $initializedProgressCard.find(".form-group.progress__card--textarea-text").replaceWith($(document.createElement("p")).text($descpriptionBeforeInitialization));


            // Create JSON request body
            let $newTask = {
                name: $inputText,
                description: $descpriptionBeforeInitialization,
                color: $color,
                progress: $progressId,
                workspace: $workspaceId,
                priority: $priority
            }

            // Send data
            $.post("http://kanboard-symfony-app.test/api/task/create", $newTask, function (result) {
                console.log(result);
            });

        } else {
            // User is trying to create an empty card - warn him
            $initializedProgressCard.find('#tooltip').show().animate({ opacity: 1 }, 500);
        }





    })

    // Update a card with new data 
    $progressCardsBodies.on("click", ".fa-pencil-alt", function(e) {
        e.stopPropagation();




        // Get the values from the progress__card
        let $editedProgressCard = $(this).closest(".progress__card");

        $editedProgressCard.find(".fa-pencil-alt").replaceWith(" <i class='fa fa-check'></i>")

        // Change delete icon to stop edit
        $editedProgressCard.find(".fa-trash-alt").replaceWith("<i class='far fa-times-circle'></i>")

        // TODO -SANITIZE!!!
        let $inputText = $editedProgressCard.find("span").text();

        // Replace span with input element 
        // let $editInput = $(document.createElement("input")).addClass("input-group progress__card--input-text").val($inputText);
        let $editInput = $("<div class='input-group progress__card--input-text'></div>").append($(document.createElement("input")).addClass("form-control").val($inputText))
        $editedProgressCard.find("span").closest(".progress__card--text").attr("class", "progress__card--name").replaceWith($editInput)

        // Grab any text that already existed
        // TODO SANITIZE!!!
        let $descpriptionBeforeEdit = $editedProgressCard.find("p").text();

        // edit taxtarea
        let $editTextArea = $("<div class='form-group progress__card--textarea-text'></div>").append($("<textarea class='form-control' rows='2'></textarea>").val($descpriptionBeforeEdit));



        $editedProgressCard.find("p").replaceWith($editTextArea);
    })


    // When user clicks the 'stop edit' icon - fa-times
    $progressCardsBodies.on("click", ".fa-times-circle", function (e) {
        // stop propagation
        e.stopPropagation();

        // reset to not edit mode
        let $editedProgressCard = $(this).closest(".progress__card");


        // Check if title and description are not empty and then modify

        let $progressCardTitle = $editedProgressCard.find("input").val();

        let $progressCardDesc = $editedProgressCard.find("textarea").val();

        if ($progressCardTitle !== "" && $progressCardDesc !== "") {
            $editedProgressCard.find(".fa-times-circle").replaceWith("<i class='fas fa-trash-alt'></i>")

            let $inputText = $editedProgressCard.find("input").val();



            // Replace input with a span element
            $editedProgressCard.find(".input-group.progress__card--input-text input").replaceWith($(document.createElement("span")).text($inputText))
            $editedProgressCard.find(".input-group.progress__card--input-text").attr("class", "progress__card--text")

            // Grab any text that already existed in textarea
            let $descpriptionBeforeEdit = $editedProgressCard.find("textarea").val();

            // reset to p element
            // todo sanitize
            $editedProgressCard.find(".form-group.progress__card--textarea-text").replaceWith($(document.createElement("p")).text($descpriptionBeforeEdit));


        } else {
            // show tooltip
            $editedProgressCard.find('#tooltip').show().animate({ opacity: 1 }, 500);
        }



    })

    // Handle deletion of card
    $progressCardsBodies.on("click", ".fa-trash-alt", function () {
        $(this).closest(".progress__card").remove();
    })

    $(document).on("click", function () {
        // FIXME - BUG ON MULTIPLE TOOLTIPS
        $("#tooltip").each(function () {
            $(this).animate({ opacity: 0 }).hide();
        })
    })
})