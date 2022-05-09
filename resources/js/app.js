require("./bootstrap");

window.Vue = require("vue").default;

import router from "./router";
import App from "./components/App";
import JwPagination from 'jw-vue-pagination';
Vue.component('jw-pagination',JwPagination );



new Vue({
    el: "#vue",
    components: {
        App
    },
    router
});