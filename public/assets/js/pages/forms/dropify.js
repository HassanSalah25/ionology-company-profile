$(function() {
    "use strict";
    $('.dropify').dropify();

    var drEvent = $('#dropify-event').dropify();
    var url_remove = $('#dropify-event').data('url-remove');
    drEvent.on('dropify.beforeClear', function(event, element) {
        return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
    });

    drEvent.on('dropify.afterClear', function(event, element) {
        $.ajax({
            type: 'GET',
            url: url_remove,
            success: function(response){
                alert(response.message);
            },
            error: function(xhr, status, error) {
                alert('An error occurred while deleting the image');
            }
        })
    });

    $('.dropify-fr').dropify({
        messages: {
            default: 'Glissez-déposez un fichier ici ou cliquez',
            replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
            remove: 'Supprimer',
            error: 'Désolé, le fichier trop volumineux'
        }
    });
});
