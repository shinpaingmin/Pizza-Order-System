@extends('admin.layouts.master')

@section('title', 'Profile Detail')

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
                <div class="col-lg-10 offset-1">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center title-2">Profile Info</h3>
                            </div>
                            <hr>
                            <div class="offset-1 mt-4">
                                <p><i class="fa-solid fa-user-clock"></i> &nbsp; Joined at {{ Auth::user()->created_at->format('F j, Y') }}</p>
                            </div>
                            <div class="row mt-4">
                                <div class="col-3 offset-1" style="width: 220px; height: 191.7px">
                                    @if (empty(Auth::user()->image) && Auth::user()->gender === 'male')
                                        <img src="{{ asset('image/male.png') }}" alt="Profile" class="img-thumbnail shadow-sm h-100" style="width: 100% !important"/>
                                    @elseif (empty(Auth::user()->image) && Auth::user()->gender === 'female')
                                        <img src="{{ asset('image/female.png') }}" alt="Profile" class="img-thumbnail shadow-sm h-100" style="width: 100% !important"/>
                                    @else
                                        <img src="{{ asset('storage/' . Auth::user()->image) }}" alt="Profile" class="img-thumbnail shadow-sm h-100" style="width: 100% !important"/>
                                    @endif
                                </div>
                                <div class="col-7 offset-1">

                                        <div class="">
                                            <label class="fw-bold " style="margin-right: 38px">Name:</label>
                                            <span class="text-capitalize">{{ Auth::user()->username }}</span>
                                        </div>
                                        <div class="">
                                            <label class="fw-bold" style="margin-right: 40px" >Email:</label>
                                            <span class="">{{ Auth::user()->email }}</span>
                                        </div>
                                        <div class="">
                                            <label class="fw-bold " style="margin-right: 35px">Phone:</label>
                                            <span class="">{{ Auth::user()->phone }}</span>
                                        </div>
                                        <div class="">
                                            <label class="fw-bold " style="margin-right: 20px">Address:</label>
                                            <span class="">{{ Auth::user()->address }}</span>
                                        </div>
                                        <div class="">
                                            <label class="fw-bold " style="margin-right: 25px">Gender:</label>
                                            <span class="">{{ Auth::user()->gender }}</span>
                                        </div>

                                        <button class="btn btn-dark  mt-2" type="button">
                                            <a href="{{ route('admin#edit') }}" class="text-decoration-none text-white">
                                                <i class="fa-solid fa-pen-to-square"></i> Edit profile
                                            </a>
                                        </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
