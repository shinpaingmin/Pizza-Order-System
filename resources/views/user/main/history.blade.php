@extends('user.layouts.master')

@if (isset($cart_items) && count($cart_items) > 0)
    @section('cartItems', count($cart_items))
@else
    @section('cartItems', 0)
@endif

@section('content')
        <!-- order Start -->
        <div class="container-fluid" style="height: 600px">
            <div class="row px-xl-5">
                <div class="col-lg-10 offset-1 table-responsive mb-5">
                    <table class="table table-light table-borderless table-hover text-center mb-0" id="dataTable">
                        <thead class="thead-dark">
                            <tr>
                                <th>Image</th>
                                <th>Order Code</th>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody class="align-middle">
                            @if (isset($orders) && count($orders) > 0)
                                @foreach ($orders as $order_item)
                                <tr>
                                    <td>
                                        <div style="width: 80px; height: 45px">
                                            <img src="{{ asset('storage/' . $order_item->image) }}" class="w-100 h-100 object-contain" alt="image">
                                        </div>
                                    </td>

                                    <td class="align-middle">{{ $order_item->order_code }}</td>

                                    <td class="align-middle">{{ $order_item->product_name }}</td>

                                    <td class="align-middle">{{ $order_item->total_qty }}</td>

                                    <td class="align-middle" >{{ $order_item->total_price }} kyats</td>



                                    <td class="align-middle">
                                        @if ($order_item->status === 0)
                                            <button type="button" class="btn btn-sm btn-warning text-white"><i class="fa-regular fa-clock mr-2"></i> Pending</button>
                                        @elseif ($order_item->status === 1)
                                            <button type="button" class="btn btn-sm btn-success text-white"><i class="fa-solid fa-check mr-2"></i> Success</button>
                                        @else
                                            <button type="button" class="btn btn-sm btn-danger text-white"><i class="fa-solid fa-xmark mr-2"></i> Reject</button>
                                        @endif
                                    </td>
                                    <td class="align-middle">{{ Carbon\Carbon::parse($order_item->created_at)->format('Y-m-d') }}</td>
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

                    <div class="mt-4">

                        @if(isset($orders))
                            {{ $orders->appends(request()->query())->links() }}
                        @endif

                    </div>
                </div>
            </div>
        </div>
        <!-- order End -->


@endsection


