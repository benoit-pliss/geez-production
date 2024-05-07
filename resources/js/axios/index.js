import axios from "axios";

const axiosClient = axios.create({
    baseURL: "http://localhost:8000/api",
})

axiosClient.interceptors.request.use(config => {
    config.headers.Accept = "application/json";
    config.headers["Allow"] = "GET, POST, PUT, DELETE";
    config.headers.Authorization = `Bearer ` + localStorage.getItem("token");
    return config;
});

export default axiosClient;
