import axiosClient from "../axios/index.js";

export function handleSuccess(name, path ) {
  return axiosClient.post("/upload/success", { name, path });
}
