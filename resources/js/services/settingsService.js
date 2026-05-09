import axiosClient from "../axios/index.js";

export function getSettings() {
    return axiosClient.get('/settings');
}

export function updateSettings(settings) {
    return axiosClient.put('/settings', settings);
}
