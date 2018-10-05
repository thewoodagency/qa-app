@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <h2>Edit Your Answer for {{ $question->title }}</h2>
                        </div>
                        <hr>
                        <form action="{{ route('questions.answers.update', [$question->id, $answer->id]) }}"
                              method="post">
                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                        <textarea name="body" id="body" rows="7"
                                  class="form-control {{ $errors->has('body') ? 'is-invalid' : '' }}">{{ old('body', $answer->body) }}</textarea>
                                @if ($errors->has('body'))
                                    <div class="invalid-feedback">
                                        <strong>{{ $errors->first('body') }}</strong>
                                    </div>
                                @endif
                            </div>

                            <button type="submit" class="btn btn-outline-primary btn-lg">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection