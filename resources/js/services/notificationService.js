// notificationService.js
import { createApp, h } from 'vue';
import ToastContainer from "../components/adminComponents/ToastContainer.vue";

let toastContainerInstance = null;

export default {
    data: {
        toasts: []
    },
    showContainer() {
        if (!toastContainerInstance) {
            console.log('toastContainerInstance');
            const container = document.createElement('div');
            document.body.appendChild(container);
            toastContainerInstance = createApp(ToastContainer, { toasts: this.data.toasts }).mount(container);
        } else {
            toastContainerInstance.toasts = this.data.toasts;
            console.log(toastContainerInstance.toasts);
        }
    },
    addToast(message, type) {

        const id = Date.now();
        this.data.toasts.unshift({
            id,
            message,
            type
        })

        console.log(this.data.toasts);
        this.showContainer();


        setTimeout(() => {
            this.removeToast(id);
        }, 3000);
    },

    removeToast(id) {
        const index = this.data.toasts.findIndex(t => t.id === id);
        if (index !== -1) {
            this.data.toasts.splice(index, 1);
        }
    }
};
