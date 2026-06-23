require("./bootstrap");

window.Vue = require("vue").default;
import Main from "./Main.vue";
import VueAxios from "vue-axios";
import VueRouter from "vue-router";
import axios from "axios";
import { routes } from "./routes";
import Vue from "vue";

Vue.use(VueRouter);
Vue.use(VueAxios, axios);
Vue.use(require("vue-moment"));

Vue.prototype.$appUrl = process.env.MIX_APP_URL || "//admin.carexllc.com/api/";
Vue.prototype.$baseUrl = process.env.MIX_BASE_URL || "//admin.carexllc.com/";
Vue.prototype.$assetsUrl = process.env.MIX_ASSETS_URL || "//admin.carexllc.com/assets/";
Vue.prototype.$uploadsUrl = process.env.MIX_UPLOADS_URL || "//admin.carexllc.com/uploads/";

Vue.prototype.$authUser = sessionStorage.getItem("user")
    ? JSON.parse(sessionStorage.getItem("user"))
    : false;
Vue.prototype.$settings = sessionStorage.getItem("settings")
    ? JSON.parse(sessionStorage.getItem("settings"))
    : false;
Vue.mixin({
    methods: {
        isLoggedIn: function () {
            if (!this.$authUser) {
                window.location.href = this.$baseUrl;
            }
        },
        isNotLoggedIn: function () {
            if (this.$authUser) {
                window.location.href = this.$baseUrl;
            }
        },
        tConvert: function (time) {
            // Check correct time format and split into components
            time = time
                .toString()
                .match(/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [time];

            if (time.length > 1) {
                // If time format correct
                time = time.slice(1); // Remove full string match value
                time[5] = +time[0] < 12 ? " AM" : " PM"; // Set AM/PM
                time[0] = +time[0] % 12 || 12; // Adjust hours
            }
            return time.join(""); // return adjusted time or original string
        },
    },
});

// Set Vue authentication
// axios.defaults.baseURL = `https://127.0.0.1:8000/api`
// Vue.use(VueAuth, auth)

const router = new VueRouter({
    mode: "history",
    routes: routes,
});

const app = new Vue({
    el: "#app",
    router: router,
    render: (h) => h(Main),
});
