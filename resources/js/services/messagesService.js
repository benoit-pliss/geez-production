import axiosClient from "../axios/index.js";

export function getMessages() {
    return axiosClient.get("/messages");
}

export function getArchivedMessages() {
    return axiosClient.get("/message/archived");
}

export function readMessage(id) {

    const formdata = new FormData();
    formdata.append("id", id);

    return axiosClient.post("/message/read/", formdata);
}

export function deleteMessage(id) {
    
    const formdata = new FormData();
    formdata.append("id", id);

    return axiosClient.post("/message/delete/", formdata);
}

export function archiveMessage(id) {
    
    const formdata = new FormData();
    formdata.append("id", id);

    return axiosClient.post("/message/archive/", formdata);
}

