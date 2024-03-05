import axiosClient from "../axios/index.js";

export function postMessage(firstname, lastname, email, phone, message) {

    const formdata = new FormData();
    formdata.append("firstname", firstname);
    formdata.append("lastname", lastname);
    formdata.append("email", email);
    formdata.append("phone", phone);
    formdata.append("message", message);

    console.log(formdata);

  return axiosClient.post("/contact/send", formdata);
}
