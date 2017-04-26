@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('fountain.admin.partials.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <a href="{{ route('fountain.admin.users.create') }}" class="btn btn-primary btn-sm pull-right">Create New User</a>
                        <table class="table table-striped avatar">
                            <thead>
                                <tr>
                                    <th width="40"></th>
                                    <th>Name</th>
                                    <th>Email Address</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>
                                            <img src="{{ $user->gravatar }}" class="img-circle" width="40px;">
                                        </td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            <a href="{{ route('fountain.admin.users.edit', $user->id) }}" class="btn btn-success btn-xs">
                                                Edit
                                            </a>
                                            <a href="{{ route('fountain.admin.users.destroy', $user->id) }}" class="btn btn-danger btn-xs"
                                               onclick="event.preventDefault();
                                                     document.getElementById('delete-user-{{ $user->id }}-form').submit();">
                                                Delete
                                            </a>

                                            <form id="delete-user-{{ $user->id }}-form" action="{{ route('fountain.admin.users.destroy', $user->id) }}" method="POST" style="display: none;">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                            </form>
                                        </td>
                                        <td>
                                            <a href="{{ route('fountain.admin.users.login-as', $user->id) }}" class="btn btn-warning btn-xs">
                                                Login As User
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection