document.addEventListener("DOMContentLoaded", function () {
    var Calendar = FullCalendar.Calendar;
    var Draggable = FullCalendar.Draggable;

    var containerEl = document.getElementById("external-events");
    var calendarEl = document.getElementById("calendar");

    // initialize the external events
    // -----------------------------------------------------------------

    new Draggable(containerEl, {
        itemSelector: ".fc-event",
        eventData: function (eventEl) {
            return {
                title: eventEl.innerText,
                extendedProps: {
                    football_pitch_id: eventEl.dataset.football_pitch_id,
                },
                duration: "01:00:00",
            };
        },
    });

    // initialize the calendar
    // -----------------------------------------------------------------

    var calendar = new Calendar(calendarEl, {
        initialView: "dayGridMonth",
        timeZone: "Asia/Ho_Chi_Minh",
        nowIndicator: true,
        navLinks: true,
        lazyFetching: true, // false neu muong cap nhat du lieu khi chuyen tab
        headerToolbar: {
            left: "prev,next today",
            center: "title",
            right: "dayGridMonth,timeGridWeek,timeGridDay,listDay",
        },
        buttonText: {
            month: "Tháng",
            week: "Tuần",
            day: "Ngày",
            list: "Danh sách",
            today: "Hôm nay",
        },
        timeZone: "local",
        locale: "vi",
        editable: true,
        eventMaxStack: 7,
        dayMaxEvents: true,
        droppable: true,
        events: location.origin + "/api/order",
        eventReceive: function (info) {
            $.ajax({
                type: "post",
                url: location.origin + "/api/order",
                data: {
                    start_at: info.event.startStr,
                    end_at: info.event.endStr,
                    football_pitch_id:
                        info.event.extendedProps.football_pitch_id,
                    _token: $('meta[name="csrf-token"]').attr("content"),
                    _method: "POST",
                },
                dataType: "json",
                success: function (response) {
                    info.event.setProp("id", response.data.id);
                    $.toast({
                        heading: "Thành công",
                        text: response.message,
                        showHideTransition: "plain",
                        icon: response.status,
                        position: "bottom-right",
                    });
                },
                error: function (response) {
                    info.revert();
                    response = response.responseJSON;
                    $.toast({
                        heading: "Thất bại",
                        text: response.message,
                        showHideTransition: "plain",
                        icon: response.status,
                        position: "bottom-right",
                    });
                },
            });
        },
        eventClick: function (info) {
            $.ajax({
                type: "get",
                url: location.origin + "/api/order/" + info.event.id,
                success: function (response) {
                    $("#update-order-modal input[name='name']").val(
                        response.data.name
                    );
                    $("#update-order-modal input[name='email']").val(
                        response.data.email
                    );
                    $("#update-order-modal input[name='phone']").val(
                        response.data.phone
                    );
                    $("#update-order-modal input[name='deposit']").val(
                        response.data.deposit
                    );
                    //console.log(response);
                },
            });
            $("#update-order-modal form")[0].dataset.id = info.event.id;
            $("#update-order-modal").modal("show");
        },
        eventChange: function (info) {
            console.log(info);
            if (
                info.event.startStr != info.oldEvent.startStr ||
                info.event.endStr != info.oldEvent.endStr
            ) {
                let submit = confirm(
                    "Bạn có chắc chắn muốn thay đổi thời gian?"
                );
                if (submit) {
                    $.ajax({
                        type: "post",
                        url: location.origin + "/api/order/" + info.event.id,
                        data: {
                            type: "update_time",
                            start_at: info.event.startStr,
                            end_at: info.event.endStr,
                            _token: $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                            _method: "PUT",
                        },
                        dataType: "json",
                        success: function (response) {
                            $.toast({
                                heading: "Thành công",
                                text: response.message,
                                showHideTransition: "plain",
                                icon: response.status,
                                position: "bottom-right",
                            });
                        },
                        error: function (response) {
                            console.log(response.responseJSON);
                            info.revert();
                            response = response.responseJSON;
                            $.toast({
                                heading: "Thất bại",
                                text: response.message,
                                showHideTransition: "plain",
                                icon: response.status,
                                position: "bottom-right",
                            });
                        },
                    });
                } else {
                    info.revert();
                }
            }
        },
    });
    calendar.render();

    $(document).on('click', '.btn-update-order', function () {
        const form = $("#update-order-modal form");
        //form.submit();
        $.ajax({
            type: "post",
            url: location.origin + "/api/order/" + form.data('id'),
            data: form.serialize(),
            dataType: "json",
            success: function (response) {
                $.toast({
                    heading: "Thành công",
                    text: response.message,
                    showHideTransition: "plain",
                    icon: response.status,
                    position: "bottom-right",
                });
                calendar.refetchEvents();
                $('#update-order-modal').modal('hide');
            },
            error: function (response) {
                $('#update-order-modal').modal('hide');
                console.log(response.responseJSON);
                info.revert();
                response = response.responseJSON;
                $.toast({
                    heading: "Thất bại",
                    text: response.message,
                    showHideTransition: "plain",
                    icon: response.status,
                    position: "bottom-right",
                });
            },
        });
    });
});
