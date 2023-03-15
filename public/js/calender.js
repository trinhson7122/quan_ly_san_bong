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
                color: eventEl.dataset.color,
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
        initialView: "timeGridWeek",
        timeZone: "Asia/Ho_Chi_Minh",
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
            today: "hôm nay",
        },
        timeZone: "local",
        locale: "vi",
        editable: true,
        dayMaxEvents: true,
        eventMaxStack: 3,
        droppable: true, // this allows things to be dropped onto the calendar
        events: location.origin + "/api/order",
        eventReceive: function (info) {
            //console.log(info.event.extendedProps.football_pitch_id);
            //console.log(info);
            //createOrder(info.event.startStr, info.event.endStr, info.event.extendedProps.football_pitch_id);
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
                },
            });
        },
        eventClick: function (info) {
            // console.log(info.event.id);
            // console.log(info.event.title);
            // console.log(info.event.startStr);
            // console.log(info.event.endStr);
            // console.log(info.event);
            // console.log(info.event.extendedProps.football_pitch_id);
            $.ajax({
                type: "get",
                url: location.origin + "/api/order/" + info.event.id,
                success: function (response) {
                    $("#update-order-modal input[name='name']").val(response.data.name);
                    $("#update-order-modal input[name='email']").val(response.data.email);
                    $("#update-order-modal input[name='phone']").val(response.data.phone);
                    $("#update-order-modal input[name='deposit']").val(response.data.deposit);
                    console.log(response);
                },
            });
            $("#update-order-modal form")[0].dataset.id = info.event.id;
            $("#update-order-modal").modal("show");
        },
        eventChange: function (info) {
            if (
                info.event.startStr != info.oldEvent.startStr ||
                info.event.endStr != info.oldEvent.endStr
            ) {
                let submit = confirm(
                    "Bạn có chắc chắn muốn thay đổi thời gian?"
                );
                if (submit) {
                    updateTimeOrder(
                        info.event.startStr,
                        info.event.endStr,
                        info.event.id
                    );
                }
            }
        },
    });
    calendar.render();
});
