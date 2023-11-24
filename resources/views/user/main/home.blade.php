@extends('user.layouts.master')

@section('home', 'active')

@if (isset($cart_items) && count($cart_items) > 0)
    @section('cartItems', count($cart_items))
@else
    @section('cartItems', 0)
@endif

@section('content')
       <!-- Shop Start -->
       <div class="container-fluid">
        <div class="row px-xl-5">
            <!-- Shop Sidebar Start -->
            <div class="col-lg-3 col-md-4">
                <!-- Categories Start -->
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filter by category</span></h5>
                <div class="bg-light p-4 mb-30">
                    <form>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">

                            <a href="{{ route('user#home') }}" class="text-muted" for="price-all">All Categories</a>
                            <span class="badge border font-weight-normal">{{ count($categories) }}</span>
                        </div>

                        @if (isset($categories) && count($categories) > 0)
                            @foreach ($categories as $category)

                                <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">

                                    <a  href="{{ route('user#filter', $category->id) }}" class="text-muted" for="price-1">{{ $category->category_name }}</a>

                                </div>
                            @endforeach
                        @endif
                    </form>
                </div>
                <!-- Categories End -->


                {{-- <div class="">
                    <button class="btn btn btn-warning w-100">Order</button>
                </div> --}}

            </div>
            <!-- Shop Sidebar End -->


            <!-- Shop Product Start -->
            <div class="col-lg-9 col-md-8">
                <div class="row pb-3">
                    <div class="col-12 pb-1">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div>
                                <button class="btn btn-sm btn-light"><i class="fa fa-th-large"></i></button>
                                <button class="btn btn-sm btn-light ml-2"><i class="fa fa-bars"></i></button>
                            </div>
                            <div class="ml-2">
                                <div class="dropdown">
                                    {{-- <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                      Sorting
                                    </button> --}}
                                    {{-- <ul class="dropdown-menu dropdown-menu-right">
                                      <li><a class="dropdown-item" href="#">Ascending</a></li>
                                      <li><a class="dropdown-item" href="#">Descending</a></li>
                                    </ul> --}}
                                    <select name="sorting" id="sortingOption" class="form-control">
                                        <option value="" selected disabled>Order by date ...</option>
                                        <option value="asc">Ascending</option>
                                        <option value="desc">Descending</option>
                                    </select>
                                  </div>
                            </div>
                        </div>
                    </div>

                    @if (isset($products) && count($products) > 0)
                    <div class="row w-100" id="dataList">
                        @foreach ($products as $product)
                        <div class="col-lg-4 col-md-6 col-sm-6 pb-1 w-100" id="myForm">
                            <div class="product-item bg-light mb-4 w-100">
                                <div class="product-img position-relative overflow-hidden" style="width: 100%; height: 250px">
                                    <img class="img-fluid w-100 h-100 object-cover" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->product_name }}">
                                    <div class="product-action">
                                        <a href="#" class="btn btn-outline-dark btn-square"><i class="fas fa-heart"></i></a>
                                        <a class="btn btn-outline-dark btn-square" href="{{ route('user#pizzaDetails', $product->id) }}"><i class="fa fa-shopping-cart"></i></a>
                                    </div>
                                </div>
                                <div class="text-center py-4">
                                    <a class="h6 text-decoration-none text-truncate" href="">{{ $product->product_name }}</a>
                                    <div class="d-flex align-items-center justify-content-center my-2">
                                        <h5>{{ $product->price }} kyats</h5><h6 class="text-muted ml-2"><del>25000</del></h6>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-center mb-1">
                                        @if (isset($avg_ratings) && count($avg_ratings) > 0)
                                            @foreach ($avg_ratings as $avg)
                                                @if ($avg->product_id === $product->id)
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
                        </div>
                        @endforeach
                    </div>

                    @else
                        <div class="d-flex justify-content-center align-items-center">
                            <img src="{{ asset('image/no-products.png') }}" alt="no categories available">
                        </div>
                    @endif

                </div>


            </div>
            <!-- Shop Product End -->
        </div>
    </div>
    <!-- Shop End -->
@endsection

@section('scriptSource')
    <script>
        $(document).ready(function() {

            $('#sortingOption').change(function() {
                $sortingOption = $('#sortingOption').val();

                if($sortingOption === 'asc') {

                    $.ajax({
                        type: 'post',
                        url: "{{ route('ajax#productList') }}",
                        data: {
                            '_token': '{{ csrf_token() }}',
                            'status': 'asc'
                        },
                        dataType: 'json',
                        crossDomain: true,
                        success: function(res) {
                            // console.log(res[0].product_name);
                            $list = '';

                            for ($i = 0; $i < res.length; $i++) {

                                $list += `
                                <div class="col-lg-4 col-md-6 col-sm-6 pb-1" id="myForm">
                                <div class="product-item bg-light mb-4">
                                    <div class="product-img position-relative overflow-hidden" style="width: 100%; height: 250px">
                                        <img class="img-fluid w-100 h-100 object-cover" src="{{ asset('storage/${res[$i].image}') }}" alt="${res[$i].product_name}">
                                        <div class="product-action">
                                            <a href="#" class="btn btn-outline-dark btn-square"><i class="fas fa-heart"></i></a>
                                            <a class="btn btn-outline-dark btn-square" href="{{ url('user/pizza/details/${res[$i].id}') }}"><i class="fa fa-shopping-cart"></i></a>
                                        </div>
                                    </div>
                                    <div class="text-center py-4">
                                        <a class="h6 text-decoration-none text-truncate" href="">${res[$i].product_name}</a>
                                        <div class="d-flex align-items-center justify-content-center mt-2">
                                            <h5>${res[$i].price} kyats</h5><h6 class="text-muted ml-2"><del>25000</del></h6>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-center mb-1">
                                            <small class="fa fa-star text-primary mr-1"></small>
                                            <small class="fa fa-star text-primary mr-1"></small>
                                            <small class="fa fa-star text-primary mr-1"></small>
                                            <small class="fa fa-star text-primary mr-1"></small>
                                            <small class="fa fa-star text-primary mr-1"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                `;
                            }
                            $('#dataList').html($list);
                        }
                    })
                } else if($sortingOption === 'desc') {
                    $.ajax({
                        type: 'post',
                        url: "{{ route('ajax#productList') }}",
                        data: {
                            '_token': '{{ csrf_token() }}',
                            'status': 'desc'
                        },
                        dataType: 'json',
                        crossDomain: true,
                        success: function(res) {
                            $list = '';

                            for ($i = 0; $i < res.length; $i++) {

                                $list += `
                                <div class="col-lg-4 col-md-6 col-sm-6 pb-1" id="myForm">
                                <div class="product-item bg-light mb-4">
                                    <div class="product-img position-relative overflow-hidden" style="width: 100%; height: 250px">
                                        <img class="img-fluid w-100 h-100 object-cover" src="{{ asset('storage/${res[$i].image}') }}" alt="${res[$i].product_name}">
                                        <div class="product-action">
                                            <a href="#" class="btn btn-outline-dark btn-square"><i class="fas fa-heart"></i></a>
                                            <a class="btn btn-outline-dark btn-square" href="{{ url('user/pizza/details/${res[$i].id}') }}"><i class="fa fa-shopping-cart"></i></a>
                                        </div>
                                    </div>
                                    <div class="text-center py-4">
                                        <a class="h6 text-decoration-none text-truncate" href="">${res[$i].product_name}</a>
                                        <div class="d-flex align-items-center justify-content-center mt-2">
                                            <h5>${res[$i].price} kyats</h5><h6 class="text-muted ml-2"><del>25000</del></h6>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-center mb-1">
                                            <small class="fa fa-star text-primary mr-1"></small>
                                            <small class="fa fa-star text-primary mr-1"></small>
                                            <small class="fa fa-star text-primary mr-1"></small>
                                            <small class="fa fa-star text-primary mr-1"></small>
                                            <small class="fa fa-star text-primary mr-1"></small>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                `;
                                }
                                $('#dataList').html($list);
                        }
                    })
                }
            })
        })
    </script>
@endsection
