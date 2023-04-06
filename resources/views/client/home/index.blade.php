@extends('client.extend')
@section('client_content')
    <main id="main" class="main">
        <div class="slider">
            <div class="card">
                <div id="carouselFootballPitch" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselFootballPitch" data-bs-slide-to="0" class=""
                            aria-label="Slide 1">
                        </button>
                        <button type="button" data-bs-target="#carouselFootballPitch" data-bs-slide-to="1" class="active"
                            aria-label="Slide 2" aria-current="true">
                        </button>
                        <button type="button" data-bs-target="#carouselFootballPitch" data-bs-slide-to="2" class=""
                            aria-label="Slide 3" aria-current="">
                        </button>
                        <button type="button" data-bs-target="#carouselFootballPitch" data-bs-slide-to="3" class=""
                            aria-label="Slide 4" aria-current="">
                        </button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item">
                            <img src="http://127.0.0.1:8000/storage/images/football_pitches/sb1.jpg" class="d-block w-100"
                                alt="...">
                        </div>
                        <div class="carousel-item active">
                            <img src="http://127.0.0.1:8000/storage/images/football_pitches/sb2.jpg" class="d-block w-100"
                                alt="...">
                        </div>
                        <div class="carousel-item ">
                            <img src="http://127.0.0.1:8000/storage/images/football_pitches/football_pitch1678797612.jpg"
                                class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item ">
                            <img src="http://127.0.0.1:8000/storage/images/football_pitches/sb2.jpg"
                                class="d-block w-100" alt="...">
                        </div>
                    </div>

                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselFootballPitch"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselFootballPitch"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
        <div class="pagetitle">
            <h2>Sân bóng được đặt nhiều</h2>
        </div>
        <div class="container-fluid1 text-center">
            <div class="row justify-content-center">
                <div id="recipeCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner" role="listbox">
                        <div class="carousel-item active">
                            <div class="col-md-3 mr-3">
                                <div class="card">
                                    <div class="card-img">
                                        <img src="https://via.placeholder.com/700x500.png/CB997E/333333?text=1"
                                            class="img-fluid">
                                    </div>
                                    <div class="card-img-overlay">Slide 1</div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="col-md-3">
                                <div class="card">
                                    <div class="card-img">
                                        <img src="https://via.placeholder.com/700x500.png/DDBEA9/333333?text=2"
                                            class="img-fluid">
                                    </div>
                                    <div class="card-img-overlay">Slide 2</div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="col-md-3">
                                <div class="card">
                                    <div class="card-img">
                                        <img src="https://via.placeholder.com/700x500.png/FFE8D6/333333?text=3"
                                            class="img-fluid">
                                    </div>
                                    <div class="card-img-overlay">Slide 3</div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="col-md-3">
                                <div class="card">
                                    <div class="card-img">
                                        <img src="https://via.placeholder.com/700x500.png/B7B7A4/333333?text=4"
                                            class="img-fluid">
                                    </div>
                                    <div class="card-img-overlay">Slide 4</div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="col-md-3">
                                <div class="card">
                                    <div class="card-img">
                                        <img src="https://via.placeholder.com/700x500.png/A5A58D/333333?text=5"
                                            class="img-fluid">
                                    </div>
                                    <div class="card-img-overlay">Slide 5</div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="col-md-3">
                                <div class="card">
                                    <div class="card-img">
                                        <img src="https://via.placeholder.com/700x500.png/6B705C/eeeeee?text=6"
                                            class="img-fluid">
                                    </div>
                                    <div class="card-img-overlay">Slide 6</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a class="carousel-control-prev bg-transparent w-aut" href="#recipeCarousel" role="button"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    </a>
                    <a class="carousel-control-next bg-transparent w-aut" href="#recipeCarousel" role="button"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    </a>
                </div>
            </div>
        </div>
        <div class="pagetitle">
            <h2>Sân bóng</h2>
        </div>
        <section class="section">
            <div class="row">
                @foreach ($footballPitches as $item)
                    <div class="col-xxl-3 col-lg-4 col-md-6 football-pitch-hover">
                        <div class="card info-card">
                            <a href="#">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $item->name }} <span>|
                                            {{ $item->pitchType->quantity }} người/đội</span>
                                        @if ($item->is_maintenance)
                                            <span class="badge bg-danger text-white">Đang bảo trì</span>
                                        @endif
                                    </h5>
                                    @if ($item->is_maintenance)
                                        <div class="maintain"><img
                                                src="{{ config('app.image') . asset('images/football_pitches/default_football_pitch.png') }}"
                                                alt="" class="img-fluid">
                                        </div>
                                    @else
                                        <img src="{{ config('app.image') . asset('images/football_pitches/default_football_pitch.png') }}"
                                            alt="" class="img-fluid">
                                    @endif
                                    <div class="card-price text-center mt-2">
                                        <span class="name-price text-black mr-5">Giá:</span>
                                        <span class="text-danger fw-bold price">{{ $item->pricePerHour() }} -
                                            {{ $item->pricePerPeakHour() }}</span>
                                    </div>
                                </div>
                            </a>

                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </main>
@endsection
