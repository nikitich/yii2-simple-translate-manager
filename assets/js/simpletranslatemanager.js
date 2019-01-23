yii.confirm = function (message, okCallback, cancelCallback) {
    swal({
        title: message,
        type: 'warning',
        showCancelButton: true,
        closeOnConfirm: true,
        allowOutsideClick: true
    }, okCallback);
};


$('#stmimportuploadform-translationsfile').on('fileuploaded', function (event, data) {
    var response = data.response;

    if (response.status === true) {
        $.LoadingOverlay("show");
        var current = document.location.href;
        location.href = current + '/'+ response.path +'?'+ response.key +'=' + response.filename;
    }
});