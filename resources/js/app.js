const handle = $("#custom-handle");
const slider = $("#slider");
const places_list = $("#places_list");

function disableSlider() {
    slider.slider('disable');
}

function enableSlider() {
    slider.slider('enable');
}

function disableSelect() {
    places_list.selectmenu('disable');
}

function enableSelect() {
    places_list.selectmenu('enable');
}

function getSliderValue() {
    return slider.slider("value");
}

function getSelectValue() {
    return $('#places_list').find(':selected')[0]['value'];
}

function disableUI() {
    disableSlider();
    disableSelect();
}

function enableUI() {
    enableSelect();
    enableSlider();
}

function renderResults(list) {
    console.log('renderResults(list)', list);
    const result_block = $('#result_block');
    result_block.text('');
    for (let i = 0, index = 1; i < list.length; i++, index++) {
        result_block.append($(`<p>${index} ${list[i]['title']} (${Number(list[i]['distance']).toFixed(2)}km)</p>`))
    }

}

async function loadResults() {
    try {
        disableUI();
        const target_id = getSelectValue();
        const range = getSliderValue();
        const data = {target_id, range};
        const response = await $.ajax({
            method: "GET",
            url:
                `${window.location.origin}/api/places/list_by_range`
            ,
            data: data
        })
        renderResults(response.data.list);
        enableUI();
    } catch (e) {
        console.log(e);
    }
}

slider.slider({
    create: function () {
        handle.text($(this).slider("value"));
    },
    slide: function (event, ui) {
        handle.text(ui.value);
    },
    stop: (event, ui) => {
        loadResults()
    },
    min: 50,
    max: 500
});

places_list.selectmenu({
    change: () => {
        loadResults();
    }
});



