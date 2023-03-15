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

function updateTimeOrder(start, end, id)
{
    $.ajax({
        type: "post",
        url: location.origin + '/api/order/' + id,
        data: {
            type: 'update_time',
            start_at: start,
            end_at: end,
            _token: $('meta[name="csrf-token"]').attr('content'),
            _method: "PUT"
        },
        dataType: "json",
        success: function (response) {
            console.log(response);
        }
    });
}

// function createOrder(start, end, id)
// {
//     let data;
//     $.ajax({
//         type: "post",
//         url: location.origin + '/api/order',
//         data: {
//             start_at: start,
//             end_at: end,
//             football_pitch_id: id,
//             _token: $('meta[name="csrf-token"]').attr('content'),
//             _method: "POST"
//         },
//         dataType: "json",
//         success: function (response) {
//             data = response;
//         }
//     });
//     return data;
// }

function updateOrder(id, data)
{
    $.ajax({
        type: "put",
        url: location.origin + '/api/order/' + id,
        data: {
            start_at: start,
            end_at: end,
            _token: $('meta[name="csrf-token"]').attr('content'),
            _method: "PUT"
        },
        dataType: "json",
        success: function (response) {
            
        }
    });
}