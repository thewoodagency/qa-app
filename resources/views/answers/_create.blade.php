<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h2>Your Answer</h2>
                </div>
                <hr>
                <form action="{{ route('questions.answers.store', $question->id) }}" method="post">
                    @csrf
                    <div class="form-group">
                        <textarea name="body" id="body" rows="7"
                                  class="form-control {{ $errors->has('body') ? 'is-invalid' : '' }}"></textarea>
                        @if ($errors->has('body'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('body') }}</strong>
                            </div>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-outline-primary btn-lg">submit</button>
                </form>
            </div>
        </div>
    </div>
</div>