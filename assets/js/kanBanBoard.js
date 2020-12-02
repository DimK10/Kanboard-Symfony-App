import Sortable from 'sortablejs';

$(function () {
    let areaForProgressCards = $('.progress__body--contents');

    // Handle drag and drop, and sorting the cards
    for (const area of areaForProgressCards) {
        new Sortable(
            area, {
                group: 'shared',
                animation: 150

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

    // Update a card with new data 
    $progressCardsBodies.on("click", ".fa-pencil-alt", function(e) {
        e.stopPropagation();
        // console.log($(this).closest(".progress__card").find("span"));

        // Get the values from the progress__card
        let $editedProgressCard = $(this).closest(".progress__card");
        // TODO -SANITIZE!!!
        let $inputText = $editedProgressCard.find("span").text();

        // Replace span with input element 
        // let $editInput = $(document.createElement("input")).addClass("input-group progress__card--input-text").val($inputText);
        let $editInput = $("<div class='input-group progress__card--input-text'></div>").append($(document.createElement("input")).addClass("form-control").val($inputText))
        $editedProgressCard.find("span").closest(".progress__card--text").attr("class", "progress__card--name").replaceWith($editInput)
    })


    // Handle deletion of card
    $progressCardsBodies.on("click", ".fa-trash-alt", function () {
        $(this).closest(".progress__card").remove();
    })
})