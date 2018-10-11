@if ($answersCount > 0)
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h3>{{ $answersCount }} Answers</h3>
                    </div>
                    <hr>
                    @include ('layouts._messages')

                    @foreach($answers as $answer)
                        <div class="media">
                            <div class="d-fex flex-column vote-controls">
                                @include('shared._vote', [
                                'model' => $answer
                            ])
                                @can ('accept', $answer)
                                    <a title="Mark this answer as best answer"
                                       class="{{ $answer->status }} mt-2"
                                       onclick="event.preventDefault(); document.getElementById('accept-answer-{{$answer->id}}').submit()"
                                    >
                                        <i class="fas fa-check fa-2x"></i>
                                    </a>
                                    <form method="post" style="display: none;" id="accept-answer-{{$answer->id}}"
                                          action="{{ route('answers.accept', $answer->id) }}"
                                    >
                                        @csrf
                                    </form>
                                @else
                                    @if ($answer->is_best)
                                        <a title="Marked as best answer"
                                           class="{{ $answer->status }} mt-2"
                                        >
                                            <i class="fas fa-check fa-2x"></i>
                                        </a>
                                    @endif
                                @endcan
                            </div>
                            <div class="media-body">
                                {!! $answer->body_html !!}
                                <div class="row">
                                    <div class="col-4">
                                        <div class="ml-auto">
                                            @can ('update', $answer)
                                                <a href="{{ route('questions.answers.edit', [$question->id, $answer->id]) }}"
                                                   class="btn btn-sm btn-outline-info">Edit</a>
                                            @endcan

                                            @can('delete', $answer)
                                                <form class="form-delete" method="post"
                                                      action="{{ route('questions.answers.destroy', [$question->id, $answer->id]) }}">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                                            onclick="return confirm('Sure to delete your answer?')">
                                                        Delete
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </div>
                                    <div class="col-4"></div>
                                    <div class="col-4">
                                        @include('shared._author', [
                                            'model' => $answer,
                                            'label' => 'Answered'
                                        ])
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endif
