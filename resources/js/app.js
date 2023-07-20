// import './bootstrap';
import axios from 'axios';
import _ from 'lodash';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
window.axios = axios;
window._ = _;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

Alpine.start();
