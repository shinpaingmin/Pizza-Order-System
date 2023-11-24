@extends('user.layouts.master')

@if (isset($cart_items) && count($cart_items) > 0)
    @section('cartItems', count($cart_items))
@else
    @section('cartItems', 0)
@endif

@section('content')
        <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">

                <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                    <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                    </symbol>
                    <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </symbol>
                    <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                    </symbol>
                </svg>

                @if (session('updateSuccess'))
                    <div class="col-3 offset-8">
                        <div class="alert alert-success d-flex align-items-center alert-dismissible fade show" id="alert" role="alert">
                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                            <div class="mx-4">
                                {{ session('updateSuccess') }}
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endif

                <div class="col-lg-10 offset-1">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex justify-content-center">
                                <h3 class="title-2">Edit Profile Info</h3>
                            </div>
                            <hr>

                            <form action="{{ route('user#updateProfile', Auth::user()->id) }}" class="w-100" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-4 offset-4" style="transform: translateX(15%)">
                                        <div style="width: 250px; height: 250px" class="overflow-hidden">
                                            @if (empty(Auth::user()->image) && Auth::user()->gender === 'male')
                                                <img src="{{ asset('image/male.png') }}" alt="Profile" class="object-cover" style="object-position: center !important"/>
                                            @elseif (empty(Auth::user()->image) && Auth::user()->gender === 'female')
                                                <img src="{{ asset('image/female.png') }}" alt="Profile" class="object-cover" style="object-position: center !important"/>
                                            @else
                                                <img src="{{ asset('storage/' . Auth::user()->image) }}" alt="Profile" class="object-cover" style="object-position: center !important"/>
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

                                <div class="px-5">
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
                                        <label class="control-label mb-1">Gender</label>
                                        <select name="gender" class="form-control  @error('gender') is-invalid
                                        @enderror">
                                            <option value="male" @if(old('gender', Auth::user()->gender) === "male") selected @endif>Male</option>
                                            <option value="female" @if(old('gender', Auth::user()->gender) === "female") selected @endif>Female</option>
                                        </select>
                                    </div>
                                    @error('gender')
                                        <div class="invalid-feedback d-inline-block mb-4">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                    <div class="form-group mb-3">
                                        <label class="control-label mb-1">Role</label>
                                        <input id="cc-pament" name="role" type="text" class="form-control" disabled aria-required="true" aria-invalid="false"
                                        value="{{ Auth::user()->role }}" >
                                    </div>

                                    <div class="d-flex justify-content-center my-3">
                                        <button class="btn btn-dark text-white py-2 w-75" type="submit">
                                            <i class="fa-solid fa-arrows-rotate mr-2" ></i>  Update Info
                                        </button>
                                    </div>
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
