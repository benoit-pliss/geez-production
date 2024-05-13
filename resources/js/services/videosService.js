import axiosClient from "../axios/index.js";
import {get30RandomPhotosWithTags} from "./Photo-service.js";

export function handleSuccess(name, path ) {
    const data = new FormData();
    data.append("name", name);
    data.append("path", path);
    return axiosClient.post("/upload/success", data);
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


export function updateVideo(video) {

    return axiosClient.put(`/video/update`, {
        id: video.id,
        name: video.name,
        description: video.description,
        tags: video.tags
    });
}