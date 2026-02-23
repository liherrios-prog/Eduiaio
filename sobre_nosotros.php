<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre Nosotros - EDUIAIO</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-900">

    <!-- Header -->
    <header class="py-4 px-10 flex items-center fixed top-0 w-full justify-between z-40 bg-white shadow-sm">
        <div class="flex flex-grow basis-0">
            <a href="./" class="text-indigo-600 font-bold text-xl tracking-tighter">EDUIAIO</a>
        </div>
        <nav class="hidden xl:block">
            <ul class="flex text-sm font-medium text-gray-700 [&>li>a]:inline-block [&>li>a]:px-4 [&>li>a]:py-2 hover:[&>li>a]:text-indigo-600">
                <li><a href="./">Inicio</a></li>
                <li><a href="ver_cursos.php">Cursos</a></li>
                <li><a href="descubrir.php">Descubrir</a></li>
                <li><a href="ocio.php">Ocio</a></li>
            </ul>
        </nav>
        <div class="flex flex-grow justify-end basis-0">
            <a href="iniciar_sesion.php" class="text-sm font-medium text-gray-700 px-4 py-2 hover:text-indigo-600">Cuenta</a>
        </div>
    </header>

    <!-- Main Content -->
    <main class="pt-32 pb-20">
        <!-- Hero Section -->
        <section class="max-w-4xl mx-auto px-6 text-center mb-20">
            <h1 class="text-5xl font-bold mb-6 text-gray-900 leading-tight">Reduciendo la brecha digital con empatía y tecnología</h1>
            <p class="text-xl text-gray-600 italic">"Nunca es tarde para aprender algo nuevo, y menos si es para estar más cerca de los tuyos."</p>
        </section>

        <!-- Mission/Vision -->
        <section class="bg-white py-20 px-6 border-y border-gray-100">
            <div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-16">
                <div>
                    <h2 class="text-3xl font-bold mb-6 text-indigo-600 underline decoration-indigo-200 underline-offset-8">Nuestra Misión</h2>
                    <p class="text-lg text-gray-600 leading-relaxed">En EDUIAIO, nos dedicamos a empoderar a las personas mayores a través de la formación digital. Creemos que la tecnología no debería ser una barrera, sino una herramienta para la autonomía y la conexión emocional.</p>
                </div>
                <div>
                    <h2 class="text-3xl font-bold mb-6 text-indigo-600 underline decoration-indigo-200 underline-offset-8">Nuestra Visión</h2>
                    <p class="text-lg text-gray-600 leading-relaxed">Queremos ser el referente en educación digital para la tercera edad en el mundo hispanohablante, creando una comunidad donde el aprendizaje sea accesible, divertido y humano.</p>
                </div>
            </div>
        </section>

        <!-- Team/Values -->
        <section class="max-w-5xl mx-auto px-6 py-20">
            <h2 class="text-3xl font-bold text-center mb-16">Nuestros Valores</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div class="p-8 bg-gray-50 rounded-2xl">
                    <div class="w-16 h-16 bg-white shadow-sm rounded-full flex items-center justify-center mx-auto mb-6 text-2xl">🤝</div>
                    <h3 class="font-bold text-xl mb-4">Paciencia y Empatía</h3>
                    <p class="text-gray-600 text-sm">Entendemos los tiempos de cada persona y adaptamos nuestro contenido para que nadie se quede atrás.</p>
                </div>
                <div class="p-8 bg-gray-50 rounded-2xl">
                    <div class="w-16 h-16 bg-white shadow-sm rounded-full flex items-center justify-center mx-auto mb-6 text-2xl">💡</div>
                    <h3 class="font-bold text-xl mb-4">Simplicidad</h3>
                    <p class="text-gray-600 text-sm">Convertimos lo complejo en sencillo. Sin tecnicismos innecesarios, solo lo que realmente necesitas.</p>
                </div>
                <div class="p-8 bg-gray-50 rounded-2xl">
                    <div class="w-16 h-16 bg-white shadow-sm rounded-full flex items-center justify-center mx-auto mb-6 text-2xl">❤️</div>
                    <h3 class="font-bold text-xl mb-4">Pasión por Ayudar</h3>
                    <p class="text-gray-600 text-sm">Ver a un abuelo hacer su primera videollamada es lo que nos motiva a seguir trabajando cada día.</p>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
                <h3 class="text-xl font-bold mb-4">EDUIAIO</h3>
                <p class="text-gray-400 text-sm">Tecnología accesible para todos, sin importar la edad.</p>
            </div>
            <div>
                <h4 class="font-bold mb-4">Secciones</h4>
                <ul class="text-sm text-gray-400 space-y-2">
                    <li><a href="./" class="hover:text-white">Inicio</a></li>
                    <li><a href="ver_cursos.php" class="hover:text-white">Cursos</a></li>
                    <li><a href="descubrir.php" class="hover:text-white">Descubrir</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold mb-4">Legal</h4>
                <ul class="text-sm text-gray-400 space-y-2">
                    <li><a href="privacidad.php" class="hover:text-white">Privacidad</a></li>
                    <li><a href="terminos.php" class="hover:text-white">Términos</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold mb-4">Contacto</h4>
                <p class="text-sm text-gray-400">soporte@eduiaio.com</p>
            </div>
        </div>
        <div class="text-center text-gray-500 text-xs mt-12 pt-8 border-t border-gray-800">
            &copy; 2026 EDUIAIO. Todos los derechos reservados.
        </div>
    </footer>

</body>

</html>
