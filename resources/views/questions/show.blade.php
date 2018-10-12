@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <div class="d-flex align-items-center">
                                <h1>{{ $question->title }}</h1>
                                <div class="ml-auto">
                                    <a href="{{ route('questions.index') }}" class="btn btn-outline-secondary">Back to
                                        All</a>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="media">
                            <div class="d-flex flex-column vote-controls">
                                @include('shared._vote', [
                            'model' => $question
                        ])
                                <a title="Click to mark as a favorite"
                                   class="favorite mt-2 {{ Auth::guest() ? 'off' : ($question->is_favorited ? 'favorited' : '') }}"
                                   onclick="event.preventDefault(); document.getElementById('favorite-{{ $question->id }}').submit()"
                                >
                                    <i class="fas fa-star fa-2x"></i>
                                    <span class="favorites-count">{{ $question->favorites_count }}</span>
                                </a>
                                <form id="favorite-{{ $question->id }}"
                                      action="{{ route('questions.favorite', $question->id) }}"
                                      method="post">
                                    @csrf
                                    @if ($question->is_favorited)
                                        @method('DELETE')
                                    @endif
                                </form>
                            </div>
                            <div class="media-body">
                                <p class="lead">
                                    Asked by
                                    <a href="{{ $question->user->url }}">
                                        {{ $question->user->name }}
                                    </a>
                                    <small class="text-muted">{{ $question->created_date }}</small>
                                </p>
                                {!! $question->body_html !!}
                                <div class="row">
                                    <div class="col-4"></div>
                                    <div class="col-4"></div>
                                    <div class="col-4">
                                        @include('shared._author', [
                                            'model' => $question,
                                            'label' => "Asked"
                                        ])
                                        <user-info :model="{{ $question }}" label="Asked"></user-info>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include ("answers._index", [
            'answers' => $question->answers,
            'answersCount' => $question->answers_count
        ])
        @include ("answers._create")
    </div>
@endsection