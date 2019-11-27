@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
          <div class="card">
                      <div class="card-header">
                        <div class="d-flex align-items-center">
                          <h3>Edit Question</h3>
                            <div class="ml-auto">
                              <a class="btn btn-outline-secondary" href="{{route('questions.index')}}">
                                Back to All Question</a>
                            </div>
                      </div>
                    </div>
                        <div class="card-body">
                            <form action="{{route('questions.update',$question->id)}}" method="post">
                              @method('put')

                              @csrf
                              <div class="form-group">
                                <label for="question-title">Question Title</label>
                                <input value="{{old('title',$question->title)}}"class="form-control {{$errors->has('title')
                                ? 'is-invalid' : ''}}" name="title" type="text" id="question-title">
                                @if ($errors->has('title'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                                </div>
                                <div class="form-group">
                                  <label for="question-body">Explain Your Question
                                  </label>
                                  <textarea class="form-control {{$errors->has('body') ? 'is-invalid' : ''}}" id="question-body"rows="10" name="body" >
                                    {{old('body',$question->body)}}
                                  </textarea>
                                  @if ($errors->has('body'))
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $errors->first('body') }}</strong>
                                      </span>
                                  @endif
                                  </div>
                                  <div class="form-group">
                                    <button class="btn btn-outline-primary btn-lg"type="submit">Update This Question
                                    </button>

                                  </div>
                          </form>
                  </div>
            </div>
        </div>
    </div>
</div>


@endsection
