@extends('admin.layouts.master')

@section('title', 'Order Detail')

@section('order', 'active')

@section('searchbar')
    <form class="form-header" action="{{ route('admin#orderList') }}" method="GET">
        @csrf
        <input class="au-input au-input--xl" type="text" name="searchKey" placeholder="Search for order code..." value="{{ request('searchKey') }}"/>
        <button class="au-btn--submit" type="submit">
            <i class="zmdi zmdi-search"></i>
        </button>
    </form>
@endsection

@section('content')

    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <div class="table-data__tool">
                        <div class="table-data__tool-left">
                            <div class="overview-wrap">
                                <h2 class="title-1">Order Detail</h2>

                            </div>
                        </div>
                        <div class="table-data__tool-right">
                            <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                CSV download
                            </button>
                        </div>
                    </div>

                    <a onclick="history.back()" class="text-muted" style="cursor: pointer !important">
                        <i class="fa fa-backward col-lg-5" ></i>
                        Back
                    </a>

                    <div class="row col-5">
                        <div class="card mt-4">
                            <div class="card-body">
                                <h3><i class="fa-solid fa-clipboard mr-3"></i> Order Info</h3>
                                <small class="text-warning mt-3"><i class="fa-solid fa-triangle-exclamation"></i> Included Delivery Charges</small>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col"><i class="fa-solid fa-user mr-3"></i>Customer Name</div>
                                    <div class="col text-capitalize">{{ !empty($orderInfo) ? $orderInfo->username : '' }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col"><i class="fa-solid fa-barcode mr-3"></i>Order Code</div>
                                    <div class="col">{{ !empty($orderInfo) ? $orderInfo->order_code : '' }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col"><i class="fa-solid fa-clock mr-3"></i>Ordered Date</div>
                                    <div class="col">{{ !empty($orderInfo) ? $orderInfo->created_at->format('F j, Y') : '' }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col"><i class="fa-solid fa-money-bill-wave mr-3"></i>Total + Delivery</div>
                                    <div class="col">{{ $total }} MMK</div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="table-responsive table-responsive-data2 w-100">

                        <table class="table table-data2 w-100 " id="dataTable">
                            @if(isset($orders) && count($orders) > 0)
                            <thead class="w-100">
                                <tr>
                                    <th style="background: #e5e5e5">Image</th>
                                    <th style="background: #e5e5e5">Product Name</th>
                                    <th style="background: #e5e5e5">Total Price</th>
                                    <th style="background: #e5e5e5">Qty</th>
                                </tr>
                            </thead>
                            <tbody class="w-100">

                                    @foreach ($orders as $order_item)
                                    <tr class="tr-shadow">
                                        <td>
                                            <div class="" style="width: 150px; height: 125px">
                                                <img src="{{ asset('storage/' . $order_item->image) }}" alt="pizza" class="img-thumbnail shadow-sm object-cover w-100 h-100 " style="object-position: center">
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-capitalize">{{ $order_item->product_name }}</span>
                                        </td>
                                        <td>
                                            <span>{{ $order_item->total_price }} MMK</span>
                                        </td>
                                        <td>
                                            <span>{{ $order_item->total_qty }}</span>
                                        </td>
                                    </tr>
                                    <tr class="spacer"></tr>
                                    @endforeach

                            </tbody>

                            @else
                                <div class="d-flex justify-content-center align-items-center">
                                    <img src="{{ asset('image/no-products.png') }}" alt="no products available">
                                </div>
                            @endif
                        </table>

                    </div>
                    <!-- END DATA TABLE -->

                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection


