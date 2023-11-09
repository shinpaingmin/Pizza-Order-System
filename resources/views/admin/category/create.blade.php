@extends('admin.layouts.master')

@section('title', 'Add Category List')

@section('category', 'active')

@section('searchbar')
    <form class="form-header" action="{{ route('category#list') }}" method="GET">
        @csrf
        <input class="au-input au-input--xl" type="text" name="searchKey" placeholder="Search for category..." value="{{ request('searchKey') }}"/>
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
                <div class="row">
                    <div class="col-3 offset-8">
                        <a href="{{ route('category#list') }}"><button class="btn bg-dark text-white my-3">List</button></a>
                    </div>
                </div>
                <div class="col-lg-6 offset-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center title-2">Add New Category</h3>
                            </div>
                            <hr>
                            <form action="{{ route('category#create') }}" method="post" novalidate="novalidate">
                                @csrf
                                <div class="form-group">
                                    <label class="control-label mb-1">Name</label>
                                    <input id="cc-pament" name="categoryName" type="text" class="form-control @error('categoryName') is-invalid
                                    @enderror" aria-required="true" aria-invalid="false" placeholder="Seafood..." value="{{ old('categoryName') }}">
                                </div>
                                @error('categoryName')
                                    {{-- <small class="text-danger">{{ $message }}</small> --}}
                                    <div class="invalid-feedback d-inline-block mb-4">
                                        {{ $message }}
                                    </div>
                                @enderror

                                <div>
                                    <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                                        <span id="payment-button-amount">Create</span>
                                        <span id="payment-button-sending" style="display:none;">Sending…</span>
                                        <i class="fa-solid fa-circle-right"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
