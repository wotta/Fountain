<div class="col-md-3">
    <div class="panel panel-default">
        <div class="panel-heading">Billing</div>
        <ul class="list-group">
            <li class="list-group-item"><a href="{{ route('fountain.admin.plans.index') }}">Plans</a></li>
        </ul>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">Fountain</div>
        <ul class="list-group">
            <li class="list-group-item"><a href="{{ route('fountain.admin.users.index') }}">Users</a></li>
            <li class="list-group-item"><a href="">Settings</a></li>
        </ul>
    </div>

    @if ($addons = cache()->get('fountain:addons')['admin'])
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
</div>