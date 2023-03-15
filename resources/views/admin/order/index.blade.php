@extends('admin.extend')
@section('admin_content')
<main id="main" class="main">
    {{-- Tiêu đề --}}
    <div class="pagetitle">
        <h1>Quản lý đặt sân</h1>
    </div>
    {{ Breadcrumbs::render('order') }}
    @include('admin.layouts.alert')
    {{-- Body --}}
    <section class="section">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-2">
                        <div id="external-events" class="mt-3">
                            <p>
                                <strong>Kéo các sân bên dưới vào lịch để đặt sân</strong>
                            </p>
                              
                              @foreach ($footballPitches as $item)
                                <div data-football_pitch_id="{{ $item->id }}" class='mb-1 p-1 fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event'>
                                    <div class='fc-event-main'>{{ $item->name . ' - ' .  $item->pitchType->quantity }} người</div>
                                </div>
                              @endforeach
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div id='calendar-container'>
                            <div id='calendar'></div>
                          </div>
                    </div> <!-- end col -->
                </div>  <!-- end row -->
            </div> <!-- end card body-->
        </div>
    </div>
    {{-- Model sửa yêu cầu --}}
    <div class="modal fade" id="update-order-modal" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form data-id="0" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="type" value="update_order">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title">Cập nhật yêu cầu</h5> 
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-4 col-form-label">
                                Họ tên người đặt <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-8">
                            <input required type="text" name="name" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-4 col-form-label">
                                Số điện thoại <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-8">
                            <input required type="number" name="phone" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-4 col-form-label">
                                Email
                            </label>
                            <div class="col-sm-8">
                            <input type="text" name="email" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-4 col-form-label">
                                Tiền cọc <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-8">
                            <input required type="number" name="deposit" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer"> 
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button> 
                        <button type="button" class="btn-update-order btn btn-warning">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection