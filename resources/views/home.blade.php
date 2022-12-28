<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Laravel</title>

	<!-- Fonts -->
	<link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

	@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased">
	@include('layouts.navbar')
	<main class='max-w-[60rem] mx-auto m-5'>
		@if ($role == 'admin')
		<div class='flex justify-center'>
			<button class='bg-blue-500 text-white px-4 py-2 rounded-md text-lg'>Create Organisation</button>
		</div>
		@endif
	</main>


</body>

</html>