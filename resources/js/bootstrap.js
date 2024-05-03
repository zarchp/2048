import axios from 'axios';
import sort from '@alpinejs/sort';
import swipePlugin from 'alpinejs-swipe';

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

Alpine.plugin(sort);
Alpine.plugin(swipePlugin);
