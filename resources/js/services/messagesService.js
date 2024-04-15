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

    return axiosClient.post("/message/read", formdata);
}

export function deleteMessage(id) {

    const formdata = new FormData();
    formdata.append("id", id);

    return axiosClient.post("/message/delete", formdata);
}

export function archiveMessage(id) {

    const formdata = new FormData();
    formdata.append("id", id);

    return axiosClient.post("/message/archive", formdata);
}

export function postMessage(firstname, lastname, email, phone, message) {

    const formdata = new FormData();
    formdata.append("firstname", firstname);
    formdata.append("lastname", lastname);
    formdata.append("email", email);
    formdata.append("phone", phone);
    formdata.append("message", message);

    console.log(formdata);

  return axiosClient.post("/message/send", formdata);
}
