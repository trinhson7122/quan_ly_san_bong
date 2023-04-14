$(document).ready(function () {
    const DatePicker = $("#orderModal .datepicker");
    const TimePicker = $("#orderModal .timepicker");
    const DatePickerFindTimeModal = $("#findTimeModal .datepicker");
    const now = new Date();
    const arrDate = now.toLocaleDateString().split("/").reverse();
    if (arrDate[1] < 10) {
        arrDate[1] = "0" + arrDate[1];
    }
    if (arrDate[2] < 10) {
        arrDate[2] = "0" + arrDate[2];
    }
    const date = arrDate.join("-");
    DatePicker[0].value = date;
    TimePicker[0].value = "07:00:00";
    TimePicker[1].value = "08:00:00";
    //
    DatePickerFindTimeModal[0].value = date;

    $(document).on("click", "#orderModal .btn-order", function () {
        const start = DatePicker[0].value + " " + TimePicker[0].value;
        const end = DatePicker[0].value + " " + TimePicker[1].value;
        const form = $(this).parents("form");
        const error = form.find(".alert-main");
        const modal = $("#orderModal");
        const er_name = form.find('.error-name');
        const er_phone = form.find('.error-phone');
        const er_email = form.find('.error-email');
        //console.log(error);
        $('input[name="start_at"]')[0].value = start;
        $('input[name="end_at"]')[0].value = end;
        $.ajax({
            type: "post",
            url: form.attr("action"),
            data: form.serialize(),
            dataType: "json",
            success: function (response) {
                modal.modal("hide");
                error[0].classList.remove("error-show");
                $.toast({
                    heading: "Thành công",
                    text: response.message,
                    showHideTransition: "plain",
                    icon: response.status,
                    position: "bottom-right",
                });
                setTimeout(function () {
                    location.href = response.redirect;
                }, 3000);
            },
            error: function (response) {
                response = response.responseJSON;
                er_name[0].classList.add("error-hide");
                er_name[0].classList.remove("error-show");
                er_phone[0].classList.add("error-hide");
                er_phone[0].classList.remove("error-show");
                er_phone[0].classList.add("error-hide");
                er_email[0].classList.remove("error-show");
                if (response.errors) {
                    if (response.errors.name) {
                        er_name[0].classList.add("error-show");
                        er_name[0].textContent = response.errors.name;
                    }
                    if (response.errors.phone) {
                        er_phone[0].classList.add("error-show");
                        er_phone[0].textContent = response.errors.phone;
                    }
                    if (response.errors.email) {
                        er_email[0].classList.add("error-show");
                        er_email[0].textContent = response.errors.email;
                    }
                }
                else {
                    error[0].classList.add("error-show");
                    error[0].textContent = response.message;
                }
            },
        });
    });

    //check san trong hay khong
    $(document).on("click", ".btn-check-order", function () {
        const start = DatePicker[0].value + " " + TimePicker[0].value;
        const end = DatePicker[0].value + " " + TimePicker[1].value;
        const id = $('#orderModal input[name="football_pitch_id"]')[0].value;
        const error = $("#orderModal .alert-main");
        $.ajax({
            type: "get",
            url: $(this).data("url"),
            data: {
                football_pitch_id: id,
                start_at: start,
                end_at: end,
            },
            dataType: "json",
            success: function (response) {
                error[0].classList.add("error-show");
                error[0].classList.add("alert-success");
                error[0].classList.remove("alert-danger");
                error[0].innerHTML = response.message;
                if (response.total_price) {
                    error[0].innerHTML += `<br>Giá tiền: ${response.total_price}`;
                }
            },
            error: function (response) {
                response = response.responseJSON;
                error[0].classList.add("error-show");
                error[0].textContent = response.message;
            },
        });
    });
    //tim san trong
    $(document).on("click", ".btn-find-time", function () {
        const form = $(this).parents("form");
        const error = form.find(".error");
        const el = form.find(".order-time");
        el.html("");
        error[0].classList.add("error-hide");
        error[0].classList.remove("error-show");
        $.ajax({
            type: "get",
            url: form.attr("action"),
            data: form.serialize(),
            dataType: "json",
            success: function (response) {
                if (response.message) {
                    error[0].classList.add("error-show");
                    error[0].classList.add("alert-success");
                    error[0].classList.remove("alert-danger");
                    error[0].textContent = response.message;
                }
                if (response.data) {
                    let content = "";
                    for (i in response.data) {
                        content += `<div class="col-5">${response.data[i].start_at}</div>`;
                        content += `<div class="col-2"><i class="bi bi-arrow-right"></i></div>`;
                        content += `<div class="col-5">${response.data[i].end_at}</div>`;
                    }
                    el.append(content);
                }
            },
            error: function (response) {
                response = response.responseJSON;
                error[0].classList.add("error-show");
                error[0].textContent = response.message;
            },
        });
    });
});
