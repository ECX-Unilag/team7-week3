@extends('layouts.app')
@section('content')
<div class="container">
    <div class="card card-default">
        <div class="card-header">
        {{isset($posts) ? 'Edit Post' : 'Create Post'}}
        </div>
        <div class="card-body">
            <form action="{{ isset($posts) ? route('post.update', $posts->id) : route('post.store')}} " method="POST" enctype="multipart/form-data">
                @csrf
                @if(isset($posts))
                @method('PUT')
                @endif
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" name="title" id="title" value="{{ isset($posts)? $posts->title: ''}} ">
                </div>
                <div class="form-group">
                    <label for="Description">Description</label>
                    <textarea name="description" class="form-control" id="description" cols="5" rows="5" >{{ isset($posts)? $posts->description : ''}}</textarea>
                </div>
                <div class="form-group">
                    <label for="content">content</label>
                    
                    <input id="content" type="hidden" name="content" id="content" value="{{ isset($posts)? $posts->content: ''}}">
                        <trix-editor input="content"></trix-editor>

                </div>
                <div class="form-group">
                    <label for="category">Category</label>
                    <select name="category" id="category" class="form-control">
                        @foreach ($categories as $category)
                            
                        <option value="{{ $category->id }}"
                            @if (isset($posts))
                                
                            
                            @if($category->id === $posts->category_id)
                                selected

                            @endif
                            @endif> 
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    @if($tags->count() > 0)
                    <label for="tag">Tags</label>
                    <select name="tag[]" id="multiple" class="multiple form-control" multiple="multiple">
                        @foreach ($tags as $tag)
                            
                        <option value="{{ $tag->id }}"
                            @if (isset($posts))

                            @if($posts->hasTag($tag->id))
                                {{-- @foreach($posts->tags as $category) 
                                   selected
                                     @endforeach --}}
                                     selected

                          @endif
                            {{-- {{$posts->tags->name}} --}}
                            @endif>
                            {{ $tag->name }}
                        </option>
                        @endforeach
                    </select>
                    @endif
                </div>
                <div class="form-group">
                    <label for="publish_at">Publish_at</label>
                    <input type="date" class="form-control" name="publish_at" id="publish_at" value="{{ isset($posts)? $posts->publish_at : ''}}">
                </div>
                
                <div class="form-group">
                    @if (isset($posts))
                    <img src="{{asset('/storage/'.$posts->image)}}" alt="image" width="200px" height="200px">
                        
                    @endif
                    <input type="file" class="form-control" name="image" id="image">
                </div>
                <button class="btn btn-primary btn-block" type="submit">{{ isset($posts) ? 'Update post' :'Add Post' }}</button>

            </form>

            
        </div>
    </div>
    
</div>
    
@endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.1/trix.js"> </script>  
<script src="{{ asset('js/app.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"> </script>


<script type="text/javascript">
	$(document).ready(function() 
		{ $("#multiple").select2();
		 });
</script>

  
