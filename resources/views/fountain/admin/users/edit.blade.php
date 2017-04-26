@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('fountain.admin.partials.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="page-header m-t-0 m-b-xs">
                            <h4>General Information</h4>
                        </div>
                        <form class="form-horizontal" action="{{ route('fountain.admin.users.update', $user->id) }}" method="POST">
                            {{ method_field('PATCH') }}
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-sm-2 control-label">Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="name" id="name" value="{{ $user->name ?? old('name') }}" placeholder="John Doe">

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-sm-2 control-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" name="email" id="email" value="{{ $user->email ?? old('email') }}" placeholder="johndoe@example.com">

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-default">Update User</button>
                                    <a href="{{ route('fountain.admin.users.index') }}" class="btn btn-danger">Cancel</a>
                                </div>
                            </div>
                        </form>
                        <div class="page-header m-b-0">
                            <h4>Subscriptions</h4>
                        </div>
                        @if ($user->subscriptions->count() > 0)
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($user->subscriptions as $subscription)
                                        <tr>
                                            <td>{{ $subscription->name }}</td>
                                            <td><span class="label {{ $subscription->active() ? 'label-success' : 'label-danger' }}">{{ $subscription->active() ? 'Active' : 'Inactive' }}</span></td>
                                            <td>
                                                <a href="{{ route('fountain.admin.users.unsubscribe', [$user->id, $subscription->stripe_plan]) }}" class="btn btn-danger btn-xs"
                                                   onclick="event.preventDefault();
                                                         document.getElementById('unsubscribe-form').submit();">
                                                    Unsubscribe
                                                </a>

                                                <form id="unsubscribe-form" action="{{ route('fountain.admin.users.unsubscribe', [$user->id, $subscription->name]) }}" method="POST" style="display: none;">
                                                    {{ method_field('DELETE') }}
                                                    {{ csrf_field() }}
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="text-center m-b-lg">User doesn't have any subscriptions.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection