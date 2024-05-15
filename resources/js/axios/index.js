import axios from "axios";

const axiosClient = axios.create({
    baseURL: "https://develop.geez-production.com/api",
})

axiosClient.interceptors.request.use(config => {
    config.headers.Accept = "application/json";
    config.headers["Allow"] = "GET, POST, PUT, DELETE";
    config.headers.Authorization = `Bearer ` + localStorage.getItem("token");
    return config;
});

export default axiosClient;
