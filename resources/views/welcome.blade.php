<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APRECIA - Centro para Personas no Videntes</title>

    <!-- TailwindCSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="antialiased bg-gray-100 dark:bg-gray-900 selection:bg-red-500 selection:text-white">

    <!-- HEADER -->
    <header class="flex justify-between items-center p-6 bg-white shadow-md dark:bg-gray-800">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">APRECIA</h1>
        @if (Route::has('login'))
            <div>
                @auth
                    <a href="{{ url('/dashboard') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Login</a>
                @endauth
            </div>
        @endif
    </header>

    <!-- MAIN -->
    <main class="flex flex-col items-center justify-center min-h-screen px-6 text-center">

        <h2 class="text-5xl font-extrabold text-gray-900 dark:text-white mb-6">Bienvenido a APRECIA</h2>
        <p class="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mb-8 leading-relaxed">
            APRECIA es un centro líder dedicado a transformar vidas de personas con discapacidad visual,
            ofreciendo educación inclusiva, rehabilitación, y oportunidades para su independencia y bienestar.
        </p>

        <div class="flex flex-wrap justify-center gap-8 mt-8">
            <!-- Card Misión -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 max-w-sm transition hover:scale-105">
                <h3 class="text-xl font-bold mb-4 text-blue-600 dark:text-blue-400">Nuestra Misión</h3>
                <p class="text-gray-600 dark:text-gray-300">
                    Promover el desarrollo integral de las personas no videntes, empoderándolas a través de la educación, la cultura y la tecnología.
                </p>
            </div>

            <!-- Card Servicios -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 max-w-sm transition hover:scale-105">
                <h3 class="text-xl font-bold mb-4 text-green-600 dark:text-green-400">Nuestros Servicios</h3>
                <p class="text-gray-600 dark:text-gray-300">
                    Ofrecemos talleres de Braille, uso de tecnologías accesibles, rehabilitación visual, formación académica y acompañamiento psicológico.
                </p>
            </div>

            <!-- Card Comunidad -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 max-w-sm transition hover:scale-105">
                <h3 class="text-xl font-bold mb-4 text-purple-600 dark:text-purple-400">Nuestra Comunidad</h3>
                <p class="text-gray-600 dark:text-gray-300">
                    Formamos una comunidad solidaria y diversa que cree en un mundo accesible, con actividades culturales, recreativas y de sensibilización.
                </p>
            </div>
        </div>

     

    </main>

    <!-- FOOTER -->
    <footer class="mt-16 text-center text-sm text-gray-500 dark:text-gray-400 p-4">
        © {{ date('Y') }} APRECIA - Todos los derechos reservados.
    </footer>

</body>
</html>
