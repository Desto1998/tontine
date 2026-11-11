@foreach($statusHistories as $history)
    <div class="col-md-2 col-sm-4 ">
        <div class="workflow-step active bg-light p-2">
            <div class="step-icon {{ $history['style'] }}">
                <i class="fa {{ $history['icon'] }}"></i>
            </div>

            <h6>{{ $history['status_name'] }}</h6>

            <small class="text-muted d-block">
                {{ $history['comment'] }}
            </small>

            <small class="text-muted d-block">
                Par : <strong>{{ $history['user_name'] }}</strong> le
                {{ $history['created_at'] }}
            </small>
        </div>
    </div>
@endforeach
