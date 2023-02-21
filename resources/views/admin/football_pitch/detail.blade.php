@extends('admin.extend')
@section('admin_content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Chi tiết sân bóng</h1>
        </div>
        @if (session()->has('message'))
            <div class="alert alert-success">{{ session()->get('message') }}</div>
        @endif
        @if ($errors->any())
            @foreach ($errors->all() as $item)
                <div class="alert alert-danger">{{ $item }}</div>
            @endforeach
        @endif
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title @if($footballPitch['is_maintenance']) text-danger @else text-success @endif">Thông tin - {{ $footballPitch['name'] }} - 
                        @if($footballPitch['is_maintenance']) Đang bảo trì @else Đang hoạt động @endif</h5>
                    {{-- <button type="button" class="btn btn-success" data-bs-toggle="modal" 
                        data-bs-target="#add-football-pitch-type-modal">Thêm sân bóng
                    </button> --}}
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div id="carouselFootballPitch" class="carousel slide" data-bs-ride="carousel">
                                @if (count($footballPitchDetails) > 0)  
                                    <div class="carousel-indicators">
                                        @foreach ($footballPitchDetails as $item)
                                            <button type="button" data-bs-target="#carouselExampleIndicators" 
                                            data-bs-slide-to="{{ $item['index'] }}" class="@if($loop->first) active @endif" 
                                            aria-label="Slide {{ $item['index']+1 }}" aria-current="@if($loop->first) true @endif">
                                            </button>
                                        @endforeach
                                    </div>
                                  <div class="carousel-inner">
                                    @foreach ($footballPitchDetails as $item)
                                        <div class="carousel-item @if($loop->first) active @endif">
                                            <img src="{{ config('app.url') . $item['image'] }}" class="d-block w-100" alt="...">
                                        </div>
                                    @endforeach
                                  </div>
                  
                                  <button class="carousel-control-prev" type="button" data-bs-target="#carouselFootballPitch" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                  </button>
                                  <button class="carousel-control-next" type="button" data-bs-target="#carouselFootballPitch" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                  </button>
                                @else
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <img src="{{ config('app.url') . '/storage/images/football_pitches/default_football_pitch.png' }}" class="d-block w-100" alt="...">
                                        </div>
                                    </div>
                                @endif
                              </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card">
                                <div class="card-body pt-3">
                                  <!-- Bordered Tabs -->
                                  <ul class="nav nav-tabs nav-tabs-bordered" role="tablist">
                    
                                    <li class="nav-item" role="presentation">
                                      <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#football-pitch-overview" 
                                      aria-selected="true" role="tab">Tổng quan</button>
                                    </li>
                    
                                    <li class="nav-item" role="presentation">
                                      <button class="nav-link" data-bs-toggle="tab" data-bs-target="#football-pitch-images" 
                                      aria-selected="false" role="tab" tabindex="-1">Hình ảnh</button>
                                    </li>
                    
                                    <li class="nav-item" role="presentation">
                                      <button class="nav-link" data-bs-toggle="tab" data-bs-target="#football-pitch-edit" 
                                      aria-selected="false" role="tab" tabindex="-1">Chỉnh sửa sân bóng</button>
                                    </li>
                    
                                  </ul>
                                  <div class="tab-content pt-2 profile">
                    
                                    <div class="tab-pane fade profile-overview active show" id="football-pitch-overview" role="tabpanel">
                                      <h5 class="card-title">Mô tả</h5>
                                      <p class="small fst-italic">{{ $footballPitch['description'] }}</p>
                    
                                      <h5 class="card-title">Thông tin</h5>
                    
                                      <div class="row">
                                        <div class="col-lg-6 col-md-4 label">Thời gian bắt đầu - kết thúc</div>
                                        <div class="col-lg-6 col-md-8">{{ $footballPitch['time_start'] }} - {{ $footballPitch['time_end'] }}</div>
                                      </div>

                                      <div class="row">
                                        <div class="col-lg-6 col-md-4 label">Số người</div>
                                        <div class="col-lg-6 col-md-8">{{ $footballPitch['pitch_type'] }}</div>
                                      </div>

                                      <div class="row">
                                        <div class="col-lg-6 col-md-4 label">Giá / giờ</div>
                                        <div class="col-lg-6 col-md-8">{{ $footballPitch['price_per_hour'] }}</div>
                                      </div>

                                      <div class="row">
                                        <div class="col-lg-6 col-md-4 label">Giá / giờ cao điểm</div>
                                        <div class="col-lg-6 col-md-8">{{ $footballPitch['price_per_peak_hour'] }}</div>
                                      </div>

                                      <div class="row">
                                        <div class="col-lg-6 col-md-4 label">Sân liên kết</div>
                                        <div class="col-lg-6 col-md-8">{{ $footballPitch['link_football_pitch'] }}</div>
                                      </div>

                                      <div class="row">
                                        <div class="col-lg-6 col-md-4 label">Tạo lúc</div>
                                        <div class="col-lg-6 col-md-8">{{ $footballPitch['created_at'] }}</div>
                                      </div>
                    
                                    </div>
                    
                                    <div class="tab-pane fade profile-edit pt-3" id="football-pitch-images" role="tabpanel">
                    
                                        <button class="btn btn-success mr-3">
                                            Thêm ảnh
                                        </button>
                                        <table class="table">
                                            <tbody>
                                                @foreach ($footballPitchDetails as $item)
                                                    <tr>
                                                        <td><img src="{{ $item['image'] }}" width="100" alt="..."></td>
                                                        <td>Thêm lúc: {{ $item['created_at'] }}</td>
                                                        <td>
                                                            <form action="" method="post">
                                                                @csrf
                                                                @method('delete')
                                                                <button class="btn btn-danger">Xóa</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                    
                                    </div>
                    
                                    <div class="tab-pane fade pt-3" id="football-pitch-edit" role="tabpanel">
                    
                                      <!-- Settings Form -->
                                      <form>
                    
                                        <div class="row mb-3">
                                          <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Email Notifications</label>
                                          <div class="col-md-8 col-lg-9">
                                            <div class="form-check">
                                              <input class="form-check-input" type="checkbox" id="changesMade" checked="">
                                              <label class="form-check-label" for="changesMade">
                                                Changes made to your account
                                              </label>
                                            </div>
                                            <div class="form-check">
                                              <input class="form-check-input" type="checkbox" id="newProducts" checked="">
                                              <label class="form-check-label" for="newProducts">
                                                Information on new products and services
                                              </label>
                                            </div>
                                            <div class="form-check">
                                              <input class="form-check-input" type="checkbox" id="proOffers">
                                              <label class="form-check-label" for="proOffers">
                                                Marketing and promo offers
                                              </label>
                                            </div>
                                            <div class="form-check">
                                              <input class="form-check-input" type="checkbox" id="securityNotify" checked="" disabled="">
                                              <label class="form-check-label" for="securityNotify">
                                                Security alerts
                                              </label>
                                            </div>
                                          </div>
                                        </div>
                    
                                        <div class="text-center">
                                          <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </div>
                                      </form><!-- End settings Form -->
                    
                                    </div>
                    
                                  </div><!-- End Bordered Tabs -->
                    
                                </div>
                              </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection