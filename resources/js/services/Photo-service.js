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

export function updatePhoto(photo) {

    return axiosClient.put(`/photo/update`, {
        id: photo.id,
        name: photo.name,
        description: photo.description,
        tags: photo.tags
    });
}
