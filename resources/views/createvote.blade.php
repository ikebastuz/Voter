@extends('layouts.app')

@section('content')
<div class="container">
@if(isset($data))
    {{dd($data)}}
@endif
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h1>Create Vote:</h1>
            @include('inc.msg')
            <form action="{{route('postCreatePost')}}" method="POST">
                <div class="vote_header">
                    <div class="form-group">
                        <label>Title:</label>
                        <input type="text" class="form-control" id="vote_title" name="vote_title" placeholder="Vote Title" value="{{ old('vote_title') }}">
                    </div>

                    <div class="form-group">
                        <label>Description:</label>
                        <textarea type="text" class="form-control" id="vote_desc" name="vote_desc" placeholder="Description">{{ old('vote_desc') }}</textarea>
                    </div>
                </div>
				
                <hr>
                
                <section class="question">
                    <h3>Question:</h3>
                    <div class="form-group">
                        <label>Question:</label>
                        <input type="text" class="form-control" id="question_title" name="question_title1" placeholder="Question Title" value="{{ old('question_title1') }}">
                    </div>
                    <div class="form-group">
                        <label>Help Text:</label>
                        <input type="text" class="form-control" id="question_help_text" name="question_help_text1" placeholder="Description" value="{{ old('question_help_text1') }}">
                    </div>
                    <div class="form-group">
                        <label>Question type:</label>
                        <select class="form-control question_type" name="question_type1" onChange="opChange(this);">
                            <option value="1">One answer</option>
                            <option value="2">Multiple answers</option>
                            <option value="3">Short answer</option>
                        </select>
                    </div>
                    <h5>Options:</h5>
                    <section class='options'>
                        <div class="form-group row" style="margin-left:0;margin-right:0;">
                            <input type="text" class="form-control col-9 opt" id="option1[]" name="option1[]" placeholder="Option">
                            <button class='btn btn-outline-default col-3' onClick='return false'>Default</button>
                        </div>
                    </section>
                    <button class="btn btn-outline-primary addOption" onClick='return false'>Add Option</button>
                    <br><br>
                    <button class="btn btn-outline-warning cloneQuestion" onClick='return false'>Clone</button>
                </section>
                <hr>
                
                {{ csrf_field() }}
                <input type="hidden" id="qcount" name="qcount" value="1">

                <div class="form-check">
                    <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" name="jump" value="1">
                        Jump to created vote page!
                    </label>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script>
    var sections = 1;

        $(document).on("click",".removeOption", function (e) {
            e.preventdefault;
            $(this).parent().remove();
        });

        $(document).on("click",".removeQuestion", function (e) {
            e.preventdefault;
            $(this).parent().remove();
        });

        $(document).on("click",".cloneQuestion", function (e) {
            sections++;
            console.log(sections);
            e.preventdefault;

            var item = $(this).parent().clone();
            item.find('[name^=question_title]').attr('name', 'question_title'+sections);
            item.find('[name^=question_help_text]').attr('name', 'question_help_text'+sections);
            item.find('[name^=question_type]').attr('name', 'question_type'+sections);
            item.find('[name^=option]').attr('name', 'option'+sections+'[]');            
            $(this).parent().after(item);
            var delButtons = item.find('.removeQuestion');
            //console.log(delButtons[0]);
            if(delButtons[0] == undefined){
                $(item).append("<button class='btn btn-outline-danger removeQuestion'>Delete</button>");
            }
            $('#qcount').val(sections);
        });


        $(document).on("click",".addOption", function (e) {
            //console.log(e);
            e.preventDefault();
            var id = $(this).parent().children('.options').children('.row').children('input').attr('name').substring(6,7);
            console.log(id);
            $(this).parent().children('.options').append("<div class='form-group row' style='margin-left:0;margin-right:0;'><input type='text' class='form-control col-9 opt' id='option"+id+"[]' name='option"+id+"[]' placeholder='Option'><button class='btn btn-outline-danger col-3 removeOption' onClick='return false'>Remove</button></div>");
        });


        function opChange(e){
            var option = e.value;
            //console.log($(e).parent().parent().children('.options').children());

            $(e).parent().parent().children('.options').children().remove();
            $(e).parent().parent().children('.addOption').remove();


            if(option == 3){
                
            }else{
                $(e).parent().parent().children('.options').append("<div class='form-group row' style='margin-left:0;margin-right:0;'><input type='text' class='form-control col-9 opt' id='option"+sections+"[]' name='option"+sections+"[]' placeholder='Option'><button class='btn btn-outline-default col-3' onClick='return false'>Default</button>");
                $(e).parent().parent().children('.options').after("<button class='btn btn-outline-primary addOption' onClick='return false'>Add Option</button>");
            }
        }
       
    </script>
@endsection

