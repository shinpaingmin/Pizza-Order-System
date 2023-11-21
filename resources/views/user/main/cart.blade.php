@extends('user.layouts.master')

@section('cart', 'active')

@if (isset($cart_items) && count($cart_items) > 0)
    @section('cartItems', count($cart_items))
@else
    @section('cartItems', 0)
@endif

@section('content')
        <!-- Cart Start -->
        <div class="container-fluid">
            <div class="row px-xl-5">
                <div class="col-lg-8 table-responsive mb-5">
                    <table class="table table-light table-borderless table-hover text-center mb-0" id="dataTable">
                        <thead class="thead-dark">
                            <tr>
                                <th>Image</th>
                                <th>Products</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Remove</th>
                            </tr>
                        </thead>
                        <tbody class="align-middle">
                            @if (isset($cart_items) && count($cart_items) > 0)
                            <input type="hidden" id="cartId" value="{{ $cart_items[0]->cart_id }}">
                                @foreach ($cart_items as $cart_item)
                                <tr>
                                    <input type="hidden" id="pizzaId" value="{{ $cart_item->product_id }}">
                                    <td>
                                        <div style="width: 80px; height: 45px">
                                            <img src="{{ asset('storage/' . $cart_item->image) }}" class="w-100 h-100 object-contain" alt="image">
                                        </div>
                                    </td>

                                    <td class="align-middle"><img src="img/product-1.jpg" alt="" style="width: 50px;">{{ $cart_item->product_name }}</td>
                                    <td class="align-middle" id="pizzaPrice">{{ $cart_item->price }} kyats</td>

                                    <td class="align-middle">
                                        <div class="input-group quantity mx-auto" style="width: 100px;">
                                            <div class="input-group-btn">
                                                <button class="btn btn-sm btn-primary btn-minus" {{ $cart_item->total_qty <= 1 ? 'disabled' : '' }}>
                                                <i class="fa fa-minus"></i>
                                                </button>
                                            </div>
                                            <input type="text" class="form-control form-control-sm bg-secondary border-0 text-center" id="qty" value="{{ $cart_item->total_qty }}">
                                            <div class="input-group-btn">
                                                <button class="btn btn-sm btn-primary btn-plus" {{ $cart_item->total_qty >= 10 ? 'disabled' : '' }}>
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="align-middle" id="total">{{ $cart_item->total_price }} kyats</td>
                                    <td class="align-middle"><button class="btn btn-sm btn-danger btnRemove" id=""><i class="fa fa-times"></i></button></td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                </tr>

                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="col-lg-4">
                    <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Cart Summary</span></h5>
                    <div class="bg-light p-30 mb-5">
                        <div class="border-bottom pb-2">
                            <div class="d-flex justify-content-between mb-3">
                                <h6>Subtotal</h6>

                                <h6 id="subTotal">{{ $subTotal }} kyats</h6>
                            </div>
                            <div class="d-flex justify-content-between">
                                <h6 class="font-weight-medium">Delivery Fee</h6>
                                <h6 class="font-weight-medium">{{ $subTotal ? 3000 : 0 }} kyats</h6>
                            </div>
                        </div>
                        <div class="pt-2">
                            <div class="d-flex justify-content-between mt-2">
                                <h5>Total</h5>
                                <h5 id="totalPrice">{{ $subTotal ? $subTotal + 3000 : 0 }} kyats</h5>
                            </div>
                            <button class="btn btn-block btn-primary font-weight-bold my-3 py-3" id="orderBtn" @if(count($order) > 0) disabled @endif>
                                {{ count($order) > 0 ? "You've Already Ordered One!" : "Proceed To Order Now" }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Cart End -->


@endsection

@section('scriptSource')
    <script>
        $(document).ready(function() {

            $('#orderBtn').click(function() {
                $orderList = [];

                $orderCode = Math.floor(Math.random() * 100000000000)

                $('#dataTable tbody tr').each(function(index, row) {
                    $orderList.push({
                        'user_id': {{ Auth::user()->id }},
                        'product_id': $(row).find('#pizzaId').val(),
                        'cart_id': $('#cartId').val(),
                        'total_qty': Number($(row).find('#qty').val()),
                        'total_price': Number($(row).find('#total').text().replace('kyats', '')),
                        'order_code': 'POS' + $orderCode
                    })
                });

                $.ajax({
                    type: 'post',
                    url: "{{ route('ajax#order') }}",
                    dataType: 'json',
                    data: {...$orderList},
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    crossDomain: true,
                    success: function(res) {
                        if(res.status === 'success') {
                            window.location.href = "http://localhost:8000/user/home";
                        }
                    },
                    error: function(err) {
                        console.log(err);
                    }
                })
            })

            $('.btn-plus').click(function() {
                $parentNode = $(this).parents('tr');
                $pizzaPrice = $parentNode.find('#pizzaPrice').text().replace('kyats', '');
                $qty = Number($parentNode.find('#qty').val());

                // disable button if the qty exceeds 10
                if($qty >= 10) {
                   $parentNode.find('.btn-plus').prop('disabled', true)
                } else {
                    $parentNode.find('.btn-minus').removeAttr('disabled')
                }

                $total = $pizzaPrice * $qty;


                $jsonData = {
                    '_token': '{{ csrf_token() }}',
                    'cartId': $('#cartId').val(),
                    'productId': $parentNode.find('#pizzaId').val(),
                    'qty': $qty,
                    'totalPrice': $total
                }

                $.ajax({
                    type: 'post',
                    url: "{{ route('ajax#updateCart') }}",
                    dataType: 'json',
                    crossDomain: true,
                    data: $jsonData,
                    success: function(res) {
                        console.log(res);
                    },
                    error: function(error) {
                        console.error(error);
                        // Handle the error
                    }
                })

                $parentNode.find('#total').html($total + ' kyats');

                totalPriceCalculation();

            });

            $('.btn-minus').click(function() {
                $parentNode = $(this).parents('tr');
                $pizzaPrice = $parentNode.find('#pizzaPrice').text().replace('kyats', '');
                $qty = Number($parentNode.find('#qty').val()) ;

                // disable button if the qty lowers than 1
                if($qty <= 1) {
                   $parentNode.find('.btn-minus').prop('disabled', true)
                } else {
                    $parentNode.find('.btn-plus').removeAttr('disabled')
                }


                $total = $pizzaPrice * $qty;

                $jsonData = {
                    '_token': '{{ csrf_token() }}',
                    'cartId': $('#cartId').val(),
                    'productId': $parentNode.find('#pizzaId').val(),
                    'qty': $qty,
                    'totalPrice': $total
                }

                $.ajax({
                    type: 'post',
                    url: "{{ route('ajax#updateCart') }}",
                    dataType: 'json',
                    crossDomain: true,
                    data: $jsonData,
                    success: function(res) {
                        console.log(res);
                    },
                    error: function(error) {
                        console.error(error);
                        // Handle the error
                    }
                })

                $parentNode.find('#total').html($total + ' kyats');

                totalPriceCalculation();
            });

            $('.btnRemove').click(function() {
                $parentNode = $(this).parents('tr');
                $parentNode.remove();

                $jsonData = {
                    '_token': '{{ csrf_token() }}',
                    'cartId': $('#cartId').val(),
                    'productId': $parentNode.find('#pizzaId').val(),
                }

                $.ajax({
                    type: 'post',
                    url: "{{ route('ajax#deleteItem') }}",
                    dataType: 'json',
                    crossDomain: true,
                    data: $jsonData,
                    success: function(res) {
                        console.log(res);
                    },
                    error: function(error) {
                        console.error(error);
                        // Handle the error
                    }
                })

                totalPriceCalculation();
            });

            // total price calculation function
            function totalPriceCalculation() {
                $totalPrice = 0;
                $('#dataTable tbody tr').each(function(index, row) {
                    $totalPrice += Number($(row).find('#total').text().replace('kyats', ''));
                })

                $('#subTotal').html($totalPrice + 'kyats');
                $('#totalPrice').html(($totalPrice + 3000) + 'kyats');
            }
        })
    </script>
@endsection
