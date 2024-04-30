import axiosClient from "../axios/index.js";
import {data} from "autoprefixer";

export function handleSuccess(name, path ) {
    const data = new FormData();
    data.append("name", name);
    data.append("path", path);
  return axiosClient.post("/upload/success", data);
}
