@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
              <div class="card">
                  <div class="card-header">
                      <div class="d-flex align-items-center">
                            <h3>All Question</h3>
                            <div class="ml-auto">
                            <a class="btn btn-outline-secondary" href="{{route('questions.create')}}">
                            Ask This Question</a>
                            </div>
                      </div>
                    </div>
                    <div class="card-body">
                      @include('layouts._message')
                      @foreach($questions as $question)
                            <div class="media">
                        	       <div class="d-flex flex-column counters">
                            		  <div class="vote">
                                			<strong>{{$question->votes_count}}</strong>
                                			{{str_plural('vote',$question->count)}}
                            		  </div>
                              		<div class="status {{$question->status}}">
                                			<strong>{{$question->answers_count}}</strong>
                                			{{str_plural('answer',$question->answers_count)}}
                              		</div>
                              		<div class="views">
                              			{{$question->views}}
                              			{{str_plural('view',$question->views)}}
                              		</div>
                        	         </div>
                              <div class="media-body">
                            <div class="d-flex align-items-center">
                                        <h3 class="mt-0"><a href="{{$question->url}}">
                                          {{$question->title}} </a>
                                        </h3>
                                  <div class="ml-auto">
                                    @can('update',$question)
                                      <a class="btn btn-sm btn-outline-primary "href="{{route('questions.edit',$question->id)}}">
                                        Edit</a>
                                        @endcan()
                                         @can('delete',$question)
                                        <form class="form-delete"action="{{route('questions.destroy',$question->id)}}" method="post">
                                                @method('Delete') @csrf
                                          <button onclick="return confirm('Are You Sure')" class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                                        </form>
                                        @endcan('update',$question)
                                  </div>
                              </div>
                            	<p class="lead">
                            		    Asked By <a href="{{$question->user->url}}">{{$question->user->name}}</a>
                            		    <small class="text-muted">{{$question->create_date}}</small>
                            	</p>{{str_limit(strip_tags($question->body,250))}}
                      </div>
                  </div><hr>
                    @endforeach
                   <!-- <div class="pagination justify-content-center">
                    	 {{$questions->links()}}
                    					//php artisan vendor:publish tag=laravel-pagination
                    </div>-->
                    {{$questions->links()}}
                  </div>
            </div>
        </div>
    </div>
</div>

@endsection
