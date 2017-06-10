@if(count($errors) > 0)
	<div class="row">
        <div class="col alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

@if (session('alert-message'))
	<div class="row">
        <div class="col alert alert-danger">
            {{ session('alert-message') }}
        </div>
    </div>
@endif

@if (session('success-message'))
	<div class="row">
        <div class="col alert alert-success">
            {{ session('success-message') }}
        </div>
    </div>
@endif