<!-- ======= Header ======= -->
<header id="header" class="fixed-top">
    <div class="container d-flex align-items-center">

        <h1 class="logo me-auto"><a href="{{ route('client.index') }}">{{ config('app.name') }}</a></h1>

        <nav id="navbar" class="navbar">
            <ul>
                <li><a class="nav-link scrollto active" href="#hero">Trang chủ</a></li>
                <li><a class="nav-link scrollto" href="#services">Dịch vụ</a></li>
                <li><a class="nav-link scrollto" href="#portfolio">Sân bóng</a></li>
                <li><a class="nav-link scrollto" href="#about">Về chúng tôi</a></li>
                @guest
                    <li><a class="getstarted" href="#about1">Đăng nhập</a></li>
                    <li><a class="getstarted" href="#about1">Đăng ký</a></li>
                @endguest
                @auth
                    <li class="dropdown">
                        <a class="getstarted" data-bs-toggle="dropdown" href="#">Tài khoản</a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-header text-center">
                                <h6 class="fw-bold">{{ auth()->user()->name }}</h6>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li>
                                <a class="dropdown-item d-flex justify-content-start align-items-center text-left" href="users-profile.html">
                                    <i class="bi bi-person"></i>
                                    <span>Thông tin</span>
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li>
                                <a class="dropdown-item justify-content-start d-flex align-items-center" href="pages-faq.html">
                                    <i class="bi bi-card-list"></i>
                                    <span>Yêu cầu đã đặt</span>
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li>
                                <a class="dropdown-item justify-content-start d-flex align-items-center" href="#">
                                    <i class="bi bi-box-arrow-right"></i>
                                    <span>Đăng xuất</span>
                                </a>
                            </li>

                        </ul><!-- End Profile Dropdown Items -->
                    </li>
                @endauth
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->

    </div>
</header><!-- End Header -->
