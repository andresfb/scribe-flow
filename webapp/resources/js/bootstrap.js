import axios from "axios";
import Alpine from "alpinejs";
import htmx from 'htmx.org';

window.htmx = htmx;

window.axios = axios;
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

window.Alpine = Alpine;
Alpine.start();
