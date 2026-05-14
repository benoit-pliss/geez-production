import Hls from 'hls.js';

export function attachHls(el, url) {
    if (!url?.endsWith('.m3u8')) {
        return null;
    }

    if (Hls.isSupported()) {
        const hls = new Hls({ autoStartLoad: false, maxBufferLength: 8, maxMaxBufferLength: 15 });
        hls.loadSource(url);
        hls.attachMedia(el);
        return hls;
    }

    if (el.canPlayType('application/vnd.apple.mpegurl')) {
        el.src = url;
    }

    return null;
}
