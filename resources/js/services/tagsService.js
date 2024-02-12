import axiosClient from "../axios/index.js";

export function getTags() {
    return axiosClient.get("/tags");
}
