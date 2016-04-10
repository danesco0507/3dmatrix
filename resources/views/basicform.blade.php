@extends('layouts.base')

@section('content')

<div class='formulatio'>

<form action="{{ url('data') }}" method="POST">
	{!! csrf_field() !!}

	<textarea rows="4" cols="70" name="data"></textarea>

        <button type="submit">
                Enciar
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
