import axiosClient from "../axios/index.js";

export function handleSuccess(name, path ) {
    const data = new FormData();
    data.append("name", name);
    data.append("path", path);
    return axiosClient.get("/upload/success", data);
}
