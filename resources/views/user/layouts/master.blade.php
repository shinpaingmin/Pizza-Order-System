<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Pizza Palace</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="{{ asset('image/4306482_cheese_fast_fastfood_food_italian_icon.svg') }}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('user/lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('user/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('user/css/style.css') }}" rel="stylesheet">

    {{-- Font-Awesome  --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />



    <!-- Vendor CSS-->
    <link href="{{ asset('admin/vendor/animsition/animsition.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('admin/vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('admin/vendor/wow/animate.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('admin/vendor/css-hamburgers/hamburgers.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('admin/vendor/slick/slick.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('admin/vendor/select2/select2.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('admin/vendor/perfect-scrollbar/perfect-scrollbar.css') }}" rel="stylesheet" media="all">
    <link rel="icon" href="{{ asset("image/4306482_cheese_fast_fastfood_food_italian_icon.svg") }}">

    <!-- Main CSS-->
    <link href="{{ asset('admin/css/theme.css') }}" rel="stylesheet" media="all">


<style>
    .sub-menu-wrap {
        max-height: 0px;
        overflow: hidden;
        transition: max-height 0.5s;

    }
    .sub-menu-wrap.open-menu {
        max-height: 290px;
    }
</style>
</head>

<body>



    <!-- Navbar Start -->
    <div class="container-fluid bg-dark mb-30">
        <div class="row px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <div class="d-flex align-items-center bg-dark w-100" style="height: 65px; padding: 0">
                    <div style="width: 30px; height: 30px">
                        <img src="{{ asset('image/4306482_cheese_fast_fastfood_food_italian_icon.svg') }}" class="w-100">
                    </div>
                    <h3 class="text-warning m-0 text-uppercase ml-3">Pizza Palace</h3>
                </div>
            </div>
            <div class="col-lg-9">
                <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-3 py-lg-0 px-0">
                    <a href="" class="text-decoration-none d-block d-lg-none">
                        <span class="h1 text-uppercase text-dark bg-light px-2">Multi</span>
                        <span class="h1 text-uppercase text-light bg-primary px-2 ml-n1">Shop</span>
                    </a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto py-0">
                            <a href="{{ route('user#home') }}" class="nav-item nav-link  @yield('home')">Home</a>
                            <a href="{{ route('user#cartList') }}" class="nav-item nav-link @yield('cart')">My Cart</a>
                            <a href="{{ route('user#contactPage') }}" class="nav-item nav-link @yield('contact')">Contact</a>
                        </div>
                        <div class="navbar-nav ml-auto py-0 d-none d-lg-block">
                            <a href="" class="btn px-0">
                                <i class="fas fa-heart text-primary"></i>
                                <span class="badge text-secondary border border-secondary rounded-circle" style="padding-bottom: 2px;">0</span>
                            </a>
                            <a href="{{ route('user#cartList') }}" class="btn px-0 ml-3">
                                <i class="fas fa-shopping-cart text-primary"></i>
                                <span class="badge text-secondary border border-secondary rounded-circle" style="padding-bottom: 2px;">@yield('cartItems')</span>
                            </a>
                            <a href="{{ route('user#history') }}" class="btn px-0 ml-3">
                                <i class="fa-solid fa-clock-rotate-left text-warning"></i>
                                <span class="text-warning" style="padding-bottom: 2px;">Order History</span>
                            </a>
                        </div>

                        <div class="image ml-5" style="width: 40px; height: 40px; cursor: pointer">
                            @if (empty(Auth::user()->image) && Auth::user()->gender === 'male')
                                <img src="{{ asset('image/male.png') }}" alt="Profile" style="width: 100%; height: 100%" class="img-thumbnail rounded-circle bg-white w-100" onclick="toggleMenu()"/>
                            @elseif (empty(Auth::user()->image) && Auth::user()->gender === 'female')
                                <img src="{{ asset('image/female.png') }}" alt="Profile" style="width: 100%; height: 100%" class="img-thumbnail rounded-circle bg-white w-100" onclick="toggleMenu()"/>
                            @else
                                <img src="{{ asset('storage/' . Auth::user()->image) }}" alt="Profile" style="width: 100%; height: 100%" class=" rounded-circle bg-white w-100" onclick="toggleMenu()"/>
                            @endif
                        </div>

                        <div class="position-absolute sub-menu-wrap" id="subMenu" style="top: 100%; right: 0; width: 320px; z-index: 9999;">
                            <div class="bg-white" style="padding: 20px; margin: 10px 10px 0">
                                <div class="d-flex align-items-center">
                                    @if (empty(Auth::user()->image) && Auth::user()->gender === 'male')
                                        <img src="{{ asset('image/male.png') }}" alt="Profile" style="width: 60px; margin-right: 15px"  class="img-thumbnail rounded-circle bg-white"/>
                                    @elseif (empty(Auth::user()->image) && Auth::user()->gender === 'female')
                                        <img src="{{ asset('image/female.png') }}" alt="Profile" style="width: 60px; margin-right: 15px" class="img-thumbnail rounded-circle bg-white"/>
                                    @else
                                        <img src="{{ asset('storage/' . Auth::user()->image) }}" style="width: 60px; margin-right: 15px" alt="Profile" class=" rounded-circle bg-white"/>
                                    @endif
                                    <div>
                                        <h4 class="" style="font-weight: 500">{{ Auth::user()->username }}</h4>
                                        <small>{{ Auth::user()->email }}</small>
                                    </div>
                                </div>
                                <hr class="" style="height: 1px; margin: 15px 0 10px; border: 0; background-color: #ccc; width: 100%">
                                <a href="{{ route('user#editProfilePage') }}" class="d-flex align-items-center text-decoration-none text-dark" style="margin: 12px 0; display: inline-block; height: 40px;">

                                    <i class="fa-solid fa-user mr-2"></i> <p class="">Edit Profile</p>

                                </a>
                                <a href="{{ route('user#changePasswordPage') }}" class="d-flex align-items-center text-decoration-none text-dark" style="margin: 12px 0; display: inline-block; height: 40px;">

                                    <i class="fa-solid fa-key mr-2"></i> <p class="">Change Password</p>

                                </a>

                                <form action="{{ route('logout') }}" method="post"  style="margin: 8px 0; display: inline-block; height: 40px;">
                                    @csrf
                                    <button  type="submit" class="d-flex align-items-center text-dark">
                                        <i class="fa-solid fa-right-from-bracket mr-2"></i> <p class="">Logout</p>
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                </nav>
            </div>
        </div>
    </div>
    <!-- Navbar End -->


    @yield('content')


    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-secondary mt-5 pt-5">
        <div class="row px-xl-5 pt-5">
            <div class="col-lg-4 col-md-12 mb-5 pr-3 pr-xl-5">
                <h5 class="text-secondary text-uppercase mb-4">Get In Touch</h5>
                <p class="mb-4">No dolore ipsum accusam no lorem. Invidunt sed clita kasd clita et et dolor sed dolor. Rebum tempor no vero est magna amet no</p>
                <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>123 Street, New York, USA</p>
                <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>info@example.com</p>
                <p class="mb-0"><i class="fa fa-phone-alt text-primary mr-3"></i>+012 345 67890</p>
            </div>
            <div class="col-lg-8 col-md-12">
                <div class="row">
                    <div class="col-md-4 mb-5">
                        <h5 class="text-secondary text-uppercase mb-4">Quick Shop</h5>
                        <div class="d-flex flex-column justify-content-start">
                            <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Home</a>
                            <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Our Shop</a>
                            <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Shop Detail</a>
                            <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Shopping Cart</a>
                            <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Checkout</a>
                            <a class="text-secondary" href="#"><i class="fa fa-angle-right mr-2"></i>Contact Us</a>
                        </div>
                    </div>
                    <div class="col-md-4 mb-5">
                        <h5 class="text-secondary text-uppercase mb-4">My Account</h5>
                        <div class="d-flex flex-column justify-content-start">
                            <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Home</a>
                            <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Our Shop</a>
                            <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Shop Detail</a>
                            <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Shopping Cart</a>
                            <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Checkout</a>
                            <a class="text-secondary" href="#"><i class="fa fa-angle-right mr-2"></i>Contact Us</a>
                        </div>
                    </div>
                    <div class="col-md-4 mb-5">
                        <h5 class="text-secondary text-uppercase mb-4">Newsletter</h5>
                        <p>Duo stet tempor ipsum sit amet magna ipsum tempor est</p>
                        <form action="">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Your Email Address">
                                <div class="input-group-append">
                                    <button class="btn btn-primary">Sign Up</button>
                                </div>
                            </div>
                        </form>
                        <h6 class="text-secondary text-uppercase mt-4 mb-3">Follow Us</h6>
                        <div class="d-flex">
                            <a class="btn btn-primary btn-square mr-2" href="#"><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-primary btn-square mr-2" href="#"><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-primary btn-square mr-2" href="#"><i class="fab fa-linkedin-in"></i></a>
                            <a class="btn btn-primary btn-square" href="#"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row border-top mx-xl-5 py-4" style="border-color: rgba(256, 256, 256, .1) !important;">
            <div class="col-md-6 px-xl-0">
                <p class="mb-md-0 text-center text-md-left text-secondary">
                    &copy; <a class="text-primary" href="#">2023</a>. All Rights Reserved. Developed
                    by
                    <a class="text-primary" href="#">Shin Paing Min</a>
                </p>
            </div>
            {{-- <div class="col-md-6 px-xl-0 text-center text-md-right">
                <img class="img-fluid" src="img/payments.png" alt="">
            </div> --}}
        </div>
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('user/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('user/lib/owlcarousel/owl.carousel.min.js') }}"></script>

    <!-- Contact Javascript File -->
    {{-- <script src="{{ asset('user/mail/jqBootstrapValidation.min.js') }}"></script>
    <script src="{{ asset('user/mail/contact.js') }}"></script> --}}

    <!-- Template Javascript -->
    <script src="{{ asset('user/js/main.js') }}"></script>


    {{-- Jquery  --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        let subMenu = document.getElementById('subMenu');

        function toggleMenu() {
            subMenu.classList.toggle('open-menu');
        }
    </script>
</body>

    @yield('scriptSource')

</html>
