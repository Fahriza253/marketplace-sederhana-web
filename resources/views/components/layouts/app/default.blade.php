<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')
    @livewireStyles
</head>

<body class="min-h-screen flex flex-col bg-gray-50">
    <livewire:navigation.top/>

    <main class="flex-1 pt-[128px]">
        {{ $slot }}
    </main>

    <x-navigation.bottom/>
    <script src="https://kit.fontawesome.com/7085b83bdc.js" crossorigin="anonymous"></script>
@livewireScripts
</body>
</html>
