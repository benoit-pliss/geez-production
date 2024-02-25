import axiosClient from "../axios/index.js";

export function subscribeToNewsletter(mail) {

    const formdata = new FormData();
    formdata.append("email", mail);

  return axiosClient.post("/newsletter/subscribe", formdata);
}
