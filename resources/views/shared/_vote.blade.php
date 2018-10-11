@if ($model instanceof App\Question)
    @php
        $name = 'question';
        $route = 'questions';
    @endphp
@elseif ($model instanceof App\Answer)
    @php
        $name = 'answer';
        $route = 'answers';
    @endphp
@endif
<a title="This {{$name}} is useful"
   class="vote-up {{ Auth::guest() ? 'off' : '' }}"
   onclick="event.preventDefault(); document.getElementById('voteup{{$model->id}}').submit()">
    <i class="fas fa-caret-up fa-3x"></i>
</a>
<form id="voteup{{$model->id}}"
      action="{{ route($route .'.vote', $model->id) }}"
      method="post">
    @csrf
    <input type="hidden" name="vote" value="1">
</form>
<span class="votes-count">{{ $model->votes_count }}</span>
<a title="This {{$name}} is not useful"
   class="vote-down {{ Auth::guest() ? 'off' : '' }}"
   onclick="event.preventDefault(); document.getElementById('votedown{{$model->id}}').submit()"
>
    <i class="fas fa-caret-down fa-3x"></i>
</a>
<form id="votedown{{$model->id}}"
      action="{{ route($route .'.vote', $model->id) }}"
      method="post">
    @csrf
    <input type="hidden" name="vote" value="-1">
</form>