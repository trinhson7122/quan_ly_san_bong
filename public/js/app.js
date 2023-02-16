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
});