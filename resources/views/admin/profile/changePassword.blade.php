@extends('admin.layouts.master')

@section('title', 'Change Password')

@section('searchbar')
    <form class="form-header" action="{{ route('admin#list') }}" method="GET">
        @csrf
        <input class="au-input au-input--xl" type="text" name="searchKey" placeholder="Search for other admins..." value="{{ request('searchKey') }}"/>
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
                {{-- <div class="row">
                    <div class="col-3 offset-8">
                        <a href="{{ route('category#list') }}"><button class="btn bg-dark text-white my-3">Profile</button></a>
                    </div>
                </div> --}}
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
                    <div class="col-4 offset-8">
                        <div class="alert alert-success d-flex align-items-center alert-dismissible fade show" id="alert" role="alert">
                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                            <div class="mx-4">
                                {{ session('updateSuccess') }}
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endif

                <div class="col-lg-6 offset-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center title-2">Change New Password</h3>
                            </div>
                            <hr>
                            <form action="{{ route('admin#changePassword') }}" method="post" novalidate="novalidate">
                                @csrf
                                <div class="form-group">
                                    <label class="control-label mb-1">Old Password</label>
                                    <input id="cc-pament" name="oldPassword" type="password" class="form-control @error('oldPassword') is-invalid
                                    @enderror  @if(session('notMatch')) is-invalid @endif" aria-required="true" aria-invalid="false"  >
                                </div>
                                @error('oldPassword')
                                    {{-- <small class="text-danger">{{ $message }}</small> --}}
                                    <div class="invalid-feedback d-inline-block mb-4">
                                        {{ $message }}
                                    </div>
                                @enderror
                                @if (session('notMatch'))
                                    <div class="invalid-feedback d-inline-block mb-4">
                                        {{ session('notMatch') }}
                                    </div>
                                @endif

                                <div class="form-group">
                                    <label class="control-label mb-1">New Password</label>
                                    <input id="cc-pament" name="newPassword" type="password" class="form-control @error('newPassword') is-invalid
                                    @enderror" aria-required="true" aria-invalid="false"  >
                                </div>
                                @error('newPassword')
                                    {{-- <small class="text-danger">{{ $message }}</small> --}}
                                    <div class="invalid-feedback d-inline-block mb-4">
                                        {{ $message }}
                                    </div>
                                @enderror

                                <div class="form-group">
                                    <label class="control-label mb-1">Confirm Password</label>
                                    <input id="cc-pament" name="confirmPassword" type="password" class="form-control @error('confirmPassword') is-invalid
                                    @enderror" aria-required="true" aria-invalid="false"  >
                                </div>
                                @error('confirmPassword')
                                    {{-- <small class="text-danger">{{ $message }}</small> --}}
                                    <div class="invalid-feedback d-inline-block mb-4">
                                        {{ $message }}
                                    </div>
                                @enderror

                                <div>
                                    <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                                        <i class="fa-solid fa-key"></i>
                                        <span id="payment-button-amount">Change Password</span>
                                        <span id="payment-button-sending" style="display:none;">Sending…</span>
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
