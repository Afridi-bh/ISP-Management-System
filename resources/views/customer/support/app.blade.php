<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Customer Panel</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

    <header class="bg-white shadow p-4">
        <h1 class="font-bold text-xl">Customer Panel</h1>
    </header>

    <main class="container mx-auto mt-6">
        @yield('content')
    </main>

</body>
</html>
