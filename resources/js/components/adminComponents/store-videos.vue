<script>
import Resumable from 'resumablejs';

export default {
    data() {
        return {
            resumable: null,
        };
    },
    mounted() {
        this.resumable = new Resumable({
            target: 'api/upload-advanced',
            chunkSize: 2 * 1024 * 1024, // Taille des morceaux à 2 MB
            simultaneousUploads: 1, // Réduire les téléversements simultanés à 1
            testChunks: false,
            throttleProgressCallbacks: 1,
            dropTarget: document.getElementById('drop-area'),
        });

        // Écouteur pour la progression du téléversement d'un fichier
        this.resumable.on('fileProgress', (file) => {
            console.log('Progress', file.fileName, file.progress());
        });

        // Écouteur pour le succès du téléversement d'un fichier
        this.resumable.on('fileSuccess', (file, message) => {
            console.log('File success', file.fileName, message);
        });

        // Écouteur pour une erreur lors du téléversement d'un fichier
        this.resumable.on('fileError', (file, message) => {
            console.log('File error', file.fileName, message);
            // Implémentez ici une logique de réessai, par exemple avec un délai
            setTimeout(() => {
                this.resumable.upload(); // Réessayer l'upload
            }, 30000); // Attendre 30 secondes avant de réessayer
        });

        // Écouteur pour l'ajout d'un fichier
        this.resumable.on('fileAdded', (file, event) => {
            console.log('File added', file.fileName);
            this.resumable.upload(); // Commence l'upload directement après l'ajout
        });
    },
    methods: {
        handleFiles(event) {
            const files = event.target.files;
            for (let i = 0; i < files.length; i++) {
                this.resumable.addFile(files[i]);
            }
        },
        handleDragOver(event) {
            // Vous pouvez ajouter une logique supplémentaire pour gérer le survol
        },
        handleDrop(event) {
            // Ajoute les fichiers déposés à Resumable pour l'upload
            event.dataTransfer.files.forEach(file => {
                this.resumable.addFile(file);
            });
        },
    },
};
</script>

<template>
    <div>
        <!-- Input pour sélectionner les fichiers -->
        <input type="file" @change="handleFiles" multiple>
        <!-- Vous pouvez aussi ajouter un drop area pour le glisser-déposer -->
        <div id="drop-area" @dragover.prevent="handleDragOver" @drop.prevent="handleDrop" style="border: 2px dashed #ccc; padding: 20px; text-align: center;">
            Glissez et déposez vos fichiers ici
        </div>
    </div>
</template>

<style scoped>

</style>
