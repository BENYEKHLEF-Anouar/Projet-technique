<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Tablau de bord</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>


<body>

    


    <main class="w-full pt-10 px-4 sm:px-6 md:px-8 lg:ps-64">
        <div class="max-w-5xl mx-auto">
            @yield('content')
        </div>
    </main>

</body>

</html>