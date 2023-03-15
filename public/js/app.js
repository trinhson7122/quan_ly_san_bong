$(document).ready(function () {
    $('.confirm-btn').click(function (e) { 
        const result = confirm('Bạn có chắc chắn không ?');
        if(!result){
            e.preventDefault();
        }
    });
    $(document).on('click', '.btn-update-pitch-type', function () {
        getPitchType($(this).data('url_get'));
        $('#update-pitch-type-modal form').attr('action', $(this).data('url_set'));
    });
    $(document).on('click', '.btn-update-order', function () {
        const form = $("#update-order-modal form");
        form.attr('action', "/api/order/" + form.data('id'));
        form.submit();
    });
});