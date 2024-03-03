import { createApp, reactive } from 'vue';
import ToastContainer from "../components/adminComponents/ToastContainer.vue";
let toastContainerInstance = null;

export const state = reactive({
    toasts: []
});

export default {
    showContainer() {
        if (!toastContainerInstance) {
            const container = document.createElement('div');
            document.body.appendChild(container);
            toastContainerInstance = createApp(ToastContainer, { toasts: state.toasts }).mount(container);
        }
    },

    addToast(message, type) {
        const id = Date.now();
        state.toasts.unshift({
            id,
            message,
            type
        });
        this.showContainer();
        setTimeout(() => {
            this.removeToast(id);
        }, 3000);
    },

    removeToast(id) {
        const index = state.toasts.findIndex(t => t.id === id);
        if (index !== -1) {
            state.toasts.splice(index, 1);
        }
    }
};
