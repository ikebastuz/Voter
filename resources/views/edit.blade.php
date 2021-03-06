@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h1>Edit Question:</h1>
            @include('inc.msg')
            <form action="{{route('updateVote', ['id' => $svote->id])}}" method="POST">
                <!-- TEST SECTION -->
                @if(count($svote) > 0)
                    <section class="question" id="section">
                        <div class="form-group">
                            <label>Question:</label>
                            <input type="text" class="form-control" id="question_title" name="question_title" placeholder="Question Title" value="{{$svote->title}}" maxlength="70">
                        </div>

                        <div class="form-group">
                            <label>Help Text:</label>
                            <input type="text" class="form-control" id="question_help_text" name="question_help_text" placeholder="Description" value="{{$svote->description}}" maxlength="70">
                        </div>

                        <div class="form-group">
                            <label>Question type:</label>
                            <select id='opType' class="form-control question_type" name="question_type" onChange="opChange(this);">
                                <option value="1" {{$svote->type==1?'selected':''}}>One answer</option>
                                <option value="2" {{$svote->type==2?'selected':''}}>Multiple answers</option>
                                <option value="3" {{$svote->type==3?'selected':''}}>Short answer</option>
                            </select>
                        </div>
                        
                        <section id='options'>
                            <h5>Options:</h5>
                            @if($svote->type == 1 || $svote->type == 2)
                                @foreach($items as $i=>$j)
                                    <div class="form-group row opt" style="margin-left:0;margin-right:0;">
                                    @if($j->s_vote_id == $svote->id)
                                        <input type="text" class="form-control col-9" id="option[]" name="option[]" placeholder="Option" value="{{$j->title}}" maxlength="70">
                                        <button class='btn btn-outline-danger removeOption col-3' onClick="return false;">Remove</button>
                                    @endif
                                    </div>
                                @endforeach
                                
                            @elseif($svote->type == 3)
                                
                            @endif
                        </section>
                        <button id="addOption" class="btn btn-outline-primary addOption" onClick='return false'>Add Option</button>
                    </section>
                    
                    <hr>    
                @endif
                <!-- END TEST SECTION -->
                <a href="{{ route('viewVote', ['id' => $voteid]) }}" class='btn btn-outline-primary'>Back</a>
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
            var cnt = $(this).parent().parent().children('.opt').length;
            console.log(cnt);
            if(cnt > 1){
                $(this).parent().remove();    
            }            
        });

        $(document).on("click",".addOption", function (e) {
            console.log($(this).parent());
            e.preventDefault();
            $('#options').append("<div class='form-group row opt' style='margin-left:0;margin-right:0;'><input type='text' class='form-control col-9' id='option[]' name='option[]' placeholder='Option' maxlength='70'><button class='btn btn-outline-danger col-3 removeOption' onClick='return false'>Remove</button></div>");
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
                $(e).parent().parent().append("<section id='options'><div class='form-group row opt' style='margin-left:0;margin-right:0;'><input type='text' class='form-control col-9' id='option[]' name='option[]' placeholder='Option' maxlength='70'><button class='btn btn-outline-default col-3' onClick='return false'>Default</button></section>");
                $(e).parent().parent().after("<button id='addOption' class='btn btn-outline-primary addOption' onClick='return false'>Add Option</button>");
                
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
                window.location.href = "{{ route('voteSDelete') }}/"+id;
            })
        }
    </script>
@endsection
