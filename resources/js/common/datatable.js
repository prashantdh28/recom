const drawerEl = document.querySelector('#filter-sidebar');
const drawer = KTDrawer.getInstance(drawerEl);

/** When enter on search on listing page */
export const search = (tableId) => {
    $('input[type="search"]').keyup(function (event) {
        const keycode = event.keyCode ? event.keyCode : event.which;

        if (keycode == "13") {
            LaravelDataTables[tableId].search($(this)).draw();
        }
    });
};

/** When filter on status on listing page */
export const filterStatus = (tableId) => {
    $(document).on("click", "#flt_submit", function () {
        LaravelDataTables[tableId].draw();
        drawer.hide();
    });

    $(document).on("click", "#reset-filter-sidebar", function () {
        $("#filter_form")[0].reset();
        LaravelDataTables[tableId].draw();
        drawer.hide();
    });
};

function tableHeight(bottomSpace) {
    let window_height = $(window).height();
    let table_offset = $(".dt-scroll-body").offset().top;
    let height = window_height - table_offset - bottomSpace;
    $(".dt-scroll-body").css("max-height", height + "px");
    $(".dt-scroll-body").css("height", height + "px");
}

setTimeout(() => {
    tableHeight(72);
}, 1000);
