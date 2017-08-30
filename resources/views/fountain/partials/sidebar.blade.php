<div class="col-md-3">
    <div class="panel panel-default">
        <div class="panel-heading">Settings</div>
        <ul class="list-group">
            <li class="list-group-item"><a href="{{ route('fountain.settings.index') }}">Profile</a></li>
            <li class="list-group-item"><a href="{{ route('fountain.settings.password') }}">Security</a></li>
            <li class="list-group-item"><a href="">API</a></li>
        </ul>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">Billing</div>
        <ul class="list-group">
            <li class="list-group-item"><a href="{{ route('fountain.billing.subscriptionindex') }}">Subscription</a></li>
            <li class="list-group-item"><a href="{{ route('fountain.billing.paymentmethod') }}">Payment Method</a></li>
            <li class="list-group-item"><a href="{{ route('fountain.billing.invoices.index') }}">Invoices</a></li>
        </ul>
    </div>
    @if ($addons = cache()->get('fountain:addons')['user'])
        @foreach($addons as $addon)
            <div class="panel panel-default">
                <div class="panel-heading">{{ $addon['title'] }}</div>
                <ul class="list-group">
                    @foreach($addon['menu'] as $link)
                        <li class="list-group-item"><a href="{{ route($link['route']) }}">{{ $link['text'] }}</a></li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    @endif
    @if(auth()->user()->is_admin)
        <div class="panel panel-default">
            <div class="panel-heading">Administration</div>
            <ul class="list-group">
                <li class="list-group-item"><a href="{{ route('fountain.admin.users.index') }}">Users</a></li>
            </ul>
        </div>
    @endif
</div>
