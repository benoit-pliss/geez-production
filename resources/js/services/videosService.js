import axiosClient from "../axios/index.js";

export function initBunnyUpload(name) {
    return axiosClient.post("/upload/bunny-init", { name });
}

export function refreshBunnyCredentials(videoId) {
    return axiosClient.post("/upload/bunny-refresh", { videoId });
}

export function completeBunnyUpload(videoId, name) {
    return axiosClient.post("/upload/bunny-complete", { videoId, name });
}

export function getListeVideoByTags(tags) {
    return axiosClient.get("/videosByTags", {
        params: {
            tags: tags
        }
    });
}

export async function getVideoWithTags(page = 1, pageSize = 10, searchName = "") {
    return axiosClient.get(`/videosWithTags?page=${page}&pageSize=${pageSize}`, {
        params: {
            searchName: searchName
        }
    });
}

export function get30RandomVideosWithTags() {
    return axiosClient.get("/get30RandomVideosWithTags");
}


export function getBunnyVideoStatus(videoId) {
    return axiosClient.get('/video/bunny-status', { params: { videoId } });
}

export function updateVideo(video) {

    return axiosClient.put(`/video/update`, {
        id: video.id,
        name: video.name,
        description: video.description,
        tags: video.tags
    });
}