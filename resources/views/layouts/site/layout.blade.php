<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-black-300/80">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Recipe Nest</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="font-sans antialiase h-full">
    <div class="min-h-full">
        <x-site-layout-menu />
        <main class="bg-gray-200">
            <div class="mx-auto h-dvh max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                {{ $slot }}
            </div>
        </main>

        <x-site-layout-footer />
    </div>
</body>

</html>