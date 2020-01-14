@if(!count($invites))
    <span class="small none">{!! __('messages.no-invites-sent') !!}</span>
@else
    <hr>
    <div class="stats">
        {!! __('messages.count-invites', ['count' => count($invites), 'skipCount' => $skipCount, 'maxDistance' => $maxDistance]) !!}
    </div>
    <hr>

    @foreach($invites as $item)
        <div class="media item pt-1">
            <div class="icon p-1 pr-3">
                <i class="fas fa-user"></i>
            </div>
            <div class="media-body pt-1">
                <p class="mt-0">
                    {!! __('messages.invite-sent-to-user', ['name' => $item['name'], 'distance' => round($item['distance'], 2), 'distanceMetric' => 'Km']) !!}
                </p>
            </div>
        </div>
    @endforeach
@endif