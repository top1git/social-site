@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
          <div class="card">
              <div class="card-body">
                <div class="card-title">
                    <div class="d-flex align-items-center">
                          <h2>{{$question->title}}</h2>
                            <div class="ml-auto">
                                <a class="btn btn-outline-secondary" href="{{route('questions.index')}}">
                                  Back to All Question</a>
                              </div>
                      </div>
                </div><hr>
                <!-- vote ------------>
              <div class="media">
                      <div class="d-flex flex-column votes-control">

                        <a class="vote-up
    {{Auth::guest() ? 'off' : ''}}" onclick="event.preventDefault(); document.getElementById('questions-vote-up{{$question->id}}').submit()">
                                    <i class="fas fa-caret-up fa-3x"></i>
                                </a>
                                <span class="votes-count">
                                {{$question->votes_count}}
                            </span>
              <form action="/questions/{{$question->id}}/vote" id="questions-vote-up{{$question->id}}"
                  style="display: none" method="post">
                @csrf
      <input type="hidden" name="vote" value="1">
          </form>
                <a class="vote-down
                     {{Auth::guest() ? 'off' : '' }}"
            onclick="event.preventDefault(); document.getElementById('questions-vote-down{{$question->id}}').submit()">
                                    <i class="fas fa-caret-down fa-3x"></i>
                                </a>
      <form action="/questions/{{$question->id}}/vote" id="questions-vote-down{{$question->id}}" style="display: none" method="post">
                                    @csrf
                                    <input type="hidden" name="vote" value="-1">
                                </form>

                        <!-- Favorite ------------>
                    <a title="Mark as Favourite"class="favorite mt-3
               {{Auth::guest() ? 'off' :($question->is_favorited) ? 'favoritted':''}}"
                onclick="event.preventDefault(); document.getElementById('questions-favorites-{{$question->id}}').submit()">
                  <i class="fas fa-star fa-2x"></i>
                          <span class="faborite">
                            {{$question->favorites_count}}
                               </span>
                               </a>
                               <form action="/questions/{{$question->id}}/favorites"
                                     id="questions-favorites-{{$question->id}}" style="display: none" method="post">
                                   @csrf
                                   @if($question->is_favorited)
                                       @method('DELETE')
                                   @endif
                               </form>
                               <!-- Favorite ------------>
                      </div>
                      <div class="media-body">
                          {!! $question->body_html  !!}
                          <div class="float-right">
                            <span class="text-muted">
                            Question  {{$question->create_date}}
                            </span>
                            <div class="media">
                              <a class="pr-2" href="{{$question->user->url}}">
                                <img src="{{$question->user->avatar}}">
                              </a>
                              <div class="media-body">
                                <a href="{{$question->user->url}}">
                                  {{$question->user->name}}
                                </a>
                              </div>
                            </div>
                          </div>
                    </div>
                    </div>
              </div>
            </div>
        </div>
      </div>      <!-- Answer Row ------------>
    <div class="row mt-5">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="card-title">
              <h2>Your Answer</h2>
              @include('layouts._message')
              <!-- form validation------>
              <form action="{{route('questions.answers.store', $question->id)}}"
                 method="post">
                @csrf
                <div class="form-group">
                <textarea rows="7" class="form-control
                {{$errors->has('body') ? 'is-invalid' : ''}}"  name="body" >
                  </textarea>
                                @if ($errors->has('body'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('body') }}</strong>
                                    </span>
                                @endif
                </div>
                <div class="form-group">
                  <button class="btn btn-outline-primary" type="submit">Submit</button>
                </div>
              </form> <hr><h3>
                {{$question->answers_count}}
                {{str_plural('Answer',$question->answers_count)}}
              </h3></div>
          </div><hr>
          @foreach($question->answers as $answer)
          <div class="media">
            <div class="d-flex flex-column votes-control">

              <a class="vote-up
{{Auth::guest() ? 'off' : ''}}" onclick="event.preventDefault(); document.getElementById('answers-vote-up{{$answer->id}}').submit()">
                          <i class="fas fa-caret-up fa-3x"></i>
                      </a>
                      <span class="votes-count">
                      {{$answer->votes_count}}
                  </span>
    <form action="/answers/{{$answer->id}}/vote" id="answers-vote-up{{$answer->id}}"
        style="display: none" method="post">
      @csrf
<input type="hidden" name="vote" value="1">
</form>
      <a class="vote-down
           {{Auth::guest() ? 'off' : '' }}"
  onclick="event.preventDefault(); document.getElementById('answers-vote-down{{$answer->id}}').submit()">
                          <i class="fas fa-caret-down fa-3x"></i>
                      </a>
<form action="/answers/{{$answer->id}}/vote" id="answers-vote-down{{$answer->id}}" style="display: none" method="post">
                          @csrf
                          <input type="hidden" name="vote" value="-1">
                      </form>
                    @can('accept',$answer)
                  <a title="Choose AS Best Answeer" class="favorite mt-3 {{$answer->status}}"
                     onclick="event.preventDefault(); document.getElementById
                     ('answer-accept-{{$answer->id}}').submit();">
                    <i class="fas fa-check fa-2x"></i>
                    </a>
                    <form id="answer-accept-{{$answer->id}}" style="display: none;"
                       action="{{route('accept.answer',$answer->id)}}" method="post">
                      @csrf
                    </form>
                    @else
                      @if($answer->is_best)
                      <a title="Questioner select this answer Best Answeer" class="favorite mt-3 {{$answer->status}}">
                        <i class="fas fa-check fa-2x"></i>
                        </a>

                      @endif
                  @endcan
            </div>
            <div class="media-body">
              {!! $answer->body_html !!}   <!--edit and delete---->
              <div class="row">
                <div class="col-md-4">
                  <div class="ml-auto">
                    @can('update',$answer)
                      <a class="btn btn-sm btn-outline-primary
                      "href="{{route('questions.answers.edit',[$question->id, $answer->id])}}">
                        Edit</a>
                        @endcan()
                         @can('delete',$answer)
                        <form class="form-delete"action="{{route('questions.answers.destroy',[$question->id, $answer->id])}}" method="post">
                                @method('Delete') @csrf
                          <button onclick="return confirm('Are You Sure')" class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                        </form>
                        @endcan('update',$question)
                  </div>
                </div>
              </div>
            <!--edit and delete---->
              <div class="float-right">
                <span class="text-muted">
                Answered  {{$answer->create_date}}
                </span>
                <div class="media">
                  <a class="pr-2" href="{{$answer->user->url}}">
                    <img src="{{$answer->user->avatar}}">
                  </a>
                  <div class="media-body">
                    <a href="{{$answer->user->url}}">
                      {{$answer->user->name}}
                    </a>
                  </div>
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

      @endsection
