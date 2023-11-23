@extends('admin.layouts.master')

@section('title', 'Order List')

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
                        <select id="orderStatus" class="form-control col-2 mr-2">
                            <option value="">All</option>
                            <option value="0">Pending</option>
                            <option value="1">Success</option>
                            <option value="2">Reject</option>
                        </select>
                        <button type="button"  class="btn btn-small btn-dark text-white h-100">
                            <i class="fa-solid fa-database mr-2"></i> <span id="total">{{ isset($orders) ? count($orders) : '' }}</span>
                        </button>
                    </div>


                    <div class="table-responsive table-responsive-data2" style="overflow-x: auto">
                        <table class="table table-data2" id="dataTable">
                            @if(isset($orders) && count($orders) > 0)
                            <thead>
                                <tr>
                                    <th style="background: #e5e5e5">Order Code</th>
                                    <th style="background: #e5e5e5">Username</th>
                                    <th style="background: #e5e5e5">Ordered Date</th>
                                    <th style="background: #e5e5e5">Status</th>
                                </tr>
                            </thead>
                            <tbody>

                                    @foreach ($orders as $order_item)
                                    <tr class="tr-shadow">
                                        <input type="hidden" value="{{ $order_item->id }}" id="orderId">
                                        <td>
                                            <a href="{{ route('admin#listInfo', $order_item->id) }}" class="text-decoration-none">
                                                {{ $order_item->order_code }}
                                            </a>
                                        </td>
                                        <td>
                                            <span class="text-capitalize">{{ $order_item->username }}</span>
                                        </td>
                                        <td>
                                            <span>{{ Carbon\Carbon::parse($order_item->created_at)->format('F j, Y') }}</span>
                                        </td>

                                        <td>
                                            <select name="status" class="form-control statusChange" id="">
                                                <option value="0" @if($order_item->status === 0) selected @endif>Pending</option>
                                                <option value="1" @if($order_item->status === 1) selected @endif>Success</option>
                                                <option value="2" @if($order_item->status === 2) selected @endif>Reject</option>
                                            </select>
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




                    <div class="mt-4" id="pagination">

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
            // filter order status
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
                        if(res.status === '200') {
                            const { data } = res;   // destructure


                            $list = '';

                            if(data.length > 0) {
                                $tableHeader = `
                                <thead>
                                    <tr>
                                        <th style="background: #e5e5e5">Order Code</th>
                                        <th style="background: #e5e5e5">Username</th>
                                        <th style="background: #e5e5e5">Ordered Date</th>
                                        <th style="background: #e5e5e5">Status</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                `;

                                $('#dataTable').html($tableHeader);


                                for ($i = 0; $i < data.length; $i++) {

                                    $dbDate = new Date(data[$i].created_at);
                                    $date = $dbDate.getDate();
                                    $month = $dbDate.getMonth();
                                    $year = $dbDate.getFullYear();
                                    console.log(data[$i].created_at);

                                    $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September',
                                                'October', 'November', 'December'];

                                    $concat = $months[$month] + " " + $date + ", " + $year;

                                    $list += `


                                            <tr class="tr-shadow">
                                                <input type="hidden" value="${data[$i].id}" id="orderId">
                                                <td>
                                                    <a href="{{ url('order/listInfo/${data[$i].id}') }}" class="text-decoration-none">
                                                        ${data[$i].order_code}
                                                    </a>
                                                </td>

                                                <td>
                                                    <span class="text-capitalize">${data[$i].username}</span>
                                                </td>
                                                <td>
                                                    <span>${$concat}</span>
                                                </td>

                                                <td>
                                                    <select name="status" class="form-control statusChange">
                                                        <option value="0" ${data[$i].status === 0 ? 'selected' : ''}>Pending</option>
                                                        <option value="1" ${data[$i].status === 1 ? 'selected' : ''}>Success</option>
                                                        <option value="2" ${data[$i].status === 2 ? 'selected' : ''}>Reject</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr class="spacer"></tr>




                                    `;
                                }

                                $('#total').html(data.length);
                                $('#dataTable tbody').html($list);
                                $('#pagination').html('');

                                OrderStatusChangeEvent();

                            } else {
                                $list = `
                                    <div class="d-flex justify-content-center align-items-center mt-3">
                                        <img src="{{ asset('image/no-products.png') }}" alt="no products available">
                                    </div>
                                `;

                                $('#dataTable').html($list);
                                $('#total').html(data.length);
                            }
                        }
                    },
                    error: function(err) {
                        console.log(err);
                    }
                });


            });

            // update order status
            OrderStatusChangeEvent();

            // update order status, reusable function
            function OrderStatusChangeEvent() {
                $('.statusChange').change(function() {
                $parentNode = $(this).parents('tr');
                $currentStatus = $parentNode.find('.statusChange').val();
                $orderId = $parentNode.find('#orderId').val();

                $.ajax({
                    type: 'post',
                    url: "{{ route('admin#ajaxChangeStatus') }}",
                    dataType: 'json',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'status': $currentStatus,
                        'orderId': $orderId
                    },
                    crossDomain: true,
                    success: function(res) {
                        // location.reload()
                    },
                    error: function(err) {
                        console.log(err);
                    }
                });
            });
            }
        })
    </script>
@endsection
