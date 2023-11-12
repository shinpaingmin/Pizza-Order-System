@extends('admin.layouts.master')

@section('title', 'Create Product')

@section('product', 'active')

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
                <div class="row">
                    <div class="col-3 offset-8">
                        <a href="{{ route('product#list') }}"><button class="btn bg-dark text-white my-3">List</button></a>
                    </div>
                </div>
                <div class="col-lg-6 offset-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center title-2">Add New Product</h3>
                            </div>
                            <hr>
                            <form action="{{ route('product#create') }}" method="post" novalidate="novalidate" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label class="control-label mb-1">Name</label>
                                    <input id="cc-pament" name="productName" type="text" class="form-control @error('productName') is-invalid
                                    @enderror" aria-required="true" aria-invalid="false"  value="{{ old('productName') }}">
                                </div>
                                @error('productName')
                                    <div class="invalid-feedback d-inline-block mb-4">
                                        {{ $message }}
                                    </div>
                                @enderror

                                <div class="form-group">
                                    <label class="control-label mb-1">Category</label>
                                    <select name="categoryName" class="form-control @error('categoryName') is-invalid
                                    @enderror">
                                        <option value="" @if (!old('categoryName')) selected @endif disabled>Choose product category</option>
                                    @if (isset($categories) && count($categories) > 0)
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" @if (!empty(old('categoryName')) && old('categoryName') === $category->category_name) selected @endif>{{ $category->category_name }}</option>
                                        @endforeach
                                    @endif

                                    </select>
                                </div>
                                @error('categoryName')
                                    <div class="invalid-feedback d-inline-block mb-4">
                                        {{ $message }}
                                    </div>
                                @enderror

                                <div class="form-group">
                                    <label class="control-label mb-1">Description</label>
                                    <textarea name="description" cols="30" rows="10" class="form-control @error('description') is-invalid
                                    @enderror" aria-required="true" aria-invalid="false">{{ old('description') }}</textarea>
                                </div>
                                @error('description')
                                    <div class="invalid-feedback d-inline-block mb-4">
                                        {{ $message }}
                                    </div>
                                @enderror

                                <div class="form-group">
                                    <label class="control-label mb-1">Image</label>
                                    <input id="cc-pament" name="image" type="file" class="form-control @error('image') is-invalid
                                    @enderror" aria-required="true" aria-invalid="false">
                                </div>
                                @error('image')
                                    <div class="invalid-feedback d-inline-block mb-4">
                                        {{ $message }}
                                    </div>
                                @enderror

                                <div class="form-group">
                                    <label class="control-label mb-1">Price</label>
                                    <input id="cc-pament" name="price" type="number" class="form-control @error('price') is-invalid
                                    @enderror" aria-required="true" aria-invalid="false"  value="{{ old('price') }}">
                                </div>
                                @error('price')
                                    <div class="invalid-feedback d-inline-block mb-4">
                                        {{ $message }}
                                    </div>
                                @enderror

                                <div class="form-group">
                                    <label class="control-label mb-1">Waiting Time</label>
                                    <input id="cc-pament" name="waitingTime" type="number" class="form-control @error('waitingTime') is-invalid
                                    @enderror" aria-required="true" aria-invalid="false"  value="{{ old('waitingTime') }}">
                                </div>
                                @error('waitingTime')
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
