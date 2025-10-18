if ("serviceWorker" in navigator && "PushManager" in window) {
    navigator.serviceWorker
        .register("/worker.js")
        .then((reg) => console.log("Service Worker registered", reg))
        .catch((err) => console.error("SW registration failed", err));

    // tunggu service worker aktif
    navigator.serviceWorker.ready.then(async (registration) => {
        const permission = await Notification.requestPermission();
        if (permission !== "granted") {
            console.log("Permission not granted for notifications");
            return;
        }

        // const publicKey = '{{ config("webpush.vapid.public_key") }}'; // dari config/webpush.php
        const publicKey = window.filamentData.vapid.publicKey;
        const convertedKey = urlBase64ToUint8Array(publicKey);

        const subscription = await registration.pushManager.subscribe({
            userVisibleOnly: true,
            applicationServerKey: convertedKey,
        });

        function getCsrfToken() {
            const metaTag = document.querySelector('meta[name="csrf-token"]');
            return metaTag ? metaTag.content : null;
        }

        const csrfToken = getCsrfToken();

        if (csrfToken) {
            console.log("CSRF Token berhasil diambil:", csrfToken);
        } else {
            console.error(
                "CSRF Token tidak ditemukan! Pastikan meta tag ada di layout."
            );
        }

        // kirim ke backend
        await fetch(window.filamentData.push.subscribeUrl, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
            },
            body: JSON.stringify(subscription),
        });
    });
}

// helper
function urlBase64ToUint8Array(base64String) {
    const padding = "=".repeat((4 - (base64String.length % 4)) % 4);
    const base64 = (base64String + padding)
        .replace(/\-/g, "+")
        .replace(/_/g, "/");
    const raw = atob(base64);
    const output = new Uint8Array(raw.length);
    for (let i = 0; i < raw.length; ++i) {
        output[i] = raw.charCodeAt(i);
    }
    return output;
}
