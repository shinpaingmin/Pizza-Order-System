@extends('admin.layouts.master')

@section('title', 'Add an Admin')

@section('admin', 'active')

@section('searchbar')
    <form class="form-header" action="{{ route('admin#list') }}" method="GET">
        @csrf
        <input class="au-input au-input--xl" type="text" name="searchKey" placeholder="Search for admin..." value="{{ request('searchKey') }}"/>
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

                <div class="col-lg-10 offset-1">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center title-2">Add New Admin</h3>
                            </div>
                            <hr>

                            <form action="{{ route('admin#create') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row my-4">
                                    <div class="col-6 offset-4" style="">
                                        <div style="width: 250px; height: 250px" class="overflow-hidden">
                                                <img src="{{ asset('image/person-question-mark.svg') }}" alt="Profile" class="object-cover" style="object-position: center !important"/>
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
                                        <label class="control-label mb-1">Name</label>
                                        <input id="cc-pament" name="name" type="text" class="form-control @error('name') is-invalid
                                        @enderror" aria-required="true" aria-invalid="false"  value="{{ old('name') }}">
                                    </div>
                                    @error('name')
                                        <div class="invalid-feedback d-inline-block mb-4">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                    <div class="form-group">
                                        <label class="control-label mb-1">Email</label>
                                        <input id="cc-pament" name="email" type="email" class="form-control @error('email') is-invalid
                                        @enderror" aria-required="true" aria-invalid="false"  value="{{ old('email') }}">
                                    </div>
                                    @error('email')
                                        <div class="invalid-feedback d-inline-block mb-4">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                    <div class="form-group">
                                        <label class="control-label mb-1">Phone</label>
                                        <input id="cc-pament" name="phone" type="number" class="form-control @error('phone') is-invalid
                                        @enderror" aria-required="true" aria-invalid="false"  value="{{ old('phone') }}">
                                    </div>
                                    @error('phone')
                                        <div class="invalid-feedback d-inline-block mb-4">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                    <div class="form-group">
                                        <label class="control-label mb-1">Address</label>
                                        <textarea name="address" cols="30" rows="10" class="form-control @error('address') is-invalid
                                        @enderror">{{ old('address') }}</textarea>
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
                                            <option value="" @if(empty(old('gender'))) selected @endif disabled>Choose your gender</option>
                                            <option value="male" @if(old('gender') === "male") selected @endif>Male</option>
                                            <option value="female" @if(old('gender') === "female") selected @endif>Female</option>
                                        </select>
                                    </div>
                                    @error('gender')
                                        <div class="invalid-feedback d-inline-block mb-4">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                    <div class="form-group">
                                        <label class="control-label mb-1">Password</label>
                                        <input id="cc-pament" name="password" type="password" class="form-control @error('password') is-invalid
                                        @enderror" aria-required="true" aria-invalid="false">
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback d-inline-block mb-4">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                    <div class="form-group">
                                        <label class="control-label mb-1">Confirm Password</label>
                                        <input id="cc-pament" name="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid
                                        @enderror" aria-required="true" aria-invalid="false">
                                    </div>
                                    @error('password_confirmation')
                                        <div class="invalid-feedback d-inline-block mb-4">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                    <div class="form-group">
                                        <label class="control-label mb-1">Role</label>
                                        <input id="cc-pament" name="role" type="text" class="form-control" disabled aria-required="true" aria-invalid="false"
                                        value="admin" >
                                    </div>

                                </div>

                                <div class="row col-6 offset-3">
                                    <button class="btn btn-dark text-white py-2" type="submit">
                                        <i class="fa-solid fa-plus"></i>  Create an Admin
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
