$(document).on('click', "#add-to-list", function (e) {
    e.preventDefault();
    var url = $(this).attr('data-href');
    $(this).hide();
    $(this).nextAll('#remove-from-list').show();
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: url,
        success: function () {
            console.log('Success');
        },
        error: function (XHR, status, error) {
            $(this).show();
            $(this).nextAll('#remove-from-list').hide();
            console.log(XHR);
            console.log(status);
            console.log(error);
            alert('erreur');
        }
    });
});

$(document).on('click', "#remove-from-list", function (e) {
    e.preventDefault();
    var url = $(this).attr('data-href');
    $(this).hide();
    $(this).prev('#add-to-list').show();

    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: url,
        success: function () {
            console.log('Success');
        },
        error: function (XHR, status, error) {
            $(this).show();
            $(this).prev('#add-to-list').hide();
            console.log(XHR);
            console.log(status);
            console.log(error);
            alert('erreur');
        }
    });
});
