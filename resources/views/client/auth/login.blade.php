@extends('client.extend')
@section('client_content')
    <main id="main">
        <section id="breadcrumbs" class="breadcrumbs">
            <div class="container">
                {{ Breadcrumbs::render('client-footballPitch') }}
            </div>
        </section><!-- End Breadcrumbs -->
        <section class="container">
            <div class="row justify-content-center">
                {{-- <div class="card-title">Đăng nhập</div> --}}
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <form method="post">
                                @csrf
                                <div class="form-group mb-3">
                                    <label class="form-label">Địa chỉ email <span class="text-danger">*</span></label>
                                    <input name="email" type="email" placeholder="test@gmail.com" class="form-control">
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label">Mật khẩu <span class="text-danger">*</span></label>
                                    <div class="input-group mb-3">
                                        <input id="password" name="password" type="password" class="form-control">
                                        <span class="input-group-text">
                                            <i class="bi bi-eye-slash-fill hide-password"></i>
                                            <i class="bi bi-eye-fill show-password" style="display: none"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-md-12 text-center">
                                        <button class="btn btn-danger btn-block">Đăng nhập</button>
                                    </div>
                                </div>
                                {{-- <div class="mt-3">
                                    <p>Nếu chưa có tài khoản vui lòng <a href="{{ route('client.register') }}">đăng ký</a>
                                    </p>
                                </div> --}}
                                <div class="mt-3 text-center">
                                    <div>Hoặc</div>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-12 text-center">
                                        <div>Đăng nhập bằng mạng xã hội</div>
                                        <div class="social-links mt-3">
                                            <a class="border" href="#"><i class="bx bxl-facebook"></i></a>
                                            <a class="border" href="#"><i class="bx bxl-github"></i></a>
                                            <a class="border" href="#"><i class="bx bxl-google"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main><!-- End #main -->
    <script>
        const hide_password = document.querySelector('.hide-password');
        const show_password = document.querySelector('.show-password');
        const password = document.querySelector('#password');
        document.querySelector('#header').classList.add('header-inner-pages');
        hide_password.addEventListener('click', function() {
            this.style.display = 'none';
            show_password.style.display = 'block';
            password.type = 'text';
        });
        show_password.addEventListener('click', function() {
            this.style.display = 'none';
            hide_password.style.display = 'block';
            password.type = 'password';
        });
    </script>
@endsection
