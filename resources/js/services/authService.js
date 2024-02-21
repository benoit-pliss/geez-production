import axiosClient from "../axios/index.js";

export function login(data) {
  return axios.post("/api/login", data);
}

export function logout() {
    const token = localStorage.getItem('token');

    const config = {
        headers: { Authorization: `Bearer ${token}` }
    };

    localStorage.removeItem('token');
}

export function isTokenValid() {
    const token = localStorage.getItem('token');

    const config = {
        headers: { Authorization: `Bearer ${token}` }
    };

    return axios.get('/api/tags', config)
        .then(() => {
            return true;
        })
        .catch((error) => {
            if (error.response && error.response.status === 401) {
                return false;
            } else {
                console.error('Error during token validation:', error);
                return false;
            }
        });
}
