import Sortable from 'sortablejs';

$(document).ready(function () {
    let progressCards = $('.progress__body--contents');
    // console.log(progressCards);


    // progressCards.sortable({
    //     connectWith: ".connected-sortable",
    //     animation: 150
    // })

    for (const progressCard of progressCards) {
        new Sortable(
            progressCard, {
                group: 'shared',
                animation: 150

        })


    }
})