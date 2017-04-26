@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('fountain.admin.partials.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h4>Users subscribed to {{ strtolower($plan->name) }}</h4>
                        <hr>
                        @if ($subscriptions->count() > 0)
                            <table class="table table-striped avatar">
                                <thead>
                                    <tr>
                                        <th width="40"></th>
                                        <th>Name</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($subscriptions as $subscription)
                                        <tr>
                                            <td>
                                                <img src="{{ $subscription->user->gravatar }}" class="img-circle" width="40px;">
                                            </td>
                                            <td>{{ $subscription->user->name }}</td>
                                            <td><span class="label {{ $subscription->active() ? 'label-success' : 'label-danger' }}">{{ $subscription->active() ? 'Active' : 'Inactive' }}</span></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="text-center">There aren't any users subscribed to this plan.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection