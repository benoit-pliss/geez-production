import axiosClient from "../axios/index.js";

export function uploadPhoto(photo)  {
    return axiosClient.post("/upload/photos", photo);
}

export function getListedPhotos() {
    return axiosClient.get("/photos");
}
