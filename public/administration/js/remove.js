$(document).ready(function () {

    $(document).on('click', ".confirm-supp", function (e) {
        e.preventDefault();
        var route = $(this).attr('href');

        bootbox.dialog({
            title: '<i class="fa fa-exclamation-triangle" style="color: brown"></i> Confirmation',
            message: 'Etez-vous sûre de supprimer ceci ?',
            className: 'my-class',
            buttons: {
                cancel: {
                    className: 'btn btn-default',
                    label: 'Fermer'
                },
                success: {
                    className: 'fa fa-trash-o btn btn-danger',
                    label: ' Supprimer',
                    callback: function () {
                       window.location = route;

                    }
                }
            }
        });
    });

});