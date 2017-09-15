<script>
    let drop = new Dropzone('#file', {
        createImageThumbnails: true,
        addRemoveLinks: true,
        url: '{{ route('upload.store', $file) }}',
        headers: {
            'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
        },
        parallelUploads: 2,
        thumbnailMethod: 'crop',
        dictDefaultMessage: "Déposez vos fichiers ici",
        dictFallbackMessage: "Votre navigateur n'est pas compatible",
        dictInvalidFileType: "Impossible de télécharger des fichiers de ce type",
        dictResponseError: "Le serveur a répondu avec le statut {statusCode}",
        dictCancelUpload: "Annuler le téléchargement",
        dictCancelUploadConfirmation: "Êtes-vous certain de vouloir annuler le téléchargement?",
        dictRemoveFile: "Supprimer le fichier",
    });

    @foreach ($file->uploads as $upload)
        drop.emit('addedfile', {
            id: '{{ $upload->id }}',
            name: '{{ $upload->filename }}',
            size: '{{ $upload->size }}'
        });
    @endforeach

    drop.on('success', function (file, response) {
        file.id = response.id;
    });

    drop.on('removedfile', function (file) {
        axios.delete('/{{ $file->identifier }}/upload/' + file.id)
            .catch(function (error) {
                drop.emit('addedfile', {
                    id: file.id,
                    name: file.name,
                    size: file.size
                })
            });
    });
</script>