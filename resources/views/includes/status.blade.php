<div class="card status mt-3" id="status-{{ $status->id }}" data-body="{{ $status->body }}">
    
    @if (Route::current()->uri == "status/{id}")
        <?php $mapLines = $status->trainCheckin->getMapLines(); ?>
        @if($mapLines != "[]")
        <div class="card-img-top">
            <div id="map-{{ $status->id }}" class="map statusMap embed-responsive embed-responsive-21by9" data-polygon="{{ $mapLines }}"></div>
        </div>
        @endif
    @endif

    <div class="card-body row">
        <div class="col-2 image-box pr-0 d-none d-lg-flex">
            <a href="{{ route('account.show', ['username' => $status->user->username]) }}">
                <img src="/uploads/avatars/{{ $status->user->avatar }}">
            </a>
        </div>

        <div class="col pl-0">
            <ul class="timeline">
                <li>
                    <span class="text-trwl float-right">{{ date('H:i', strtotime($status->trainCheckin->departure)) }}</span>
                    <span class="text-trwl">{{ $status->trainCheckin->getOrigin->name }} </span>

                    <p class="train-status">
                        <i class="fas fa-subway"></i> {{ $status->trainCheckin->getHafasTrip->linename }}
                        @if($status->business)
                            <i class="pl-2 fas fa-briefcase"></i>
                        @endif
                    </p>

                    @if(!empty($status->body))
                        <p class="status-body"><i class="fas fa-quote-right"></i> {{ $status->body }}</p>
                    @endif
                </li>
                <li>
                    <span class="text-trwl float-right">{{ date('H:i', strtotime($status->trainCheckin->arrival)) }}</span>
                    <span class="text-trwl">{{ $status->trainCheckin->getDestination->name }}</span>
                </li>
            </ul>
        </div>
    </div>
    <div class="progress">
        <div
            class="progress-bar progress-time"
            role="progressbar"
            style="width: 0%"
            aria-valuenow="{{ time() }}"
            aria-valuemin="{{ strtotime($status->trainCheckin->departure) }}"
            aria-valuemax="{{ strtotime($status->trainCheckin->arrival) }}"
            ></div>
    </div>
    <div class="card-footer text-muted interaction">
        <span class="float-right">
            <a href="{{ route('account.show', ['username' => $status->user->username]) }}">
                @if(Auth::user() == $status->user)
                {{__('user.you')}}
                @else
                {{ $status->user->username }}
                @endif
            </a>{{__('dates.-on-')}}
            <a href="{{ url('/status/'.$status->id) }}">
                {{ date('H:i', strtotime($status->created_at)) }}
            </a>
        </span>
        <ul class="list-inline">
            <li class="list-inline-item d-lg-none">
                <a href="{{ route('account.show', ['username' => $status->user->username]) }}">
                    <img src="/uploads/avatars/{{ $status->user->avatar }}" class="profile-image" alt="{{__('settings.picture')}}">
                </a>
            </li>
            @if(Auth::check())
            <li class="list-inline-item">
                <a href="#" class="like {{ $status->likes->where('user_id', Auth::user()->id)->first() === null ? 'far fa-heart' : 'fas fa-heart'}}" data-statusid="{{ $status->id }}"></a>
            </li>
            @endif
            @if(Auth::user() == $status->user)
            <li class="list-inline-item">
                <a href="#" class="edit" data-statusid="{{ $status->id }}"><i class="fas fa-edit"></i></a>
            </li>

            <li class="list-inline-item">
                <a href="#" class="delete" data-statusid="{{ $status->id }}"><i class="fas fa-trash"></i></a>
            </li>
            @endif
        </ul>
    </div>
</div>
