import VueRouter from "vue-router";
import Vue from "vue";
import Home from "./components/Home.vue";
import ReuseExp from "./components/ReuseExp.vue";

Vue.use(VueRouter);

export default new VueRouter({
    routes: [
        {
            path: "/home",
            name: "Home",
            component: Home
        },
        {
            path: "/test",
            name: "ReuseExp",
            component: ReuseExp
        }
        
    ],
    mode: "history"
});