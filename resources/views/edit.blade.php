@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h1>Edit Question:</h1>
            @include('inc.msg')
            <form action="/updatevote/{{$svote->id}}" method="POST">
                <!-- TEST SECTION -->
                @if(count($svote) > 0)
                    <section class="question" id="section">
                        <div class="form-group row">
                            <label class="col-2 col-form-label">Question:</label>
                            <input type="text" class="form-control col-10" id="question_title" name="question_title" placeholder="Question Title" value="{{$svote->title}}">
                        </div>

                        <div class="form-group row">
                            <label class="col-2 col-form-label">Help Text:</label>
                            <input type="text" class="form-control col-10" id="question_help_text" name="question_help_text" placeholder="Description" value="{{$svote->description}}">
                        </div>

                        <div class="form-group row">
                            <label class="col-2 col-form-label">Question type:</label>
                            <select id='opType' class="form-control col-10 question_type" name="question_type" onChange="opChange(this);">
                                <option value="1" {{$svote->type==1?'selected':''}}>One answer</option>
                                <option value="2" {{$svote->type==2?'selected':''}}>Multiple answers</option>
                                <option value="3" {{$svote->type==3?'selected':''}}>Short answer</option>
                            </select>
                        </div>
                        
                        <section id='options'>
                            <h5>Options:</h5>
                            @if($svote->type == 1 || $svote->type == 2)
                                @foreach($items as $i=>$j)
                                    <div class="form-group row opt">
                                    @if($j->s_vote_id == $svote->id)
                                        <input type="text" class="form-control col-10" id="option[]" name="option[]" placeholder="Option" value="{{$j->title}}">
                                        <button class='btn btn-outline-danger removeOption col-2' onClick="return false;">Remove</button>
                                    @endif
                                    </div>
                                @endforeach
                                
                            @elseif($svote->type == 3)
                                
                            @endif
                        </section>
                        <button id="addOption" class="btn btn-outline-primary col-2 addOption" onClick='return false'>Add Option</button>
                    </section>
                    
                    <hr>    
                @endif
                <!-- END TEST SECTION -->
                <a href="/vote/{{$voteid}}" class='btn btn-outline-primary'>Back</a>
                <button type="submit" class="btn btn-outline-primary">Update</button>
                <a href="#" class='btn btn-danger' onclick="onConfirm({{$svote->id}});">Delete</a>
				{{ csrf_field() }}
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script>
        var curOpt = $('#opType').val();
        console.log(curOpt);

        $(document).on("click",".removeOption", function (e) {
            e.preventdefault;
            $(this).parent().remove();
        });

        $(document).on("click",".addOption", function (e) {
            console.log($(this).parent());
            e.preventDefault();
            $('#options').append("<div class='form-group row opt'><input type='text' class='form-control col-10' id='option[]' name='option[]' placeholder='Option'><button class='btn btn-outline-danger col-2 removeOption' onClick='return false'>Remove</button></div>");
        });


        function opChange(e){
            var option = e.value;
            console.log(curOpt);
            //console.log($(e).parent().parent().children('.options').children());

            
            
            
            if(option == 3){
                $("#options").remove();
                $("#addOption").remove();
            }else if(curOpt == 1 || curOpt == 2){

            }else{
                console.log($(e).parent().parent());
                $("#options").remove();
                $("#addOption").remove();
                $(e).parent().parent().append("<section id='options'><div class='form-group row opt'><input type='text' class='form-control col-10' id='option[]' name='option[]' placeholder='Option'><button class='btn btn-outline-default col-2' onClick='return false'>Default</button></section>");
                $(e).parent().parent().after("<button id='addOption' class='btn btn-outline-primary col-2 addOption' onClick='return false'>Add Option</button>");
                
            }

            curOpt = option;

        }
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
                window.location.href = "/deletesvote/"+id;
            })
        }
    </script>
@endsection
