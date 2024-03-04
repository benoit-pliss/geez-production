import axiosClient from "../axios/index.js";

export function getTags() {
    return axiosClient.get("/tags");
}

export function storeTag(data) {
    return axiosClient.post("/tag/store", data);
}
