import axiosClient from "../axios/index.js";

export function uploadPhoto(photos = [])  {
    return axiosClient.post("/upload/photos", {
        photos : photos
    });
}

export function getListedPhotos() {
    return axiosClient.get("/photos");
}
