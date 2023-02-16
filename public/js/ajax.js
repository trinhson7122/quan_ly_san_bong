function getPitchType(url)
{
    $.ajax({
        type: "get",
        url: url,
        success: function (response) {
            $('#update-pitch-type-modal input[name=quantity]').val(response.quantity);
            $('#update-pitch-type-modal textarea[name=description]').html(response.description);
        }
    });
}