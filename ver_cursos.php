<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cursos - EDUIAIO</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-900">

    <!-- Header (Consistent with Landing, but static color) -->
    <header
        class="py-4 px-10 flex items-center fixed top-0 w-full justify-between z-40 bg-white shadow-sm transition-colors duration-300">
        <div class="flex flex-grow basis-0">
            <a href="./" class="text-indigo-600 font-bold text-xl tracking-tighter">EDUIAIO</a>
        </div>

        <nav class="hidden xl:block sm:hidden">
            <ul
                class="flex text-sm font-medium text-gray-700 [&>li>a]:transition-colors [&>li>a]:duration-300 [&>li>a]:inline-block [&>li>a]:px-4 [&>li>a]:py-2 hover:[&>li>a]:text-indigo-600">
                <li><a href="./#inicio">Inicio</a></li>
                <li><a href="./#iniciacion">Iniciación</a></li>
                <li><a href="./#comunicacion">Comunicación</a></li>
                <li><a href="./#tramites">Trámites</a></li>
                <li><a href="./#ocio">Ocio</a></li>
            </ul>
        </nav>

        <nav class="flex flex-grow justify-end basis-0">
            <ul
                class="flex text-sm font-medium text-gray-700 [&>li>a]:transition-colors [&>li>a]:duration-300 [&>li>a]:inline-block [&>li>a]:px-4 [&>li>a]:py-2 hover:[&>li>a]:text-indigo-600">
                <li class="hidden xl:block sm:hidden"><a href="iniciar_sesion.php">Cuenta</a></li>
                <li><a id="menu-btn" href="#" class="xl:hidden">Menú</a></li>
            </ul>
        </nav>

        <!-- Mobile Menu Overlay -->
        <div id="mobile-menu" class="fixed inset-0 bg-white z-50 hidden flex-col p-8">
            <div class="flex justify-end mb-8">
                <button id="close-menu" class="text-black text-2xl">&times;</button>
            </div>
            <ul class="flex flex-col gap-4 text-black font-medium text-lg">
                <li><a href="./#inicio">Inicio</a></li>
                <li><a href="./#iniciacion">Iniciación Digital</a></li>
                <li><a href="./#comunicacion">Comunicación</a></li>
                <li><a href="./#tramites">Trámites Online</a></li>
                <li><a href="./#ocio">Ocio y Bienestar</a></li>
                <li><a href="iniciar_sesion.php" class="bg-gray-100 p-2 rounded text-center mt-4">Iniciar Sesión</a>
                </li>
            </ul>
        </div>
    </header>

    <!-- Main Content -->
    <main class="pt-24 pb-12 px-6 lg:px-12 max-w-7xl mx-auto">

        <div class="text-center mb-16">
            <span class="text-indigo-600 font-semibold tracking-wider uppercase text-sm">Formación Digital</span>
            <h1 class="text-4xl md:text-5xl font-bold mt-2 mb-4 text-gray-900">Nuestros Cursos</h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">Empieza desde cero y avanza a tu propio ritmo. Cursos
                diseñados especialmente para ti.</p>
        </div>

        <!-- Search Bar -->
        <div class="mb-12 max-w-md mx-auto">
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </span>
                <input type="text" id="course-search" placeholder="Buscar cursos..." 
                    class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm shadow-sm transition-all">
            </div>
            <p id="no-results" class="hidden text-center text-gray-500 mt-8">No se encontraron cursos que coincidan con tu búsqueda.</p>
        </div>

        <!-- Course Grid -->
        <div id="course-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

            <!-- Course Card 1 -->
            <article
                class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow group">
                <div class="h-48 bg-zinc-100 relative overflow-hidden">
                    <img src="recursos/imagenes/academia_portatil_abuelos.png" alt="Uso básico del PC"
                        class="h-full w-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                    <div
                        class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-semibold text-indigo-700">
                        Nivel Básico</div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-2 text-gray-900">Primeros pasos con el Ordenador</h3>
                    <p class="text-gray-600 mb-4 text-sm line-clamp-3">Aprende a encender, apagar, usar el ratón y el
                        teclado, y manejar las ventanas básicas sin miedo.</p>
                    <a href="ver_detalle_estatico.php"
                        class="inline-flex items-center text-indigo-600 font-semibold text-sm hover:text-indigo-800 transition-colors">
                        Ver Detalles <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </a>
                </div>
            </article>

            <!-- Course Card 2 -->
            <article
                class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow group">
                <div class="h-48 bg-emerald-50 relative overflow-hidden">
                    <img src="recursos/imagenes/senior-woman-using-laptop-sitting-desk-living-room.jpg"
                        alt="Correo Electrónico"
                        class="h-full w-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                    <div
                        class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-semibold text-emerald-700">
                        Nivel Básico</div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-2 text-gray-900">Correo Electrónico (Email)</h3>
                    <p class="text-gray-600 mb-4 text-sm line-clamp-3">Crea tu cuenta, envía correos a tus familiares y
                        aprende a adjuntar fotos y documentos.</p>
                    <a href="ver_detalle_estatico.php"
                        class="inline-flex items-center text-indigo-600 font-semibold text-sm hover:text-indigo-800 transition-colors">
                        Ver Detalles <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </a>
                </div>
            </article>

            <!-- Course Card 3 -->
            <article
                class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow group">
                <div class="h-48 bg-blue-50 relative overflow-hidden">
                    <img src="recursos/imagenes/grandparent-learning-use-technology.jpg" alt="Navegar por Internet"
                        class="h-full w-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                    <div
                        class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-semibold text-blue-700">
                        Nivel Medio</div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-2 text-gray-900">Navegar por Internet</h3>
                    <p class="text-gray-600 mb-4 text-sm line-clamp-3">Busca información, lee noticias, usa Google Maps
                        y descubre todo lo que la red ofrece.</p>
                    <a href="ver_detalle_estatico.php"
                        class="inline-flex items-center text-indigo-600 font-semibold text-sm hover:text-indigo-800 transition-colors">
                        Ver Detalles <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </a>
                </div>
            </article>

        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-6 lg:px-12 grid grid-cols-1 md:grid-cols-4 gap-8">
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
                    <li><a href="contacto.php" class="hover:text-white">Contacto</a></li>
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

    <script>
        // Mobile Menu Logic
        const menuBtn = document.getElementById('menu-btn');
        const closeMenuBtn = document.getElementById('close-menu');
        const mobileMenu = document.getElementById('mobile-menu');

        function toggleMenu() {
            mobileMenu.classList.toggle('hidden');
            mobileMenu.classList.toggle('flex');
        }

        menuBtn.addEventListener('click', (e) => {
            e.preventDefault();
            toggleMenu();
        });

        closeMenuBtn.addEventListener('click', toggleMenu);

        // Course Search Logic
        const searchInput = document.getElementById('course-search');
        const courseCards = document.querySelectorAll('#course-grid article');
        const noResultsMsg = document.getElementById('no-results');

        searchInput.addEventListener('input', (e) => {
            const term = e.target.value.toLowerCase().trim();
            let count = 0;

            courseCards.forEach(card => {
                const title = card.querySelector('h3').textContent.toLowerCase();
                const description = card.querySelector('p').textContent.toLowerCase();

                if (title.includes(term) || description.includes(term)) {
                    card.classList.remove('hidden');
                    count++;
                } else {
                    card.classList.add('hidden');
                }
            });

            if (count === 0) {
                noResultsMsg.classList.remove('hidden');
            } else {
                noResultsMsg.classList.add('hidden');
            }
        });
    </script>
</body>

</html>