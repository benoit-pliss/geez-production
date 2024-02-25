import axiosClient from "../axios/index.js";

export function uploadPhoto(formData) {
    return axiosClient.post("/upload/photos", formData);
}

export function getListePhotos() {
    return axiosClient.get("/photos");
}

export function getListePhotosWithTags() {
    return axiosClient.get("/photosWithTags");
}

export function getListePhotosByTags(tags) {

    return axiosClient.get(`/photosByTags`, {
        params: {
            tags: tags
        }
    });
}

export function get30RandomPhotosWithTags() {
    return axiosClient.get("/get30RandomPhotosWithTags");
}

export function updatePhoto(photo) {

    return axiosClient.put(`/photo/update`, {
        id: photo.id,
        name: photo.name,
        description: photo.description,
        tags: photo.tags
    });
}
