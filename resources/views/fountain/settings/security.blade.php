@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row" id="settings">
        @include('fountain.partials.sidebar')
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Password</h3>
                </div>
                <div class="panel-body">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                    <form class="form-horizontal" action="{{ route('fountain.settings.changepassword') }}" method="POST" id="settingsUpdate">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="current_password" class="col-sm-2 control-label">Current</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" name="current_password" id="current_password">
                                @if ($errors->has('current_password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('current_password') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-sm-2 control-label">Password</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" name="password" id="password">
                                @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-default">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
@section('scripts')
@endsection
