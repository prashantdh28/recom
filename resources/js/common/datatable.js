/** When enter on search on listing page */
export const search = (tableId) => {
    $('input[type="search"]').keyup(function(event) {
        const keycode = (event.keyCode ? event.keyCode : event.which);

        if (keycode == '13') {
            LaravelDataTables[tableId].search($(this)).draw();
        }
    });
}

/** When filter on status on listing page */
export const filterStatus = (tableId) => {
    $('select[name="status"]').change(function() {
        LaravelDataTables[tableId].draw();
        drawerToggle();
    });
}

const drawerToggle = () => {
    const alpineData = Alpine.$data(document.querySelector('[x-data]'));
    alpineData.toggleDrawer = !alpineData.toggleDrawer;
}