/*! DataTables Tailwind CSS integration */

import $ from 'jquery';  // Import jQuery directly
import 'datatables.net';  // Import DataTables directly

'use strict';
var DataTable = $.fn.dataTable;

/*
 * This is a tech preview of Tailwind CSS integration with DataTables.
 */

// Set the defaults for DataTables initialisation
$.extend(true, DataTable.defaults, {
    renderer: 'tailwindcss'
});

// Default class modification
$.extend(true, DataTable.ext.classes, {
    container: "dt-container dt-tailwindcss",
    paging: {
        active: 'font-semibold bg-gray-100 dark:bg-gray-700/75',
        notActive: 'bg-white dark:bg-gray-800',
        button: 'relative inline-flex justify-center items-center space-x-2 border px-2 py-1 -mr-px leading-6 hover:z-10 focus:z-10 active:z-10 border-gray-200 active:border-gray-200 active:shadow-none dark:border-gray-700 dark:active:border-gray-700',
        first: 'rounded-l-lg',
        last: 'rounded-r-lg',
        enabled: 'text-gray-800 hover:text-gray-900 hover:border-gray-300 hover:shadow-sm focus:ring focus:ring-gray-300 focus:ring-opacity-25 dark:text-gray-300 dark:hover:border-gray-600 dark:hover:text-gray-200 dark:focus:ring-gray-600 dark:focus:ring-opacity-40',
        notEnabled: 'text-gray-300 dark:text-gray-600'
    },
});

DataTable.ext.renderer.pagingButton.tailwindcss = function (settings, buttonType, content, active, disabled) {
    var classes = settings.oClasses.paging;
    var btnClasses = [classes.button];

    btnClasses.push(active ? classes.active : classes.notActive);
    btnClasses.push(disabled ? classes.notEnabled : classes.enabled);

    var a = $('<a>', {
        'href': disabled ? null : '#',
        'class': btnClasses.join(' ')
    }).html(content);

    return {
        display: a,
        clicker: a
    };
};

DataTable.ext.renderer.pagingContainer.tailwindcss = function (settings, buttonEls) {
    var classes = settings.oClasses.paging;

    buttonEls[0].addClass(classes.first);
    buttonEls[buttonEls.length - 1].addClass(classes.last);

    return $('<ul/>').addClass('pagination').append(buttonEls);
};

DataTable.ext.renderer.layout.tailwindcss = function (settings, container, items) {
    var row = $('<div/>', {
            "class": items.full ? 'grid grid-cols-1 gap-4 mb-4' : 'grid grid-cols-2 gap-4 mb-4'
        })
        .appendTo(container);

    DataTable.ext.renderer.layout._forLayoutRow(items, function (key, val) {
        var klass;

        // Apply start / end (left / right when ltr) margins
        if (val.table) {
            klass = 'col-span-2';
        }
        else if (key === 'start') {
            klass = 'justify-self-start';
        }
        else if (key === 'end') {
            klass = 'col-start-2 justify-self-end';
        }
        else {
            klass = 'col-span-2 justify-self-center';
        }

        $('<div/>', {
                id: val.id || null,
                "class": klass + ' ' + (val.className || '')
            })
            .append(val.contents)
            .appendTo(row);
    });
};

export default DataTable;

