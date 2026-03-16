let lastUrl = '';
let activeTime = 0;
let syncInterval = null;

// The URL of your Laravel portal
const PORTAL_URL = 'https://xpertva.com/activity/store'; // Replace with your actual URL

chrome.tabs.onUpdated.addListener((tabId, changeInfo, tab) => {
    if (changeInfo.url) {
        checkUrl(changeInfo.url);
    }
});

chrome.tabs.onActivated.addListener(activeInfo => {
    chrome.tabs.get(activeInfo.tabId, (tab) => {
        if (tab && tab.url) {
            checkUrl(tab.url);
        }
    });
});

function checkUrl(url) {
    const socialDomains = ['facebook.com', 'instagram.com', 'youtube.com'];
    const isSocial = socialDomains.some(domain => url.toLowerCase().includes(domain));

    if (isSocial) {
        lastUrl = url;
        startTracking();
    } else {
        stopTracking();
    }
}

function startTracking() {
    if (syncInterval) return;

    syncInterval = setInterval(() => {
        activeTime += 10; // Increment every 10 seconds
        syncWithPortal();
    }, 10000);
}

function stopTracking() {
    if (syncInterval) {
        clearInterval(syncInterval);
        syncInterval = null;
        activeTime = 0;
    }
}

async function syncWithPortal() {
    if (!lastUrl) return;

    try {
        // Note: In a real scenario, you'd need to handle authentication (e.g. via an API key or session cookie)
        const response = await fetch(PORTAL_URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                url: lastUrl,
                active_time: 10,
                idle_time: 0,
                mouse_move_count: 0,
                click_count: 0,
                keystroke_count: 0
            })
        });

        if (response.ok) {
            console.log('Synced social media activity:', lastUrl);
        }
    } catch (error) {
        console.error('Failed to sync activity:', error);
    }
}
