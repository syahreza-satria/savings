<!DOCTYPE html>
<html lang="en" x-data="{ open: false, darkMode: {{ session('dark_mode', 'false') }} }" :class="{ 'dark': darkMode }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }}</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,100..700;1,100..700&display=swap"
        rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('darkMode', {
                on: window.matchMedia('(prefers-color-scheme: dark)').matches,

                init() {
                    // Cek localStorage untuk preferensi pengguna
                    if (localStorage.getItem('darkMode') !== null) {
                        this.on = localStorage.getItem('darkMode') === 'true';
                    }

                    // Update state Alpine dan HTML class
                    this.toggle(this.on);

                    // Listen untuk perubahan preferensi sistem
                    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
                        if (localStorage.getItem('darkMode') === null) {
                            this.toggle(e.matches);
                        }
                    });
                },

                toggle(value = !this.on) {
                    this.on = value;
                    document.documentElement.classList.toggle('dark', this.on);
                    localStorage.setItem('darkMode', this.on);

                    // Kirim preferensi ke server (opsional)
                    fetch('/toggle-dark-mode', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            dark_mode: this.on
                        })
                    });
                }
            });
        });
    </script>
</head>

<body
    class="min-h-screen text-gray-900 transition-colors duration-200 bg-gray-100 font-primary dark:text-gray-100 dark:bg-gray-800">
    @include('includes.navbar')

    <main class="flex flex-col max-w-4xl gap-4 pb-8 mx-4 lg:mx-auto">
        @yield('content')
    </main>
</body>

</html>
