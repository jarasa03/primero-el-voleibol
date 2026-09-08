@extends('layouts.public')

@section('title', 'Politica de cookies')
@section('meta_description', 'Politica de cookies de Primero el Voleibol.')
@section('body_class', 'page-legal')

@section('content')
    <section class="pb-12 pt-20 lg:pb-16 lg:pt-24">
        <div class="site-container">
            <p class="text-sm font-semibold uppercase tracking-[0.25em] text-accent-700">Politica de cookies</p>
            <h1 class="mt-4 text-4xl font-semibold tracking-tight text-slate-950 sm:text-5xl">Politica de cookies</h1>
            <p class="mt-5 text-lg leading-8 text-slate-700">
                Esta política explica qué cookies y tecnologías similares utiliza actualmente Primero el Voleibol.
            </p>

            <div class="mt-10 space-y-8 text-base leading-7 text-slate-700">
                <section>
                    <h2 class="text-2xl font-semibold tracking-tight text-slate-950">1. Qué son las cookies</h2>
                    <p class="mt-3">Las cookies son pequeños archivos o identificadores que un sitio web puede guardar en el navegador para recordar información, mantener una sesión o permitir determinadas funciones. También pueden existir tecnologías similares de almacenamiento o lectura de información en el dispositivo.</p>
                </section>

                <section>
                    <h2 class="text-2xl font-semibold tracking-tight text-slate-950">2. Tecnologías que utiliza actualmente el sitio</h2>
                    <p class="mt-3">La aplicación utiliza únicamente cookies técnicas propias necesarias para gestionar sesiones, proteger los formularios frente a solicitudes falsificadas y permitir la autenticación del panel privado. La sesión se guarda en el servidor; la cookie conserva el identificador necesario para asociar la navegación con esa sesión.</p>
                    <p class="mt-3">Actualmente no utilizamos almacenamiento local del navegador con finalidades analíticas, publicitarias o de seguimiento.</p>
                </section>

                <section>
                    <h2 class="text-2xl font-semibold tracking-tight text-slate-950">3. Cookies propias utilizadas</h2>
                    <div class="mt-4 overflow-x-auto">
                        <table class="w-full min-w-[42rem] border-collapse text-left text-sm">
                            <thead>
                                <tr class="border-b border-slate-300 text-slate-950">
                                    <th class="px-3 py-3 font-semibold">Nombre</th>
                                    <th class="px-3 py-3 font-semibold">Finalidad</th>
                                    <th class="px-3 py-3 font-semibold">Duración aproximada</th>
                                    <th class="px-3 py-3 font-semibold">Tipo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-slate-200 align-top">
                                    <td class="px-3 py-3">Cookie de sesión de Primero el Voleibol</td>
                                    <td class="px-3 py-3">Mantener la sesión, conservar temporalmente errores o mensajes de formularios y permitir la autenticación del panel privado.</td>
                                    <td class="px-3 py-3">120 minutos</td>
                                    <td class="px-3 py-3">Propia, técnica y estrictamente necesaria.</td>
                                </tr>
                                <tr class="border-b border-slate-200 align-top">
                                    <td class="px-3 py-3"><code>XSRF-TOKEN</code></td>
                                    <td class="px-3 py-3">Ayudar a proteger los formularios y peticiones frente a ataques de falsificación de solicitudes (CSRF).</td>
                                    <td class="px-3 py-3">120 minutos</td>
                                    <td class="px-3 py-3">Propia, técnica y estrictamente necesaria.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <p class="mt-3">La cookie de sesión es propia y las sesiones se almacenan mediante el driver de base de datos. Estos mecanismos también permiten la autenticación segura del área privada de administración.</p>
                </section>

                <section>
                    <h2 class="text-2xl font-semibold tracking-tight text-slate-950">4. Cookies y servicios de terceros</h2>
                    <p class="mt-3">Actualmente no utilizamos cookies de analítica, publicidad o seguimiento, ni servicios de Google Analytics, Google Tag Manager, Meta Pixel, Hotjar, mapas embebidos, vídeos embebidos o reCAPTCHA.</p>
                    <p class="mt-3">El sitio puede contener enlaces a páginas externas. Al acceder a ellas se aplicarán las políticas del sitio de destino.</p>
                </section>

                <section>
                    <h2 class="text-2xl font-semibold tracking-tight text-slate-950">5. Consentimiento</h2>
                    <p class="mt-3">Actualmente solo se utilizan cookies técnicas estrictamente necesarias para prestar las funciones solicitadas y mantener la seguridad del sitio. Por ello, no se muestra un banner de consentimiento de cookies y estas cookies no se configuran con una finalidad analítica, publicitaria o de seguimiento.</p>
                    <p class="mt-3">Si en el futuro se incorporan cookies no necesarias o servicios de terceros que las generen, se revisará esta política y, cuando corresponda, se solicitará el consentimiento previo antes de activarlos.</p>
                </section>

                <section>
                    <h2 class="text-2xl font-semibold tracking-tight text-slate-950">6. Cómo gestionar las cookies</h2>
                    <p class="mt-3">Puedes consultar, bloquear o eliminar cookies desde las opciones de privacidad y seguridad de tu navegador. La forma de hacerlo depende del navegador utilizado y de su versión.</p>
                    <p class="mt-3">Si bloqueas o eliminas las cookies necesarias, es posible que debas iniciar de nuevo una sesión, que se pierdan mensajes o estados temporales del formulario y que no puedas enviar formularios o acceder al panel privado correctamente.</p>
                </section>

                <section>
                    <h2 class="text-2xl font-semibold tracking-tight text-slate-950">7. Cambios en esta política</h2>
                    <p class="mt-3">Esta Política de Cookies podrá actualizarse si cambia la tecnología utilizada, se incorporan nuevos servicios o se modifican las finalidades del tratamiento. La versión vigente estará disponible en esta página.</p>
                    <p class="mt-3"><strong>Última actualización: 8 de septiembre de 2026.</strong></p>
                </section>
            </div>
        </div>
    </section>
@endsection
