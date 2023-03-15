@extends('admin.extend')
@section('admin_content')
    <main id="main" class="main">
        {{-- Tiêu đề --}}
        <div class="pagetitle">
            <h1>Quản lý sân bóng</h1>
        </div>
        {{ Breadcrumbs::render('footballPitch') }}
        @include('admin.layouts.alert')
        {{-- Body --}}
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Sân bóng</h5>
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" 
                        data-bs-target="#add-football-pitch-type-modal">Thêm sân bóng
                    </button>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tên</th>
                                <th scope="col">Số người</th>
                                <th scope="col">Bắt đầu lúc</th>
                                <th scope="col">Kết thúc lúc</th>
                                <th scope="col">Giá/giờ</th>
                                <th scope="col">Giá/giờ cao điểm</th>
                                <th scope="col">Tình trạng</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($footballPitches as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->pitchType->quantity }}</td>
                                    <td>{{ $item->timeStart() }}</td>
                                    <td>{{ $item->timeEnd() }}</td>
                                    <td>{{ $item->pricePerHour() }}</td>
                                    <td>{{ $item->pricePerPeakHour() }}</td>
                                    <td>
                                        @if ($item['is_maintenance'])
                                            <div class="text-danger">Bảo trì</div>
                                        @else
                                            <div class="text-success">Hoạt động</div>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.footballPitchDetail', $item['id']) }}" class="btn btn-info">Xem</a>
                                    </td>
                                    <td>
                                        <form action="{{ route('footballPitch.maintenance', $item['id']) }}" method="post">
                                            @csrf
                                            @method('put')
                                            @if ($item['is_maintenance'])
                                            <input type="hidden" name="is_maintenance" value="0">
                                            <button type="submit" class="btn btn-success">Dừng bảo trì</button>
                                            @else
                                            <input type="hidden" name="is_maintenance" value="1">
                                            <button type="submit" class="btn btn-warning">Bảo trì sân</button>
                                            @endif
                                        </form>
                                    </td>
                                    <td>
                                        <form action="{{ route('footballPitch.destroy', $item['id']) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button class="confirm-btn btn btn-danger">Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
        {{-- modal thêm --}}
        <div class="modal fade" id="add-football-pitch-type-modal" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('footballPitch.store') }}" method="POST">
                        @csrf
                        <div class="modal-header bg-success text-light">
                            <h5 class="modal-title text-light">Thêm loại sân bóng</h5> 
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-4 col-form-label">
                                    Tên sân <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-8">
                                <input required type="text" name="name" class="form-control">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputEmail" class="col-sm-6 col-form-label">
                                    Thời gian mở <span class="text-danger">*</span>
                                    <select name="time_start" class="form-select" aria-label="Default select example">
                                        <option value="1:00:00" selected>1:00:00</option>
                                        <script>
                                            for(i = 2; i <= 24; i++){
                                                document.write('<option value="'+i+':00:00">'+i+':00:00</option>');
                                            }
                                        </script>
                                    </select>
                                </label>
                                <label for="inputEmail" class="col-sm-6 col-form-label">
                                    Thời gian đóng <span class="text-danger">*</span>
                                    <select name="time_end" class="form-select" aria-label="Default select example">
                                        <option value="1:00:00" selected>1:00:00</option>
                                        <script>
                                            for(i = 2; i <= 24; i++){
                                                document.write('<option value="'+i+':00:00">'+i+':00:00</option>');
                                            }
                                        </script>
                                    </select>
                                </label>
                            </div>
                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-4 col-form-label">
                                    Loại sân <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-8">
                                    <select name="pitch_type_id" class="form-select" aria-label="Default select example">
                                        @foreach ($pitchTypes as $item)
                                            <option value="{{ $item->id }}" @if($loop->first) selected @endif>{{ $item->quantity }} ({{ $item->description }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-4 col-form-label">
                                    Giá theo giờ <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-8">
                                <input required value="500000" type="number" name="price_per_hour" class="form-control">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-4 col-form-label">
                                    Giá theo giờ cao điểm <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-8">
                                <input required value="600000" type="number" name="price_per_peak_hour" class="form-control">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-4 col-form-label">
                                    Mô tả
                                </label>
                                <div class="col-sm-8">
                                <textarea type="text" name="description" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-12 col-form-label">
                                    Nếu sân là sân ghép thì điền - vd: sân 11 gép từ 2 sân 7
                                </label>
                                <div class="row bm-3">
                                    <label for="inputText" class="col-sm-6 col-form-label">
                                        Gép từ sân
                                        <select name="from_football_pitch_id" class="form-select" aria-label="Default select example">
                                            <option value="" selected></option>
                                            @foreach ($footballPitches as $item)
                                                <option value="{{ $item['id'] }}">{{ $item['name'] }} (#{{ $item['id'] }})</option>
                                            @endforeach
                                        </select>
                                    </label>
                                    <label for="inputText" class="col-sm-6 col-form-label">
                                        Với sân
                                        <select name="to_football_pitch_id" class="form-select" aria-label="Default select example">
                                            <option value="" selected></option>
                                            @foreach ($footballPitches as $item)
                                                <option value="{{ $item['id'] }}">{{ $item['name'] }} (#{{ $item['id'] }})</option>
                                            @endforeach
                                        </select>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer"> 
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button> 
                            <button type="submit" class="btn btn-success">Thêm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection