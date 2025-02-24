import "./bootstrap";

import Alpine from "alpinejs";
import Echo from "laravel-echo";
import Pusher from "pusher-js";

window.Pusher = Pusher;
window.toastr = toastr;
window.Echo = new Echo({
    broadcaster: "pusher",
    key: window.appConfig.PUSHER_APP_KEY,
    cluster: window.appConfig.PUSHER_APP_CLUSTER,
    forceTLS: true,
    authEndpoint: "/broadcasting/auth",
    auth: {
        headers: {
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
        withCredentials: true,
    },
});
