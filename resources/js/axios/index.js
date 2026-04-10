import axios from "axios";

const axiosClient = axios.create({
    baseURL: import.meta.env.VITE_API_URL ?? "/api",
})

axiosClient.interceptors.request.use(config => {
    config.headers.Accept = "application/json";
    config.headers.Authorization = `Bearer ` + localStorage.getItem("token");
    return config;
});

export default axiosClient;
