<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <link rel="icon" type="image/png" href="/favicon.png?v=3">
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico?v=3">
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon.png?v=3">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- ChartJS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles

    <style>
        html, body {
            height: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            overflow-x: hidden !important;
        }
        
        /* Remove the gradient from the main container */
        .min-h-screen.flex.flex-col {
            background: transparent !important;
        }
        
        /* Main content area */
        main {
            background: transparent !important;
            padding: 0 !important;
        }
        
        /* Dashboard specific - no extra rectangle space */
        .dashboard-container {
            padding: 0 !important;
            margin: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
        }
        
        /* Ensure the sidebar background is visible */
        .w-64 {
            background-color: #9fc9ffff !important;
        }
        
        /* Body gradient */
        body {
            background: linear-gradient(135deg, #97aaffff 0%, #764ba2 100%) !important;
            min-height: 100vh !important;
        }
        
        /* Remove any extra spacing from charts/graphs */
        .chart-container, .graph-container {
            margin: 0 !important;
            padding: 0 !important;
        }
    </style>
</head>

<body class="font-sans antialiased">

<div class="min-h-screen flex flex-col">

    <!-- Top Navigation -->
    @include('layouts.navigation')

    <div class="flex flex-1 w-full">

        <!-- Sidebar -->
        @include('layouts.sidebar2')

        <!-- Main Content - No padding -->
        <main class="flex-1 overflow-y-auto dashboard-container">
            <div class="w-full h-full">
                {{ $slot }}
            </div>
        </main>

    </div>
</div>

@livewireScripts
@stack('scripts')

</body>
</html>