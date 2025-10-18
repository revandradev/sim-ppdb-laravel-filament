self.addEventListener("push", function (event) {
    let data = { title: "Notification", body: "Ada update", icon: "/icon.png" };

    if (event.data) {
        try {
            data = event.data.json();
        } catch (e) {
            console.error("Push event data not JSON", e);
        }
    }

    const options = {
        body: data.body,
        icon: data.icon,
        badge: data.badge ?? null,
        data: data.data ?? null,
    };

    event.waitUntil(self.registration.showNotification(data.title, options));
});

self.addEventListener("notificationclick", function (event) {
    event.notification.close();
    // Bisa redirect ke halaman tertentu jika data.url ada
    if (event.notification.data && event.notification.data.url) {
        event.waitUntil(clients.openWindow(event.notification.data.url));
    }
});
