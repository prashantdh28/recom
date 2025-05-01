import './bootstrap';
import $ from "jquery";
import jQuery from 'jquery';
import '../metronic/core/index';
import '../metronic/app/layouts/demo1';
// import 'laravel-datatables-vite';
import '../../node_modules/datatables.net-dt/css/dataTables.dataTables.css'
import '../../node_modules/datatables.net/js/dataTables';


import Alpine from 'alpinejs';

window.Alpine = Alpine;
window.$ = $;
window.jQuery = jQuery;

// import '../../vendor/proengsoft/laravel-jsvalidation/public/js/jsvalidation';

Alpine.start();
