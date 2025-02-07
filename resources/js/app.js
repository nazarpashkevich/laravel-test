import { createApp } from "vue/dist/vue.esm-bundler";
import Toast from 'vue-toastification';
import 'vue-toastification/dist/index.css';

import TextBlock from "./components/TextBlock.vue";
import ContactForm from "./components/ContactForm.vue";

import.meta.glob(["../../images/**"]);

import * as bootstrap from "bootstrap";

window.bootstrap = bootstrap;

const app = createApp({});
app.component("TextBlock", TextBlock);
app.component("ContactForm", ContactForm);

app.use(Toast, {
    position: 'top-right',
    timeout: 5000,
});

app.mount("#app");
