<!-- Modal -->
<div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('order.clientStore') }}">
            @csrf
            <input type="hidden" name="start_at">
            <input type="hidden" name="end_at">
            <input type="hidden" name="football_pitch_id" value="{{ $footballPitch->id }}">
            <div class="modal-content">
                <div class="modal-header bg-success text-light">
                    <h5 class="modal-title" id="exampleModalLabel">Đặt sân</h5>
                    <button type="button" class="btn-close text-light" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div>
                            <div class="row mb-3">
                                <label for="inputDate" class="col-sm-4 col-form-label">Chọn ngày</label>
                                <div class="col-sm-8">
                                    <input type="date" class="datepicker form-control">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputTime" class="col-sm-4 col-form-label">Chọn giờ bắt đầu - kết
                                    thúc</label>
                                <div class="col-sm-8">
                                    <div class="row">
                                        <div class="col mb-3">
                                            <input type="time" class="timepicker form-control">
                                        </div>
                                        <div class="col">
                                            <input type="time" class="timepicker form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label">Họ và tên <span
                                        class="text-danger">(*)</span></label>
                                <div class="col-sm-8">
                                    <input placeholder="tên" required type="text" name="name"
                                        class="form-control">
                                    <div class="text-danger error-name alert-danger error error-hide"></div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label">Số điện thoại <span
                                        class="text-danger">(*)</span></label>
                                <div class="col-sm-8">
                                    <input placeholder="số điện thoại" required type="number" name="phone"
                                        class="form-control">
                                    <div class="text-danger error-phone alert-danger error error-hide"></div>
                                </div>

                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label">Email</label>
                                <div class="col-sm-8">
                                    <input placeholder="email" type="email" name="email" class="form-control">
                                    <div class="text-danger error-email alert-danger error error-hide"></div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="alert alert-danger alert-main error error-hide"></div>
                            </div>
                            <div class="row">
                                <div class="check">
                                    <button type="button" data-url="{{ route('order.check') }}"
                                        class="btn btn-info text-light btn-check-order">Kiểm tra sân</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-success btn-order">Đặt sân</button>
                </div>
            </div>
        </form>
    </div>
</div>
