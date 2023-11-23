@extends('admin.layouts.master')

@section('title', 'User List')

@section('user', 'active')

@section('searchbar')
    <form class="form-header" action="{{ route('admin#userList') }}" method="GET">
        @csrf
        <input class="au-input au-input--xl" type="text" name="searchKey" placeholder="Search for user..." value="{{ request('searchKey') }}"/>
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
                                <h2 class="title-1">User List</h2>

                            </div>
                        </div>
                        <div class="table-data__tool-right">
                            <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                CSV download
                            </button>
                        </div>
                    </div>

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

                    @if (session('deleteSuccess'))
                        <div class="col-4 offset-8">
                            <div class="alert alert-danger d-flex align-items-center alert-dismissible fade show" id="alert" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                                <div class="mx-4">
                                    {{ session('deleteSuccess') }}
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    @endif

                    @if (isset($users) && count($users) > 0)
                    <div class="table-responsive table-responsive-data2" style="overflow-x: auto">
                        <table class="table table-data2">
                            <thead>
                                <tr>
                                    <th style="background: #e5e5e5">ID</th>
                                    <th style="background: #e5e5e5">Image</th>
                                    <th style="background: #e5e5e5">Username</th>
                                    <th style="background: #e5e5e5">Email</th>
                                    <th style="background: #e5e5e5">Phone</th>
                                    <th style="background: #e5e5e5">Address</th>
                                    <th style="background: #e5e5e5">Gender</th>
                                    <th style="background: #e5e5e5">Role</th>
                                    <th style="background: #e5e5e5">Created Date</th>
                                    <th style="background: #e5e5e5">Updated Date</th>
                                    <th class="row offset-4" style="background: #e5e5e5">Actions</th>
                                </tr>
                            </thead>
                            <tbody>

                                    @foreach ($users as $user)
                                    <tr class="tr-shadow">
                                        <td>{{ $user->id }}</td>
                                        <td>
                                            <div class="" style="width: 150px; height: 150px">
                                            @if (empty($user->image) && $user->gender === 'male')
                                                <img src="{{ asset('image/male.png') }}" alt="user Profile" class="img-thumbnail shadow-sm object-cover w-100 h-100 " style="object-position: center"/>
                                            @elseif (empty($user->image) && $user->gender === 'female')
                                                <img src="{{ asset('image/female.png') }}" alt="user Profile" class="img-thumbnail shadow-sm object-cover w-100 h-100 " style="object-position: center"/>
                                            @else
                                            <img src="{{ asset('storage/' . $user->image) }}" alt="user profile" class="img-thumbnail shadow-sm object-cover w-100 h-100 " style="object-position: center">
                                            @endif
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-capitalize" style="width: 100px !important; display:inline-block">{{ $user->username }}</span>
                                        </td>
                                        <td>
                                            <span >{{ $user->email }}</span>
                                        </td>
                                        <td>
                                            <span >{{ $user->phone }}</span>
                                        </td>
                                        <td>
                                            <span style="width: 200px !important; display:inline-block">{{ $user->address }}</span>
                                        </td>
                                        <td>
                                            <span >{{ $user->gender }}</span>
                                        </td>
                                        <td>
                                            <span >{{ $user->role }}</span>
                                        </td>
                                        <td >{{ $user->created_at->format('F j, Y') }}</td>
                                        <td>{{ $user->updated_at->format('F j, Y') }}</td>
                                        <td>
                                            <div class="table-data-feature justify-content-center">
                                                <button class="item mr-4" data-toggle="tooltip" data-placement="top" title="Send">
                                                    <i class="zmdi zmdi-mail-send"></i>
                                                </button>
                                                <a class="item mr-4" data-toggle="tooltip" data-placement="top"
                                                    title="Promote to Admin" href="{{ route('admin#promote', $user->id) }}"
                                                 >
                                                    <i class="fa-solid fa-person-circle-plus"></i>
                                                </a>
                                                <a class="item mr-4 cursor-pointer" data-toggle="tooltip" data-placement="top"
                                                   title="Delete" href="{{ route('admin#deleteUser', $user->id) }}"
                                                >
                                                        <i class="zmdi zmdi-delete"></i>
                                                </a>
                                                <button class="item mr-4" data-toggle="tooltip" data-placement="top" title="More">
                                                    <i class="zmdi zmdi-more"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="spacer"></tr>
                                    @endforeach

                            </tbody>
                        </table>

                        @else
                            <div class="d-flex flex-column justify-content-center align-items-center mt-5">
                                <img src="{{ asset('image/no-users-found.png') }}" alt="no users available">
                                <h3>No user found!</h3>
                            </div>
                        @endif

                    </div>
                    <!-- END DATA TABLE -->
                    <div class="mt-4">
                        {{-- {{ $categories->links() }} --}}
                        @if(isset($users))
                            {{ $users->appends(request()->query())->links() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
