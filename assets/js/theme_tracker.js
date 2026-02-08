/**
 * Wira Theme Installation Tracker
 * Sends usage data to the theme developer's analytics server.
 */

(function () {
    // Configuration
    const TRACKING_ENDPOINT = 'https://analytics.digidesa.id/api/theme-tracker'; // Replace with your actual endpoint
    const THEME_NAME = 'wira';
    const THEME_VERSION = 'v2601.0.0'; // Should match template.blade.php version

    // Avoid tracking on localhost/dev environments if desired
    const IS_LOCALHOST = window.location.hostname === 'localhost' ||
        window.location.hostname === '127.0.0.1' ||
        window.location.hostname.endsWith('.test');

    // Storage key to prevent excessive requests
    const CACHE_KEY = 'wira_theme_tracking_sent';
    const CACHE_duration = 24 * 60 * 60 * 1000; // 24 hours

    function sendTrackingData() {
        // Check if recently tracked
        const lastTracked = localStorage.getItem(CACHE_KEY);
        const now = Date.now();

        if (lastTracked && (now - parseInt(lastTracked)) < CACHE_duration) {
            return; // Already tracked recently
        }

        const data = {
            domain: window.location.hostname,
            url: window.location.href,
            theme: THEME_NAME,
            version: THEME_VERSION,
            userAgent: navigator.userAgent,
            timestamp: new Date().toISOString()
        };

        // Use sendBeacon if available for reliability during page unload, 
        // otherwise fetch or Image pixel
        if (navigator.sendBeacon) {
            const blob = new Blob([JSON.stringify(data)], { type: 'application/json' });
            navigator.sendBeacon(TRACKING_ENDPOINT, blob);
            localStorage.setItem(CACHE_KEY, now.toString());
        } else {
            fetch(TRACKING_ENDPOINT, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
                keepalive: true
            })
                .then(() => {
                    localStorage.setItem(CACHE_KEY, now.toString());
                })
                .catch(err => {
                    console.warn('Theme Analytics Error:', err);
                });
        }
    }

    // Run tracking when page is fully loaded or idle
    if (window.requestIdleCallback) {
        requestIdleCallback(sendTrackingData);
    } else {
        window.addEventListener('load', sendTrackingData);
    }

})();
