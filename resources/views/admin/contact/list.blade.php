@extends('admin.layouts.master')

@section('title', 'Contact List')

@section('contact', 'active')

@section('searchbar')
    <form class="form-header" action="{{ route('admin#contactList') }}" method="GET">
        @csrf
        <input class="au-input au-input--xl" type="text" name="searchKey" placeholder="Search for contact..." value="{{ request('searchKey') }}"/>
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
                                <h2 class="title-1">Contact List</h2>

                            </div>
                        </div>
                        <div class="table-data__tool-right">
                            <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                CSV download
                            </button>
                        </div>
                    </div>


                    <div class="table-responsive table-responsive-data2" style="overflow-x: auto">
                        <table class="table table-data2" id="dataTable">
                            @if(isset($contacts) && count($contacts) > 0)
                            <thead>
                                <tr>
                                    <th style="background: #e5e5e5">ID</th>
                                    <th style="background: #e5e5e5">Name</th>
                                    <th style="background: #e5e5e5">Email</th>
                                    <th style="background: #e5e5e5">Subject</th>
                                    <th style="background: #e5e5e5">Message</th>
                                    <th style="background: #e5e5e5">Submitted Date</th>
                                </tr>
                            </thead>
                            <tbody>

                                    @foreach ($contacts as $contact)
                                    <tr class="tr-shadow">
                                        <td style="vertical-align: top !important">
                                            <span >{{ $contact->id }}</span>
                                        </td>
                                        <td style="width: 150px !important; display: inline-block; vertical-align: top !important">
                                            <span class="text-capitalize">{{ $contact->name }}</span>
                                        </td>
                                        <td style="vertical-align: top !important">
                                            <span >{{ $contact->email }}</span>
                                        </td>
                                        <td  style="vertical-align: top !important">
                                            <span >{{ $contact->subject }}</span>
                                        </td>
                                        <td  style="vertical-align: top !important">
                                            <span >{{ $contact->message }}</span>
                                        </td>
                                        <td style="vertical-align: top !important">
                                            <span>{{ Carbon\Carbon::parse($contact->created_at)->format('F j, Y') }}</span>
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

                        @if(isset($contacts))
                            {{ $contacts->appends(request()->query())->links() }}
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection

