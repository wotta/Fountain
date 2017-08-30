@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row" id="subscription">
        @include('fountain.partials.sidebar')
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Subscription</h3>
                </div>
                <div class="panel-body">
                    @if($defaultCard == null)
                        <div class="alert alert-info">
                            <p>You need to <a href="{{ route('fountain.billing.paymentmethod') }}">add a credit card</a> before subscribing.</p>
                        </div>
                    @else

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
                                    @if($plan->id == $currentPlan)
                                        <label class="btn btn-primary btn-xs" style="cursor: default;">Subscribed</label>
                                    @else
                                        <a href="{{ route('fountain.billing.changeplan', $plan->id) }}" class="btn btn-success btn-xs"
                                        onclick="event.preventDefault();
                                                     document.getElementById('change-plan-{{ $plan->id }}-form').submit();">
                                            Change Plan
                                            </a>

                                            <form id="change-plan-{{ $plan->id }}-form" action="{{ route('fountain.billing.changeplan', $plan->id) }}" method="POST" style="display: none;">
                                                {{ csrf_field() }}
                                            </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif

                </div>
            </div>
            @if($currentPlan != null)
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Manage Plan</h3>
                </div>
                <div class="panel-body">
                    <div>
                            @if(Auth::user()->subscription('main')->cancelled())
                                <p>Your subscription will end on {{ Carbon\Carbon::parse($planEnd)->format('m-d-Y') }}</p>
                            @endif
                            <div>
                                @if(!Auth::user()->subscription('main')->cancelled())
                                    <a href="{{ route('fountain.billing.cancelplan') }}" class="btn btn-danger">Cancel my subscription</a>
                                @else
                                    <a href="{{ route('fountain.billing.resumeplan') }}" class="btn btn-info">Resume subscription</a>
                                @endif
                            </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection
@section('scripts')

@endsection
