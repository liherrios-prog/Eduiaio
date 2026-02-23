<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto - EDUIAIO</title>
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
    <main class="pt-32 pb-20 px-6 max-w-5xl mx-auto">
        <div class="text-center mb-16">
            <h1 class="text-4xl font-bold mb-4 text-gray-900">Estamos aquí para ayudarte</h1>
            <p class="text-xl text-gray-600">¿Tienes alguna duda o necesitas asistencia? Contáctanos.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Contact Info -->
            <div class="space-y-8">
                <div>
                    <h3 class="text-xl font-bold mb-2">Nuestro Compromiso</h3>
                    <p class="text-gray-600">En EDUIAIO nos esforzamos por responder a todas las consultas en menos de 24 horas laborables. Tu aprendizaje es nuestra prioridad.</p>
                </div>
                
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-bold">Correo Electrónico</h4>
                        <p class="text-gray-600">soporte@eduiaio.com</p>
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-bold">Oficina Central</h4>
                        <p class="text-gray-600">Calle Formación 123, CP 28001<br>Madrid, España</p>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                <form action="#" method="POST" class="space-y-6">
                    <div>
                        <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre Completo</label>
                        <input type="text" id="nombre" name="nombre" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Correo Electrónico</label>
                        <input type="email" id="email" name="email" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all">
                    </div>
                    <div>
                        <label for="mensaje" class="block text-sm font-medium text-gray-700 mb-1">Mensaje</label>
                        <textarea id="mensaje" name="mensaje" rows="4" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all"></textarea>
                    </div>
                    <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3 rounded-lg hover:bg-indigo-700 transition-colors">Enviar Mensaje</button>
                    <p class="text-xs text-center text-gray-400 mt-4">Al enviar este formulario, aceptas nuestra Política de Privacidad.</p>
                </form>
            </div>
        </div>
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
