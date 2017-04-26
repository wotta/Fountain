@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('fountain.admin.partials.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form class="form-horizontal" action="{{ route('fountain.admin.plans.store') }}" method="POST">
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-sm-2 control-label">Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" placeholder="Plan Name">

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                                <label for="amount" class="col-sm-2 control-label">Amount</label>
                                <div class="col-sm-10">
                                    <div class="input-group">
                                        <span class="input-group-addon">$</span>
                                        <input type="number" class="form-control" name="amount" id="amount" step="any" value="{{ old('amount') }}" placeholder="1.00">
                                    </div>

                                    @if ($errors->has('amount'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('amount') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('interval') || $errors->has('interval_count') ? ' has-error' : '' }}">
                                <label for="interval" class="col-sm-2 control-label">Interval</label>
                                <div class="col-md-4">
                                    <select name="interval" id="interval" class="form-control">
                                        <option value="day">Days</option>
                                        <option value="month">Months</option>
                                        <option value="year">Years</option>
                                    </select>

                                    @if ($errors->has('interval'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('interval') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <label for="interval_count" class="col-sm-2 control-label">Interval Count</label>
                                <div class="col-md-4">
                                    <input type="number" class="form-control" name="interval_count" id="interval_count" placeholder="1" value="{{ old('interval_count') }}" min="0">

                                    @if ($errors->has('interval_count'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('interval_count') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('trial_period_days') ? ' has-error' : '' }}">
                                <label for="trial_period_days" class="col-sm-2 control-label">Trial Period</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" name="trial_period_days" id="trial_period_days" value="{{ old('trial_period_days') }}" placeholder="0" min="0">

                                    @if ($errors->has('trial_period_days'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('trial_period_days') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-default">Create Plan</button>
                                    <a href="{{ route('fountain.admin.plans.index') }}" class="btn btn-danger">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
