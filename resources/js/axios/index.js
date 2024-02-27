import axios from "axios";

const axiosClient = axios.create({
    baseURL: "https://geez-production.com/api",
})

axiosClient.interceptors.request.use(config => {
    config.headers.Authorization = `Bearer ` + localStorage.getItem("token");
    return config;
});

export default axiosClient;
