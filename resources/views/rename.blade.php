@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h1>Edit Question:</h1>
            @include('inc.msg')
            <form action="{{route('updateRename', ['id' => $vote->id])}}" method="POST">
                <!-- TEST SECTION -->
                @if(count($vote) > 0)
                    <section class="question" id="section">
                        <div class="form-group row">
                            <label class="col-2 col-form-label">Title:</label>
                            <input type="text" class="form-control col-10" id="vote_title" name="vote_title" placeholder="Vote Title" value="{{$vote->title}}">
                        </div>

                        <div class="form-group row">
                            <label class="col-2 col-form-label">Description:</label>
                            <textarea type="text" class="form-control col-10" id="vote_desc" name="vote_desc" placeholder="Description">{{$vote->description}}</textarea>
                        </div>
                    </section>
                    <hr>    
                @endif
                <!-- END TEST SECTION -->
                <button type="submit" class="btn btn-primary">Update</button>
				{{ csrf_field() }}
            </form>
        </div>
    </div>
</div>
@endsection
