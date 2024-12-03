import "../css/app.css";
import "./bootstrap";

import { initFlowbite } from "flowbite";
import LaravelPermissionToVueJS from "laravel-permission-to-vuejs";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { createApp, h } from "vue";
import { ZiggyVue } from "../../vendor/tightenco/ziggy";

import "flowbite";

const appName = 'บริษัท ไทยพิพัฒน์โซลูชั่น จำกัด';
createInertiaApp({
    title: (title) => `${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(LaravelPermissionToVueJS)
            .mixin({
                mounted() {
                    initFlowbite();
                },
            })
            .mount(el);
    },
    progress: {
        color: "#4B5563",
    },
});
