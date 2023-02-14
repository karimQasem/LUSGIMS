import "./bootstrap";
import "../css/app.css";

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import PrimeVue from "primevue/config";
import ToastService from "primevue/toastservice";
import ConfirmationService from "primevue/confirmationservice";
// @ts-ignore
import { ZiggyVue } from "ziggy";
// @ts-ignore
import { Ziggy } from "./ziggy";
const appName =
    window.document.getElementsByTagName("title")[0]?.innerText || "Laravel";
createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        // @ts-ignore
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    // @ts-ignore
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(PrimeVue, { ripple: true })
            .use(ToastService)
            .use(ConfirmationService)
            .mount(el);
    },
    progress: {
        color: "#4B5563",
    },
});
