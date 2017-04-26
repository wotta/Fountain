@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('fountain.admin.partials.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <a href="{{ route('fountain.admin.plans.create') }}" class="btn btn-primary btn-sm pull-right">Create New Plan</a>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($plans as $plan)
                                    <tr>
                                        <td>{{ $plan->name }}</td>
                                        <td>${{ number_format($plan->amount / 100, 2, '.', ',') }}</td>
                                        <td>
                                            <a href="{{ route('fountain.admin.plans.show', $plan->id) }}" class="btn btn-primary btn-xs">Who's Subscribed</a>
                                            <a href="{{ route('fountain.admin.plans.destroy', $plan->id) }}" class="btn btn-danger btn-xs"
                                               onclick="event.preventDefault();
                                                     document.getElementById('delete-plan-{{ $plan->id }}-form').submit();">
                                                Delete
                                            </a>

                                            <form id="delete-plan-{{ $plan->id }}-form" action="{{ route('fountain.admin.plans.destroy', $plan->id) }}" method="POST" style="display: none;">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                            </form>
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