import './bootstrap';
import '../metronic/core/index';
import '../metronic/app/layouts/demo1';
import $ from "jquery";
import 'laravel-datatables-vite';
import jQuery from 'jquery';
import '../../vendor/proengsoft/laravel-jsvalidation/public/js/jsvalidation';

import Alpine from 'alpinejs';

window.Alpine = Alpine;
window.$ = $;
window.jQuery = jQuery;

Alpine.start();
