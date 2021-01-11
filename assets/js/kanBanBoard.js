import Sortable from 'sortablejs';
import { $urlToApi } from "./constants";
import DOMPurify from 'dompurify';

$(function () {
    let areaForProgressCards = $('.progress__body--contents');

    // Handle drag and drop, and sorting the cards
    for (const area of areaForProgressCards) {
        new Sortable(
            area, {
                group: 'shared',
                animation: 150,
                onEnd: function (e) {

                    console.log($(e))

                    // Get Title and description for the update in position
                    let id = $(e.item).data("id");
                    // let $cardTitle = $(e.item).find(".progress__card--text span").text();
                    // let $cardDescription = $(e.item).find(".progress__card--description p").text();

                    // Change color when dropped to that column
                    let $parentColumn = $(e.to).parent();
                    let $columnTitleBackgroundColor = $parentColumn.find(".progress__body--title").css("background-color");

                    // Set the background color to card
                    $(e.item).css("background-color", $columnTitleBackgroundColor);

                    // Get progress id, priority and workspace
                    let $fromProgressId = $(e.from).parent().data("id");
                    let $toProgressId = $parentColumn.data("id");
                    let $priorityFromProgress = $(e.clone).data("id");
                    // console.log($priorityFromProgress)
                    let $priorityToProgress = $(e.item).index() + 1;


                    let $data = {
                        color: $columnTitleBackgroundColor,
                        fromProgressId: $fromProgressId,
                        priorityFrom: $priorityFromProgress,
                        toProgressId: $toProgressId,
                        priorityTo: $priorityToProgress
                    }

                    // Request to update db

                    $.ajax({
                        url: $urlToApi + `/task/position/update/${id}`,
                        type: 'PUT',
                        contentType: 'application/json',
                        data: JSON.stringify($data),
                    })
                        .done(function (result) {
                            console.log(result);
                        })
                        .fail(function (xhr, status, error) {
                            console.error(error);
                        });
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
        // console.log($color);

        // create new div
        let $areaForNewProgressCard = $containerOfProgresses.find(".progress__body--contents");
        // console.log($areaForNewProgressCard);

        $areaForNewProgressCard.append(
            "<div class=\"progress__card\" data-id=\"\" style=\"background-color: " + $color + "\">\n" +
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
        $inputText = DOMPurify.sanitize($inputText);

        // Grab any text that already existed in textarea
        let $descpriptionBeforeInitialization = $initializedProgressCard.find("textarea").val();
        $descpriptionBeforeInitialization = DOMPurify.sanitize($descpriptionBeforeInitialization);

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
            $.post($urlToApi + "/task/create", $newTask)
                .done(function (result) {
                    result = JSON.stringify(result);
                    result = JSON.parse(result)
                    console.log(result)

                    // set data-id to new progress card

                    let $newCard = $('.progress__card')
                        .filter(function(){
                            return !$(this).attr('data-id');
                        });

                    // console.log($newCard)

                    $newCard.attr("data-id", result.id)
                })
                .fail(function (xhr, status, error) {
                    console.error(error);
                });

        } else {
            // User is trying to create an empty card - warn him
            $initializedProgressCard.find('#tooltip').show().animate({ opacity: 1 }, 500);
        }
    })

    //Start of Update a card with new data
    $progressCardsBodies.on("click", ".fa-pencil-alt", function(e) {
        e.stopPropagation();

        // Get the values from the progress__card
        let $editedProgressCard = $(this).closest(".progress__card");

        $editedProgressCard.find(".fa-pencil-alt").replaceWith(" <i class='far fa-check-circle'></i>")

        // Change delete icon to stop edit
        $editedProgressCard.find(".fa-trash-alt").replaceWith("<i class='far fa-times-circle'></i>")

        // TODO -SANITIZE!!!
        let $inputText = $editedProgressCard.find("span").text();
        $inputText = DOMPurify.sanitize($inputText);

        // Replace span with input element 
        // let $editInput = $(document.createElement("input")).addClass("input-group progress__card--input-text").val($inputText);
        let $editInput = $("<div class='input-group progress__card--input-text'></div>").append($(document.createElement("input")).addClass("form-control").val($inputText))
        $editedProgressCard.find("span").closest(".progress__card--text").attr("class", "progress__card--name").replaceWith($editInput)

        // Grab any text that already existed
        // TODO SANITIZE!!!
        let $descpriptionBeforeEdit = $editedProgressCard.find("p").text();
        $descpriptionBeforeEdit = DOMPurify.sanitize($descpriptionBeforeEdit);

        // edit taxtarea
        let $editTextArea = $("<div class='form-group progress__card--textarea-text'></div>").append($("<textarea class='form-control' rows='2'></textarea>").val($descpriptionBeforeEdit));



        $editedProgressCard.find("p").replaceWith($editTextArea);
    })

    // Update card with ajax request
    $progressCardsBodies.on("click", ".fa-check-circle", function (e) {
        e.stopPropagation();

        // Get id of task card
        let $progressCardToUpdate = $(this).closest(".progress__card");

        let id = $progressCardToUpdate.data("id");

        let $editInput = $progressCardToUpdate.find("input.form-control").val();
        $editInput = DOMPurify.sanitize($editInput);

        let $editTextArea = $progressCardToUpdate.find("textarea.form-control").val();
        $editTextArea = DOMPurify.sanitize($editTextArea);

        if ($editInput !== "" && $editTextArea !== null) {

            let $color = $progressCardToUpdate.css("background-color");
            let $progressId = $progressCardToUpdate.closest(".progress__body").data("id");
            let $workspaceId = $(".main-page__container").find(".workspace__title").data("id");
            let $priority = $progressCardToUpdate.index() + 1;

            let $updatedTask = {
                name: $editInput,
                description: $editTextArea,
                color: $color,
                progress: $progressId,
                workspace: $workspaceId,
                priority: $priority
            }

            let $checkIcon = $(this);

            // console.log(JSON.stringify($updatedTask))

            $.ajax({
                url: $urlToApi + `/task/update/${id}`,
                type: 'PUT',
                contentType: 'application/json',
                data: JSON.stringify($updatedTask),
            })
            .done(function (result) {
                console.log(result);

                $checkIcon.replaceWith("<i class=\"fas fa-pencil-alt\"></i>")
                $progressCardToUpdate.find(".fa-times-circle").replaceWith("<i class=\"fas fa-trash-alt\"></i>")

                // Replace input with a span element
                $progressCardToUpdate.find(".input-group.progress__card--input-text input").replaceWith($(document.createElement("span")).text($editInput))
                $progressCardToUpdate.find(".input-group.progress__card--input-text").attr("class", "progress__card--text")

                // reset to p element
                $progressCardToUpdate.find(".form-group.progress__card--textarea-text").replaceWith($(document.createElement("p")).text($editTextArea));
            })
            .fail(function (xhr, status, error) {
                console.error(error);
            });
        }else {
            // User is trying to create an empty card - warn him
            $progressCardToUpdate.find('#tooltip').show().animate({ opacity: 1 }, 500);
        }
    })

    // When user clicks the 'stop edit' icon - fa-times
    $progressCardsBodies.on("click", ".fa-times-circle", function (e) {
        // stop propagation
        e.stopPropagation();

        // reset to not edit mode
        let $editedProgressCard = $(this).closest(".progress__card");


        // Check if title and description are not empty and then modify

        let $progressCardTitle = $editedProgressCard.find("input").val();
        $progressCardTitle = DOMPurify.sanitize($progressCardTitle);

        let $progressCardDesc = $editedProgressCard.find("textarea").val();
        $progressCardDesc = DOMPurify.sanitize($progressCardDesc);

        if ($progressCardTitle !== "" && $progressCardDesc !== "") {
            $editedProgressCard.find(".fa-times-circle").replaceWith("<i class='fas fa-trash-alt'></i>")

            // Replace input with a span element
            $editedProgressCard.find(".input-group.progress__card--input-text input").replaceWith($(document.createElement("span")).text($progressCardTitle))
            $editedProgressCard.find(".input-group.progress__card--input-text").attr("class", "progress__card--text")


            // reset to p element
            // todo sanitize
            $editedProgressCard.find(".form-group.progress__card--textarea-text").replaceWith($(document.createElement("p")).text($progressCardDesc));


        } else {
            // show tooltip
            $editedProgressCard.find('#tooltip').show().animate({ opacity: 1 }, 500);
        }
    })

    // Handle deletion of card
    $progressCardsBodies.on("click", ".fa-trash-alt", function () {

        // Get id of task card
        let $progressCardToDelete = $(this).closest(".progress__card");

        let id = $progressCardToDelete.data("id");

        $.post($urlToApi + `/task/delete/${id}`)
            .done(function (result) {
                result = JSON.stringify(result);
                console.log(result.message);
            })
            .fail(function (xhr, status, error) {
                console.error(error);
            })

        // Remove card from ui
        $(this).closest(".progress__card").remove();
    })

    $(document).on("click", function () {
        // FIXME - BUG ON MULTIPLE TOOLTIPS
        $("#tooltip").each(function () {
            $(this).animate({ opacity: 0 }).hide();
        })
    })
})