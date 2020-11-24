import Sortable from 'sortablejs';

$(document).ready(function () {
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
        let areaForNewProgressCard = $containerOfProgresses.find(".progress__body--contents");
        console.log(areaForNewProgressCard);
        areaForNewProgressCard.append(
            "<div class=\"progress__card\" style=\"background-color: " + $color + "\">\n" +
            "                                        <div class=\"progress__card--name\">\n" +
            "                                            <div class=\"progress__card--text\">\n" +
            "                                                <span>Test</span>\n" +
            "                                            </div>\n" +
            "                                            <div class=\"progress__card--icons\">\n" +
            "                                                <svg class=\"svg-inline--fa fa-pencil-alt fa-w-16\" aria-hidden=\"true\" focusable=\"false\" data-prefix=\"fas\" data-icon=\"pencil-alt\" role=\"img\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 512 512\" data-fa-i2svg=\"\"><path fill=\"currentColor\" d=\"M497.9 142.1l-46.1 46.1c-4.7 4.7-12.3 4.7-17 0l-111-111c-4.7-4.7-4.7-12.3 0-17l46.1-46.1c18.7-18.7 49.1-18.7 67.9 0l60.1 60.1c18.8 18.7 18.8 49.1 0 67.9zM284.2 99.8L21.6 362.4.4 483.9c-2.9 16.4 11.4 30.6 27.8 27.8l121.5-21.3 262.6-262.6c4.7-4.7 4.7-12.3 0-17l-111-111c-4.8-4.7-12.4-4.7-17.1 0zM124.1 339.9c-5.5-5.5-5.5-14.3 0-19.8l154-154c5.5-5.5 14.3-5.5 19.8 0s5.5 14.3 0 19.8l-154 154c-5.5 5.5-14.3 5.5-19.8 0zM88 424h48v36.3l-64.5 11.3-31.1-31.1L51.7 376H88v48z\"></path></svg><!-- <i class=\"fas fa-pencil-alt\"></i> Font Awesome fontawesome.com -->\n" +
            "                                                <svg class=\"svg-inline--fa fa-trash-alt fa-w-14\" aria-hidden=\"true\" focusable=\"false\" data-prefix=\"fas\" data-icon=\"trash-alt\" role=\"img\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 448 512\" data-fa-i2svg=\"\"><path fill=\"currentColor\" d=\"M32 464a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128H32zm272-256a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zm-96 0a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zm-96 0a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zM432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16z\"></path></svg><!-- <i class=\"fas fa-trash-alt\"></i> Font Awesome fontawesome.com -->\n" +
            "                                            </div>\n" +
            "                                        </div>\n" +
            "                                        <hr>\n" +
            "                                        <div class=\"progress__card--description\">\n" +
            "                                            TestTestTestTestTestTestTestTest\n" +
            "                                        </div>\n" +
            "                                    </div>"
        )
    })
})