@if ($answersCount > 0)
    <div class="row mt-4" v-cloak>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h3>{{ $answersCount }} Answers</h3>
                    </div>
                    <hr>
                    @include ('layouts._messages')

                    @foreach($answers as $answer)
                        <answer :answer="{{ $answer }}" inline-template>
                            <div class="media post">
                                <div class="d-fex flex-column vote-controls">
                                    @include('shared._vote', [
                                    'model' => $answer
                                ])
                                    @can ('accept', $answer)
                                        <a title="Mark this answer as best answer (inline-template Vue)"
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
                                    <form v-if="editing === true" @submit.prevent="updateAnswer">
                                        <div class="form-group">
                                            <textarea v-model="body" rows="10" class="form-control" required></textarea>
                                        </div>
                                        <button class="btn btn-primary" :disabled="isInvalid">Update</button>
                                        <button class="btn btn-outline-secondary" @click="cancel" type="button">Cancel</button>
                                    </form>
                                    <div v-else>
                                        <div v-html="bodyHtml"></div>
                                        <div class="row">
                                            <div class="col-4">
                                                <div class="ml-auto">
                                                    @can ('update', $answer)
                                                        <a v-on:click.prevent="edit"
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
                                                <user-info :model="{{ $answer }}" label="Answered"></user-info>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </answer>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endif
