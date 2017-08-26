@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row" id="settings">
        @include('fountain.partials.sidebar')
        <div class="col-md-9">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">Payment Method</h3>
              </div>
              <div class="panel-body">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <form class="form-horizontal" action="{{ route('fountain.billing.paymentmethodupdate') }}" method="POST" id="paymentMethodUpdate">
                    {{ csrf_field() }}
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="col-sm-3 control-label">Cardholder's Name</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" name="name" id="name">

                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="ccnumber" class="col-sm-3 control-label">Card Number</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" data-stripe="number" placeholder="{{ isset(Auth::user()->card_last_four) ? "************".Auth::user()->card_last_four : '' }}" maxlength="16">
                            @if ($errors->has('ccnumber'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('ccnumber') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('cvc') ? ' has-error' : '' }}">
                        <label for="cvc" class="col-sm-3 control-label">Security Code</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" data-stripe="cvc" maxlength="4">
                            @if ($errors->has('cvc'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('cvc') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="exp" class="col-sm-3 control-label">Expiration</label>
                        <div class="col-sm-7">
                            <div class="row">
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" data-stripe="exp-month" placeholder="MM" maxlength="2">
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" data-stripe="exp-year" placeholder="YYYY" maxlength="4">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('cvc') ? ' has-error' : '' }}">
                        <label for="zip" class="col-sm-3 control-label">Zip Code</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control">
                            @if ($errors->has('zip'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('zip') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-7 col-sm-offset-3">
                            <div class="stripe-errors alert alert-info" style="display:none;"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-8">
                            <button type="submit" class="btn btn-default">Update</button>
                        </div>
                    </div>
                </form>
              </div>
            </div>
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">Manager Payment Methods</h3>
              </div>
              <div class="panel-body">
                <table class="table table-striped table-bordered">
                    <thead>
                        <th>Type</th>
                        <th>Number</th>
                        <th>Status</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @foreach($cards['sources']['data'] as $card)
                            <tr>
                                <td>{{ $card['brand'] }}</td>
                                <td>************{{ $card['last4'] }}</td>
                                <td>
                                    @if($defaultCard == $card['id'])
                                        <span class="label label-primary">Default Card</span>
                                    @else
                                        <a href="{{ route('fountain.billing.defaultpaymentmethod', ['card' => $card['id']]) }}" class="label label-success" style="text-decoration: none">Make Default</a>
                                    @endif
                                </td>
                                <td></td>
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
@section('scripts')
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

{{-- Add stripe token to form on submit --}}
<script>
$(document).ready(function() {
Stripe.setPublishableKey('{{ env('STRIPE_KEY')}}');
    $('#paymentMethodUpdate button').on('click', function() {
        var form = $('#paymentMethodUpdate');
        var submit = form.find('button');
        var submitInitialText = submit.text();
        submit.attr('disabled', 'disabled').text('Processing...');
        Stripe.card.createToken(form, function(status, response){
            var token;
            if(response.error){
                form.find('.stripe-errors').text(response.error.message).show();
                submit.removeAttr('disabled');
                submit.text(submitInitialText);
            } else
            {
                token = response.id;
                form.append($('<input type="hidden" name="stripeToken">').val(token));
                form.submit();
            }
        });
    });
});
</script>
@endsection
