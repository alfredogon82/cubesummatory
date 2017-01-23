@extends('layouts.app')
@section('content')
	<div class="col-md-4 col-md-offset-4">
	@foreach ($rslt as $rsl)
    	<p>{{ $rsl }}</p>
	@endforeach
	</div>
@endsection