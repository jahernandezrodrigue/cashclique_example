<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-gradient-to-tr from-slate-900 via-slate-800 to-slate-900"> <!-- bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900"> -->
        <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center  selection:bg-red-500 selection:text-white">
            @if (Route::has('login'))
                <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="max-w-6xl mx-auto p-6 lg:p-8 flex justify-center items-center">
                <div class="flex flex-col gap-4 justify-between h-1/2 w-full text-white text-center items-center">
                    <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 dark:text-white sm:text-6xl">Cashclique: Control total de tus Finanzas personales en un solo lugar</h1>
                    <p class="mt-6 text-lg leading-8 text-gray-400">¿Cansado de perder de vista el control de tu dinero? Descubre Cashclique, tu asistente personal de finanzas totalmente en línea. Nuestra intuitiva plataforma te permite registrar y monitorear fácilmente tus gastos, rastrear tus ingresos e incluso gestionar tus inversiones, todo en un espacio seguro y conveniente. Con herramientas y gráficos personalizables, Cashclique te otorga la visibilidad que necesitas para tomar decisiones financieras sólidas. ¡Empieza tu viaje hacia la estabilidad y libertad financiera hoy! Regístrate gratis y descubre cómo Cashclique puede transformar tu relación con el dinero.</p>
                </div>
            </div>
        </div>
    </body>
</html>
