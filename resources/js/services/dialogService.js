import { createApp } from 'vue';

export default {
    data: {
        dialogInstance: null
    },

    openDialog(component, props = {}) {
        // Créer un élément div pour monter le composant de dialogue
        const dialogContainer = document.createElement('div');
        document.body.appendChild(dialogContainer);

        // Créer une nouvelle instance de l'application Vue avec le composant de dialogue
        this.dialogInstance = createApp(component, props).mount(dialogContainer);
    },

    closeDialog() {
        if (this.dialogInstance) {
            const container = this.dialogInstance.$el;
            this.dialogInstance.unmount();
            document.body.removeChild(container);
            this.dialogInstance = null;
        }
    }
};
