@extends('admin.layouts.master')

@section('title', 'Edit Profile')

@section('searchbar')
    {{-- <form class="form-header" action="{{ route('category#list') }}" method="GET">
        @csrf
        <input class="au-input au-input--xl" type="text" name="searchKey" placeholder="Search for category..." value="{{ request('searchKey') }}"/>
        <button class="au-btn--submit" type="submit">
            <i class="zmdi zmdi-search"></i>
        </button>
    </form> --}}
    <h2>Admin Dashboard</h2>
@endsection

@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-lg-10 offset-1">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center title-2">Edit Profile Info</h3>
                            </div>
                            <hr>

                            <form action="">
                                <div class="row my-4">
                                    <div class="col-6 offset-4" style="width: 300px">
                                        @if (empty(Auth::user()->image))
                                        <img src="{{ asset('image/user.png') }}" alt="Profile" class="img-thumbnail shadow-sm w-100"/>
                                        @else
                                            <img src="{{ Auth::user()->image }}" alt="Profile" />
                                        @endif

                                        <input type="file" name="image" class="mt-4 cursor-pointer">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group">
                                        <label class="control-label mb-1">Name</label>
                                        <input id="cc-pament" name="name" type="text" class="form-control @error('name') is-invalid
                                        @enderror" aria-required="true" aria-invalid="false"  value="{{ old('name', Auth::user()->username) }}">
                                    </div>
                                    @error('name')
                                        <div class="invalid-feedback d-inline-block mb-4">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                    <div class="form-group">
                                        <label class="control-label mb-1">Email</label>
                                        <input id="cc-pament" name="email" type="email" class="form-control @error('email') is-invalid
                                        @enderror" aria-required="true" aria-invalid="false"  value="{{ old('email', Auth::user()->email) }}">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection