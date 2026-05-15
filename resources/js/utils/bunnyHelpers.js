export const extractBunnyId = (url) => {
    if (!url?.endsWith('.m3u8')) return null;
    return url.split('/').at(-2) ?? null;
};
