@extends('user.layouts.master')

@if (isset($cart_items) && count($cart_items) > 0)
    @section('cartItems', count($cart_items))
@else
    @section('cartItems', 0)
@endif

@section('content')

    <div class="container-fluid pb-5">
        <div class="row px-xl-5">
            <a href="{{ route('user#home') }}" class="text-muted" style="cursor: pointer !important">
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
                        <div class="text-primary mr-2">

                            @if (count($avg_ratings) > 0)
                                @foreach ($avg_ratings as $avg)
                                    @if ($avg->product_id === $pizza->id)
                                        @for ($i = 0; $i < 5; $i++)
                                            @if ($i < $avg->avg_rating)
                                                <small class="fas fa-star"></small>
                                            @else
                                                <small class="far fa-star"></small>
                                            @endif
                                        @endfor

                                        @php
                                            $notFound = false;
                                            break;
                                        @endphp
                                    @else
                                        @php
                                            $notFound = true;
                                        @endphp
                                    @endif

                                @endforeach

                                @if ($notFound === true)
                                    <small class="fas fa-star"></small>
                                    <small class="fas fa-star"></small>
                                    <small class="fas fa-star"></small>
                                    <small class="fas fa-star"></small>
                                    <small class="fas fa-star"></small>
                                @endif
                            @endif



                        </div>
                        <small class="pt-1"><i class="fa fa-eye"></i> <span id="view_count">{{ $pizza->view_count + 1 }}</span></small>
                    </div>
                    <h3 class="font-weight-semi-bold mb-4">{{ $pizza->price }} kyats</h3>
                    <p class="mb-4">{{ $pizza->description }}</p>
                    <div class="d-flex align-items-center mb-4 pt-2">
                        <div class="input-group quantity mr-3" style="width: 130px;">
                            <div class="input-group-btn">
                                <button class="btn btn-primary btn-minus" disabled>
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>
                            <span class="form-control bg-secondary border-0 text-center" id="orderCount">1</span>

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

    <div class="row px-xl-5" style="margin-right: 0 !important">
        <div class="col">
            <div class="bg-light p-30">

                <div class="tab-content">

                    <div class="tab-pane fade show active" id="tab-pane-1">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="mb-4">{{ count($ratings) ?? 0 }} review for "{{ $pizza->product_name }}"</h4>

                                @if (count($ratings) > 0)
                                    @foreach ($ratings as $rating)
                                    <div class="media mb-4">

                                        @if (empty($rating->image) && $rating->gender === 'male')
                                            <img src="{{ asset('image/male.png') }}" alt="Profile" class="img-fluid mr-3 mt-1" style="width: 45px; height: 45px"/>
                                        @elseif (empty($rating->image) && $rating->gender === 'female')
                                            <img src="{{ asset('image/female.png') }}" alt="Profile" class="img-fluid mr-3 mt-1" style="width: 45px; height: 45px"/>
                                        @else
                                        <img src="{{ asset('storage/' . $rating->image) }}" alt="Image" class="img-fluid mr-3 mt-1" style="width: 45px; height: 45px">
                                        @endif
                                        <div class="media-body">
                                            <h6>{{ $rating->username }}<small> - <i>{{ $rating->created_at->format('F j, Y') }}</i></small></h6>
                                            <div class="text-primary mb-2">
                                                @for ($i = 0; $i < 5; $i++)
                                                    @if ($i < $rating->rating_count)
                                                        <i class="fas fa-star"></i>
                                                    @else
                                                        <i class="far fa-star"></i>
                                                    @endif
                                                @endfor

                                            </div>
                                            <p>{{ $rating->message }}</p>
                                        </div>
                                    </div>
                                    @endforeach
                                @endif

                                <div>
                                    @if (count($ratings) > 0)
                                        {{ $ratings->appends(request()->query())->links() }}
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h4 class="mb-4">Leave a review</h4>
                                <small class="mb-4">Your email address will not be published. Required fields are marked *</small>


                                <div class="d-flex my-3 align-items-center">
                                    <p class="mb-0 mr-2">Your Rating * :</p>
                                    <div class="text-primary rating-container mr-2">
                                        <i class="far fa-star cursor-pointer rating" style="cursor: pointer !important"></i>
                                        <i class="far fa-star cursor-pointer rating" style="cursor: pointer !important"></i>
                                        <i class="far fa-star cursor-pointer rating" style="cursor: pointer !important"></i>
                                        <i class="far fa-star cursor-pointer rating" style="cursor: pointer !important"></i>
                                        <i class="far fa-star cursor-pointer rating" style="cursor: pointer !important"></i>
                                    </div>
                                    <small class="text-danger rating-required"></small>
                                </div>

                                    <div class="form-group">
                                        <label for="message">Your Review *</label>
                                        <textarea id="message" cols="30" rows="5" class="form-control review" required></textarea>
                                        <small class="text-danger review-required"></small>
                                    </div>
                                    <div class="form-group">
                                        <input type="button" value="Leave Your Review" class="btn btn-primary px-3" id="submitReview">
                                    </div>
                                    <small class="text-danger mt-4 review-fail"></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


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
                                    <a href="#" class="btn btn-outline-dark btn-square"><i class="fas fa-heart"></i></a>
                                    <a class="btn btn-outline-dark btn-square" href="{{ route('user#pizzaDetails', $p->id) }}"><i class="fa fa-shopping-cart"></i></a>
                                </div>
                            </div>
                            <div class="text-center py-4">
                                <a class="h6 text-decoration-none text-truncate" href="{{ route('user#pizzaDetails', $p->id) }}">{{ $p->product_name }}</a>
                                <div class="d-flex align-items-center justify-content-center my-2">
                                    <h5>{{ $p->price }} kyats</h5><h6 class="text-muted ml-2"><del>$123.00</del></h6>
                                </div>
                                <div class="d-flex align-items-center justify-content-center mb-1">
                                    @if (count($avg_ratings) > 0)
                                            @foreach ($avg_ratings as $avg)
                                                @if ($avg->product_id === $p->id)
                                                    @for ($i = 0; $i < 5; $i++)
                                                        @if ($i < $avg->avg_rating)
                                                            <i class="fa fa-star text-primary mr-1"></i>
                                                        @else
                                                            <i class="far fa-star text-primary mr-1"></i>
                                                        @endif
                                                    @endfor

                                                    @php
                                                        $notFound = false;
                                                        break;
                                                    @endphp
                                                @else
                                                    @php
                                                        $notFound = true;
                                                    @endphp
                                                @endif

                                            @endforeach

                                            @if ($notFound === true)
                                                <i class="fa-regular fa-star text-primary mr-1"></i>
                                                <i class="fa-regular fa-star text-primary mr-1"></i>
                                                <i class="fa-regular fa-star text-primary mr-1"></i>
                                                <i class="fa-regular fa-star text-primary mr-1"></i>
                                                <i class="fa-regular fa-star text-primary mr-1"></i>
                                            @endif
                                        @endif
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

            // handle review stars for ui
            $('.rating').click(function() {
                $position = $(this).index();

                $('.rating-container .rating').each(function(index, row) {
                    $(row).removeClass('fas');
                    $(row).addClass('far');
                    if(index <= $position) {
                        $(row).removeClass('far');
                        $(row).addClass('fas');
                    }
                });
            })

            // submit review form
            $('#submitReview').click(function() {
                $lastIndex = $('.rating-container .fas:last').index();

                $('.rating-required').html('');

                $('.review-required').html('');

                $('.review-fail').html('')

                $starsSuccess = true;
                $reviewSuccess = true;

                $review = $('.review').val();

                if($lastIndex === -1) {
                    $('.rating-required').html('(The rating stars are required!)');
                    $starsSuccess = false;
                }
                if(!$review || $review.length < 10 || $review.length > 150) {
                    $('.review-required').html('The review field must be between 10 and 150 characters!');
                    $reviewSuccess = false;
                }

                if($starsSuccess && $reviewSuccess) {
                    $.ajax({
                        type: 'post',
                        url: "{{ route('user#pizzaReview') }}",
                        dataType: 'json',
                        data: {
                            '_token': '{{ csrf_token() }}',
                            'pizzaId': $('#pizzaId').val(),
                            'userId': $('#userId').val(),
                            'stars': $lastIndex + 1,
                            'review': $review
                        },
                        success: function(res) {
                            if(res.message === 'Success') {
                                location.reload();
                            }
                        },
                        error: function(err) {
                            if(err.status === 422) {
                                $('.review-fail').html(JSON.parse(err.responseText).message);
                            }
                        }
                    });
                }
            })

            // increase view count
            $.ajax({
                type: 'post',
                url: "{{ route('ajax#increaseViewCount') }}",
                dataType: 'json',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'product_id': $('#pizzaId').val()
                },
                crossDomain: true,
                success: function(res) {

                },
                error: function(err) {
                    console.log(err);
                }
            })

            // increase qty btn
            $('.btn-plus').click(function() {
                $qty = Number($('#orderCount').text()) + 1;
                $('#orderCount').html($qty);

                // disable button if the qty exceeds 10
                if($qty >= 10) {
                    $('.btn-plus').prop('disabled', true);
                } else {
                    $('.btn-minus').removeAttr('disabled');
                }
            })

            // decrease qty btn
            $('.btn-minus').click(function() {
                $qty = Number($('#orderCount').text()) - 1;
                $('#orderCount').html($qty);

                // disable button if the qty lowers than 1
                if($qty <= 1) {
                    $('.btn-minus').prop('disabled', true);
                } else {
                    $('.btn-plus').removeAttr('disabled');
                }
            })

            // add to cart fn
            $('#addToCartBtn').click(function() {
                $pizzaCount = $('#orderCount').text();
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

