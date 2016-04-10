@extends('layouts.base')

@section('content')

<div class='formulatio'>

@if (count($errors))
    <ul>
        @foreach($errors->all() as $error)
            // Remove the spaces between the brackets
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form action="{{ url('data') }}" method="POST">
	{!! csrf_field() !!}

	<textarea rows="4" cols="70" name="data"></textarea>

        <button type="submit">
                Enviar
        </button>
</form>

</div>

<div>

@if (count($results) > 0)

@foreach ($results as $result)
{{ $result }}<br>
@endforeach
@endif
</div>
	
@endsection
