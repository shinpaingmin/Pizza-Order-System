@extends('user.layouts.master')

@if (isset($cart_items) && count($cart_items) > 0)
    @section('cartItems', count($cart_items))
@else
    @section('cartItems', 0)
@endif

@section('content')

    <div class="container-fluid pb-5">
        <div class="row px-xl-5">
            <a onclick="history.back()" class="text-muted" style="cursor: pointer !important">
                <i class="fa fa-backward col-lg-5" ></i>
                Back
            </a>
        </div>
    </div>

    @if (isset($pizza) && !empty($pizza))
        <!-- Shop Detail Start -->
    <div class="container-fluid pb-5">
        <div class="row px-xl-5">
            <div class="col-lg-5 mb-30">
                <div id="product-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner bg-light">
                        <div class="carousel-item active" style="width: 563px; height: 422px">
                            <img class="w-100 h-100" src="{{ asset('storage/' . $pizza->image) }}" alt="{{ $pizza->product_name }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-7 h-auto mb-30">
                <div class="h-100 bg-light p-30">
                    <h3>{{ $pizza->product_name }}</h3>
                    <input type="hidden" value="{{ Auth::user()->id }}" id="userId">
                    <input type="hidden" value="{{ $pizza->id }}" id="pizzaId">
                    <input type="hidden" value="{{ $pizza->price }}" id="pizzaPrice">
                    <div class="d-flex mb-3">
                        {{-- <div class="text-primary mr-2">
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star-half-alt"></small>
                            <small class="far fa-star"></small>
                        </div> --}}
                        <small class="pt-1"><i class="fa fa-eye"></i> {{ $pizza->view_count }}</small>
                    </div>
                    <h3 class="font-weight-semi-bold mb-4">{{ $pizza->price }} kyats</h3>
                    <p class="mb-4">{{ $pizza->description }}</p>
                    <div class="d-flex align-items-center mb-4 pt-2">
                        <div class="input-group quantity mr-3" style="width: 130px;">
                            <div class="input-group-btn">
                                <button class="btn btn-primary btn-minus">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>
                            <input type="text" class="form-control bg-secondary border-0 text-center" value="1" id="orderCount">

                            <div class="input-group-btn">
                                <button class="btn btn-primary btn-plus">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <button class="btn btn-primary px-3" id="addToCartBtn" type="button"><i class="fa fa-shopping-cart mr-1"></i> Add To
                            Cart</button>
                    </div>
                    <div class="d-flex pt-2">
                        <strong class="text-dark mr-2">Share on:</strong>
                        <div class="d-inline-flex">
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-pinterest"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- Shop Detail End -->
    @endif


    <!-- Products Start -->
    <div class="container-fluid py-5">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">You May Also Like</span></h2>
        <div class="row px-xl-5">
            <div class="col">
                <div class="owl-carousel related-carousel">
                    @if (isset($pizzaList) && count($pizzaList) > 0)
                        @foreach ($pizzaList as $p)
                        <div class="product-item bg-light">
                            <div class="product-img position-relative overflow-hidden">
                                <img class="img-fluid w-100" src="{{ asset('storage/' . $p->image) }}" alt="{{ $p->product_name }}" style="width: 326px; height: 272px">
                                <div class="product-action">
                                    <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                                    <a class="btn btn-outline-dark btn-square" href="{{ route('user#pizzaDetails', $p->id) }}"><i class="fa fa-info-circle"></i></a>
                                </div>
                            </div>
                            <div class="text-center py-4">
                                <a class="h6 text-decoration-none text-truncate" href="{{ route('user#pizzaDetails', $p->id) }}">{{ $p->product_name }}</a>
                                <div class="d-flex align-items-center justify-content-center mt-2">
                                    <h5>{{ $p->price }} kyats</h5><h6 class="text-muted ml-2"><del>$123.00</del></h6>
                                </div>
                                <div class="d-flex align-items-center justify-content-center mb-1">
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small>(99)</small>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Products End -->
@endsection

@section('scriptSource')
    <script>
        $(document).ready(function() {
            $('#addToCartBtn').click(function() {
                $pizzaCount = $('#orderCount').val();
                $userId = $('#userId').val();
                $pizzaId = $('#pizzaId').val();
                $pizzaPrice = $('#pizzaPrice').val();

                $jsonData = {
                    '_token': '{{ csrf_token() }}',
                    'pizzaCount': $pizzaCount,
                    'userId': $userId,
                    'pizzaId': $pizzaId,
                    'totalPrice': $pizzaCount * $pizzaPrice
                };



                $.ajax({
                    type: 'post',
                    url: "{{ route('ajax#addToCart') }}",
                    data: $jsonData,
                    dataType: 'json',
                    crossDomain: true,
                    success: function(response) {
                        console.log(response);
                        // Handle the successful response
                        if(response.status === 'success') {
                            window.location.href = 'http://localhost:8000/user/home';
                        }
                    },
                    error: function(error) {
                        console.error(error);
                        // Handle the error
                    }
                })
            })
        })
    </script>
@endsection

