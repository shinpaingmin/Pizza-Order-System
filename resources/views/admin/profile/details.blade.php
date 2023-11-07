@extends('admin.layouts.master')

@section('title', 'Change Password')

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
                                <h3 class="text-center title-2">Profile Info</h3>
                            </div>
                            <hr>
                            <div class="offset-1 mt-4">
                                <p><i class="fa-solid fa-user-clock"></i> &nbsp; Joined at {{ Auth::user()->created_at->format('F j, Y') }}</p>
                            </div>
                            <div class="row mt-4">
                                <div class="col-3 offset-1">
                                    @if (empty(Auth::user()->image))
                                    <img src="{{ asset('image/user.png') }}" alt="Profile" class="img-thumbnail shadow-sm"/>
                                    @else
                                        <img src="{{ Auth::user()->image }}" alt="Profile" />
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

                                        <button class="btn btn-dark  mt-2" type="button">
                                            <a href="{{ route('') }}" class="text-decoration-none text-white">
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
