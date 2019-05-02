$(document).on('submit', "#ajouter-commentaire", function (e) {
    e.preventDefault();
    var $form = $(this);
    var $formInput = $($form, ':input');
    var action = $form.attr('action');
    var data = new FormData($form[0]);

    $form.find("button[type='submit']").prop("disabled", true);
    $formInput.prop("disabled", true);

    $.ajax({
        type: 'post',
        dataType: 'json',
        data: data,
        url: action,
        success: function (response) {
            console.log(response.success);
            if (response.success === false) {
                // affficher messsage erreur
                $form.find("button[type='submit']").prop("disabled", false);
                $formInput.prop("disabled", false);
            } else if (response.success === true) {
                $('#message-commentaire').val('');
                $('.tt').before(response.view);
            }
        },
        error: function (XHR, status, error) {
            $form.find("button[type='submit']").prop("disabled", false);
            $formInput.prop("disabled", false);
            alert(error + XHR + status);
        },
        cache: false,
        contentType: false,
        processData: false

    });

});
