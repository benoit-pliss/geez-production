import { createApp } from 'vue';

export default {
    data: {
        dialogInstance: null
    },

    openDialog(component, props = {}, onUpdatedTags) {
        const dialogContainer = document.createElement('div');
        document.body.appendChild(dialogContainer);
        this.dialogInstance = createApp(component, { ...props, onUpdatedTags }).mount(dialogContainer);
    },



    closeDialog() {
        if (this.dialogInstance) {
            const container = this.dialogInstance.$el;
            this.dialogInstance.unmount();
            document.body.removeChild(container);
            this.dialogInstance = null;
        }
    },

    getDialogInstance() {
        return this.dialogInstance;
    }
};
