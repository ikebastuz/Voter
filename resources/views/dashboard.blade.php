@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h1>Dashboard</h1>

            @include('inc.msg')
            @if(isset($votes) && count($votes) > 0)
            	<div class="list-group">
            	@foreach($votes as $vote)
                    <a href="{{ route('viewVote', ['id' => $vote->id]) }}" class="list-group-item list-group-item-action flex-column align-items-start">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">{{$vote->title}}</h5>
                            <small>{{$vote->created_at}}</small>
                        </div>
                        <p class="mb-1">{{$vote->description}}</p>
                    </a>
                    @if(auth()->user()->id == $vote->user_id)
                        <div class="row" style='margin-left:0;'>
                            <a href="{{ route('voteRename', ['id' => $vote->id]) }}" class="btn btn-warning">Edit</a>
                            <a href="#" class="btn btn-danger" onclick="onConfirm({{$vote->id}});">Delete</a>
                        </div>
                        
                    @endif
                    <hr>
            	@endforeach
            	</div>
            @else
            	<p>No votes here yet =(</p>
              <a href="{{ route('createVote')}}" class="btn btn-success">Create First Vote</a>
            @endif
            
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    function onConfirm(id){
        //e.preventDefault();

        swal({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'Yes, delete it!'
        }).then(function () {
          swal(
            'Deleted!',
            'Your vote has been deleted.',
            'success'
          );
          window.location.href = "{{ route('voteDelete') }}/"+id+"/delete";
        })
    }
</script>
@endsection

