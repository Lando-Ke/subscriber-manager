require('./bootstrap');

require('alpinejs');

import { createApp } from "vue";
import router from './router'
import SubscribersIndex from './components/subscribers/SubscribersIndex'

createApp({
    components: {
        SubscribersIndex
    }
}).use(router).mount('#app');
