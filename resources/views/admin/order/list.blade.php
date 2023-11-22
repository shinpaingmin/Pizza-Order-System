@extends('admin.layouts.master')

@section('title', 'Order List')

@section('order', 'active')

@section('searchbar')
    <form class="form-header" action="{{ route('product#list') }}" method="GET">
        @csrf
        <input class="au-input au-input--xl" type="text" name="searchKey" placeholder="Search for products..." value="{{ request('searchKey') }}"/>
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
                                <h2 class="title-1">Order List</h2>

                            </div>
                        </div>
                        <div class="table-data__tool-right">
                            <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                CSV download
                            </button>
                        </div>
                    </div>

                    <div class="d-flex">
                        <label for="" class="mt-2 mr-4">Order Status</label>
                        <select id="orderStatus" class="form-control col-2">
                            <option value="">All</option>
                            <option value="0">Pending</option>
                            <option value="1">Success</option>
                            <option value="2">Reject</option>
                        </select>
                    </div>

                    @if(isset($orders) && count($orders) > 0)
                    <div class="table-responsive table-responsive-data2" style="overflow-x: auto">
                        <table class="table table-data2">
                            <thead>
                                <tr>
                                    <th style="background: #e5e5e5">Order Code</th>
                                    <th style="background: #e5e5e5" >Product Name</th>
                                    <th style="background: #e5e5e5">Username</th>
                                    <th style="background: #e5e5e5">Total Price</th>
                                    <th style="background: #e5e5e5">Qty</th>

                                    <th style="background: #e5e5e5">Date</th>
                                    <th style="background: #e5e5e5">Status</th>
                                </tr>
                            </thead>
                            <tbody>

                                    @foreach ($orders as $order_item)
                                    <tr class="tr-shadow">
                                        {{-- <td>
                                            <div class="" style="width: 150px; height: 125px">
                                                <img src="{{ asset('storage/' . $order_item->image) }}" alt="pizza" class="img-thumbnail shadow-sm object-cover w-100 h-100 " style="object-position: center">
                                            </div>
                                        </td> --}}
                                        <td>{{ $order_item->order_code }}</td>
                                        <td>
                                            <span class="text-capitalize">{{ $order_item->product_name }}</span>
                                        </td>
                                        <td>
                                            <span class="text-capitalize">{{ $order_item->username }}</span>
                                        </td>
                                        <td class="" >
                                            <span> {{ $order_item->total_price }} MMK</span>
                                        </td>
                                        <td>
                                            <span>{{ $order_item->total_qty }}</span>
                                        </td>

                                        {{-- <td style="width: 400px !important; display:inline-block; margin-top: 40px">
                                            <span >{{ $order_item->description }}</span>
                                        </td> --}}
                                        <td>
                                            <span>{{ Carbon\Carbon::parse($order_item->created_at)->format('F j, Y') }}</span>
                                        </td>

                                        <td>
                                            <select name="status" class="form-control">
                                                <option value="0" @if($order_item->status === 0) selected @endif>Pending</option>
                                                <option value="1" @if($order_item->status === 1) selected @endif>Success</option>
                                                <option value="2" @if($order_item->status === 2) selected @endif>Reject</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr class="spacer"></tr>
                                    @endforeach

                            </tbody>
                        </table>

                    </div>
                    <!-- END DATA TABLE -->

                    @else
                        <div class="d-flex justify-content-center align-items-center">
                            <img src="{{ asset('image/no-products.png') }}" alt="no products available">
                        </div>
                    @endif


                    <div class="mt-4">
                        {{-- {{ $categories->links() }} --}}

                        @if(isset($orders))
                            {{ $orders->appends(request()->query())->links() }}
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection

@section('scriptSource')
    <script>
        $(document).ready(function() {
            $('#orderStatus').change(function() {
                console.log($('#orderStatus').val());

                $orderStatus = $('#orderStatus').val();

                $.ajax({
                    type: 'post',
                    url: "{{ route('admin#ajaxStatus') }}",
                    dataType: 'json',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'status': $orderStatus
                    },
                    crossDomain: true,
                    success: function(res) {
                        console.log(res);
                    },
                    error: function(err) {
                        console.log(err);
                    }
                });
            })
        })
    </script>
@endsection
