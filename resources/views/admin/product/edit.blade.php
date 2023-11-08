{{-- @extends('admin.layouts.master')

@section('title', 'Edit Product')

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
                <div class="col-lg-10 offset-1">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center title-2">Modify Products</h3>
                            </div>
                            <hr>

                           @if (isset($product) && count($product) > 0)
                            <form action="" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row my-4">
                                    <div class="col-6 offset-4" style="">
                                        <div style="width: 250px; height: 250px" class="overflow-hidden">
                                            @if (!empty($product->image))
                                                <img src="{{ asset('storage/' . $product->image) }}" alt="Profile" class="object-cover w-100 h-100" style="object-position: center !important">
                                            @endif
                                        </div>
                                        <input type="file" name="image" class="mt-4 cursor-pointer">

                                        @error('image')
                                            <div class="invalid-feedback d-inline-block mb-4">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="form-group">
                                        <label class="control-label mb-1">Product Name</label>
                                        <input id="cc-pament" name="productName" type="text" class="form-control @error('productName') is-invalid
                                        @enderror" aria-required="true" aria-invalid="false"  value="{{ old('productName', $product->product_name) }}">
                                    </div>
                                    @error('productName')
                                        <div class="invalid-feedback d-inline-block mb-4">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                    <div class="form-group">
                                        <label class="control-label mb-1">Email</label>
                                        <select name="categoryName" class="form-control @error('email') is-invalid
                                        @enderror">
                                            @if (isset($categories) && count($categories) > 0)
                                                <option value="{{  }}"></option>
                                            @endif

                                        </select>
                                        <input id="cc-pament" name="email" type="email"  aria-required="true" aria-invalid="false"  value="{{ old('email', Auth::user()->email) }}">
                                    </div>
                                    @error('email')
                                        <div class="invalid-feedback d-inline-block mb-4">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                    <div class="form-group">
                                        <label class="control-label mb-1">Phone</label>
                                        <input id="cc-pament" name="phone" type="number" class="form-control @error('phone') is-invalid
                                        @enderror" aria-required="true" aria-invalid="false"  value="{{ old('phone', Auth::user()->phone) }}">
                                    </div>
                                    @error('phone')
                                        <div class="invalid-feedback d-inline-block mb-4">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                    <div class="form-group">
                                        <label class="control-label mb-1">Address</label>
                                        <textarea name="address" cols="30" rows="10" class="form-control @error('address') is-invalid
                                        @enderror">{{ old('address', Auth::user()->address) }}</textarea>
                                    </div>
                                    @error('address')
                                        <div class="invalid-feedback d-inline-block mb-4">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                    <div class="form-group">
                                        <label class="control-label mb-1">Gender</label>
                                        <select name="gender" class="form-control  @error('gender') is-invalid
                                        @enderror">
                                            <option value="male" @if(Auth::user()->gender === "male") selected @endif>Male</option>
                                            <option value="female" @if(Auth::user()->gender === "female") selected @endif>Female</option>
                                        </select>
                                    </div>
                                    @error('gender')
                                        <div class="invalid-feedback d-inline-block mb-4">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                    <div class="form-group">
                                        <label class="control-label mb-1">Role</label>
                                        <input id="cc-pament" name="role" type="text" class="form-control" disabled aria-required="true" aria-invalid="false"
                                        value="{{ Auth::user()->role }}" >
                                    </div>

                                </div>

                                <div class="row col-6 offset-3">
                                    <button class="btn btn-dark text-white py-2" type="submit">
                                        <i class="fa-solid fa-arrows-rotate mr-2" ></i>  Update Info
                                    </button>
                                </div>
                            </form>
                           @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection --}}
