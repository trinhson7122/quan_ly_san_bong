@extends('client.extend')
@section('client_content')
    @include('client.layouts.section')
    <main id="main">
        @include('client.layouts.service')
        <!-- ======= Portfolio Section ======= -->
        <section id="portfolio" class="portfolio">
            <div class="container" data-aos="fade-up">

                <div class="section-title">
                    <h2>Sân bóng</h2>
                    <p>Danh sách các sân bóng hiện có</p>
                </div>

                <ul id="portfolio-flters" class="d-flex justify-content-center" data-aos="fade-up" data-aos-delay="100">
                    <li data-filter="*" class="filter-active">Tất cả</li>
                    <li data-filter=".filter-not-maintain">Hoạt động</li>
                    <li data-filter=".filter-maintain">Bảo trì</li>
                </ul>

                <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="200">

                    @foreach ($footballPitches as $item)
                        <div
                            class="col-lg-4 col-md-6 portfolio-item @if ($item->is_maintenance) filter-maintain @else filter-not-maintain @endif">
                            <div class="portfolio-img">
                                @if ($item->images->count() > 0)
                                    <img src="{{ config('app.image') . $item->images[0]->image }}" class="img-fluid"
                                        alt="">
                                @else
                                    <img src="{{ config('app.image') . 'images/football_pitches/default_football_pitch.png' }}"
                                        class="img-fluid" alt="">
                                @endif
                            </div>
                            <div class="portfolio-info">
                                @if ($item->is_maintenance)
                                    <h4 class="text-danger">{{ $item->name }} - {{ $item->pitchType->quantity }} người
                                    </h4>
                                    <p class="text-danger">{{ $item->pricePerHour() }} - {{ $item->pricePerPeakHour() }}</p>
                                    <p class="text-danger">Bảo trì</p>
                                @else
                                    <h4>{{ $item->name }} - {{ $item->pitchType->quantity }} người</h4>
                                    <p>{{ $item->pricePerHour() }} - {{ $item->pricePerPeakHour() }}</p>
                                    <p>Hoạt động</p>
                                @endif
                                @if ($item->images->count() > 0)
                                    <a href="{{ config('app.image') . $item->images[0]->image }}"
                                        data-gallery="portfolioGallery" class="portfolio-lightbox preview-link"
                                        title="{{ $item->name }} - {{ $item->pitchType->quantity }} người"><i class="bi bi-eye-fill"></i></a>
                                @else
                                    <a href="{{ config('app.image') . 'images/football_pitches/default_football_pitch.png' }}"
                                        data-gallery="portfolioGallery" class="portfolio-lightbox preview-link"
                                        title="{{ $item->name }} - {{ $item->pitchType->quantity }} người"><i class="bi bi-eye-fill"></i></a>
                                @endif
                                <a href="{{ route('client.footballPitchDetail', $item->id) }}" class="details-link" title="Chi tiết"><i
                                        class="bi bi-cart-plus-fill"></i></a>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </section><!-- End Portfolio Section -->

        @include('client.layouts.aboutUs')
    </main><!-- End #main -->
@endsection
