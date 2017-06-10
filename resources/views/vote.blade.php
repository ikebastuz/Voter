@extends('layouts.app')

@section('content')
<div class="container">
                <div id="test">
                   
                </div>
    <div class="row">
        <div class="col-md-8 offset-md-2">

            <div class="jumbotron">
                <h1 class="display-3">{{$vote->title}}</h1>
                <p class="lead">{{$vote->description}}</p>
            </div>

            @include('inc.msg')

            @if(count($svote) > 0)
                @foreach($svote as $k=>$svotei) <!-- Splitting Main Vote into separate -->
                    
                        @if(!array_key_exists($k, $voted)) <!-- Check if already voted -->
                            <section class="question">
                                <form action="/makechoise" method="POST">
                                    <h3>{{$svotei->title}} <?php echo $svotei->active==0?'(Vote closed)': ''; ?></h3>
                                    <div class="form-group row">
                                        <span type="text" class="col-6 offset-md-3 badge badge-pill badge-default" id="question_help_text" name="question_help_text" placeholder="Description">{{$svotei->description}}</span>
                                    </div>
                                    <h5>Options:</h5>
                                    <!-- Building vote depending on select type -->
                                    @if($svotei->type == 1) <!-- Single choise -->
                                        
                                        @foreach($items[$k] as $i=>$j)
                                            <div class="list-group">
                                            @if($j->s_vote_id == $svotei->id)
                                                <button id="{{$j->id}}" name="option_value" value="{{$j->id}}" class="list-group-item list-group-item-action" type="submit" <?php echo $svotei->active==0?'disabled': ''; ?>>{{$j->title}}</a>
                                            @endif
                                            </div>
                                        @endforeach
                                        
                                        <input type="hidden" name="votetype" value="1">
                                    @elseif($svotei->type == 2) <!-- Multiple choises -->

                                        @foreach($items[$k] as $i=>$j)
                                            @if($j->s_vote_id == $svotei->id)
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="checkbox" class="form-check-input" name="check_option[]" value="{{$j->id}}" <?php echo $svotei->active==0?'disabled': ''; ?>>
                                                        {{$j->title}}
                                                    </label>
                                                </div>
                                            @endif
                                        @endforeach

                                        <button class="btn btn-outline-primary"  type="submit" <?php echo $svotei->active==0?'disabled': ''; ?>>Submit</button>
                                        <input type="hidden" name="votetype" value="2">
                                    @elseif($svotei->type == 3) <!-- Input choise -->
                                        <div class="form-group">
                                            <label for="answer">Answer:</label>
                                            <input type="text" class="form-control" id="answer" aria-describedby="answer" placeholder="Input your answer" name="personal" <?php echo $svotei->active==0?'disabled': ''; ?>>
                                        </div>
                                        <button class="btn btn-outline-primary" type="submit" <?php echo $svotei->active==0?'disabled': ''; ?>>Submit</button>
                                        <input type="hidden" name="votetype" value="3">
                                        <input type="hidden" name="voteid" value="{{$svotei->id}}">
                                    @endif

                                    <hr>
                                {{ csrf_field() }}
                                </form>
                            </section>
                        @else
                            <section class="question">
                                <form action="/revote" method="POST">
                                    <h3>{{$svotei->title}}</h3>
                                    <div class="form-group row">
                                        <span type="text" class="col-6 offset-md-3 badge badge-pill badge-default" id="question_help_text" name="question_help_text" placeholder="Description">{{$svotei->description}}</span>
                                    </div>
                                    @foreach($items[$k] as $i=>$j)
                                        @if($stats[$k] == null or sizeof($items[$k]) == 0)
                                            <p>No one has voted yet</p>
                                            @break
                                        @endif
                                        
                                        {{$j->title}} 
                                        
                                        @if($j->s_vote_id == $svotei->id)
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-striped" role="progressbar" style="width: {{$stats[$k][$i]}}%" aria-valuemin="0" aria-valuemax="100">{{$stats[$k][$i]}}%</div>
                                            </div>
                                        @endif
                                        
                                    @endforeach

                                    <br>
                                    {{ csrf_field() }}
                                    @if($norevote[$k] == false)
                                        <button id="{{$svotei->id}}" name="revote_id" value="{{$svotei->id}}" class="btn btn-outline-primary" type="submit">Re-Vote</button>
                                    @endif
                                </form>
                                    
                            </section>                        
                            <hr>
                        @endif

                        @if(auth()->user()->id == $vote->user_id)
                            <a href="/vote/{{$svotei->id}}/edit" class="btn btn-warning">Edit</a>
                            <a href="/activate/{{$svotei->id}}" class="btn btn-info">
                                @if($svotei->active == 1)
                                    Deactivate
                                @else
                                    Activate
                                @endif
                            </a>
                        @endif

                @endforeach
            @endif
            <hr>
            @if(auth()->user()->id == $vote->user_id)
                <a href="/vote/{{$vote->id}}/stats" class="btn btn-primary">View Stats</a>
            @endif

            
        </div>
    </div>
</div>
@endsection


@section('js')
    <script>
        function makeChoise(id){
            console.log(id);
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                method: "POST",
                url: "/makechoise",
                data: { "id": id}
            }).done(function( msg ) {
                $('#test').text(msg);
            });
        }
    </script>
@endsection

