import axios from 'axios';
import Alpine from 'alpinejs';
import jQuery from 'jquery';

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.$ = window.jQuery = jQuery;

window.Alpine = Alpine;
Alpine.start();