<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Curso - EDUIAIO</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>

<body class="bg-gray-50 text-gray-900">

    <header class="py-4 px-10 flex items-center fixed top-0 w-full justify-between z-40 bg-white shadow-sm">
        <div class="flex flex-grow basis-0"><a href="./" class="text-indigo-600 font-bold text-xl tracking-tighter">EDUIAIO</a></div>
        <nav class="flex flex-grow justify-end basis-0">
            <a href="registro.php" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-bold">Empezar Ahora</a>
        </nav>
    </header>

    <main class="pt-32 pb-20 px-6 max-w-5xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            
            <div class="lg:col-span-2">
                <h1 class="text-4xl font-bold mb-6">Detalles del Curso Seleccionado</h1>
                <p class="text-xl text-gray-600 mb-8">Nuestros cursos están pensados para personas que quieren aprender sin agobios, con explicaciones paso a paso y lenguaje sencillo.</p>
                
                <h3 class="text-2xl font-bold mb-4">¿Qué aprenderás?</h3>
                <ul class="space-y-4 mb-8">
                    <li class="flex gap-3">✅ <span>Conceptos básicos explicados desde cero.</span></li>
                    <li class="flex gap-3">✅ <span>Ejercicios prácticos para perder el miedo.</span></li>
                    <li class="flex gap-3">✅ <span>Consejos de seguridad en cada paso.</span></li>
                    <li class="flex gap-3">✅ <span>Acceso ilimitado para repetir las lecciones.</span></li>
                </ul>

                <h3 class="text-2xl font-bold mb-4">Requisitos</h3>
                <p class="text-gray-600">Solo necesitas conexión a internet y muchas ganas de aprender. No hace falta saber nada previamente.</p>
            </div>

            <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 flex flex-col justify-between h-fit lg:sticky lg:top-32">
                <div>
                    <h4 class="text-indigo-600 font-bold uppercase text-xs mb-2">Información</h4>
                    <ul class="space-y-3 text-sm mb-6">
                        <li class="flex justify-between"><span>Duración:</span> <strong>A tu ritmo</strong></li>
                        <li class="flex justify-between"><span>Nivel:</span> <strong>Iniciación</strong></li>
                        <li class="flex justify-between"><span>Certificado:</span> <strong>Sí, al finalizar</strong></li>
                    </ul>
                </div>
                <a href="registro.php" class="block w-full bg-indigo-600 text-white text-center py-3 rounded-lg font-bold hover:bg-indigo-700 transition-colors">Inscribirme ahora</a>
            </div>

        </div>

        <div class="mt-16 text-center">
            <a href="ver_cursos.php" class="text-gray-500 hover:text-indigo-600 transition-colors underline">Ver otros cursos</a>
        </div>
    </main>

</body>
</html>
