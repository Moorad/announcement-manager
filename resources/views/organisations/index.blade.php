@extends('layouts.main')

@section('content')

<div>
	<ul>
		@foreach ($organisations as $organisation)
		<li>$organisation</li>
		@endforeach
	</ul>

@endsection