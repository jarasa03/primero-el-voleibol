@extends('layouts.public')

@section('title', 'Aviso legal | Primero el Voleibol')
@section('meta_description', 'Aviso legal de Primero el Voleibol.')
@section('body_class', 'page-legal')

@section('content')
    <section class="pb-12 pt-20 lg:pb-16 lg:pt-24">
        <div class="site-container">
            <p class="text-sm font-semibold uppercase tracking-[0.25em] text-accent-700">Aviso legal</p>
            <h1 class="mt-4 text-4xl font-semibold tracking-tight text-slate-950 sm:text-5xl">Aviso legal</h1>
            <p class="mt-5 text-lg leading-8 text-slate-700">
                Este Aviso Legal regula el acceso y uso del sitio web de Primero el Voleibol.
            </p>

            <div class="mt-10 space-y-8 text-base leading-7 text-slate-700">
                <section>
                    <h2 class="text-2xl font-semibold tracking-tight text-slate-950">1. Titularidad e identificación</h2>
                    <p class="mt-3">El titular del sitio web de Primero el Voleibol es <strong>Francisco Javier Arruabarrena Sabroso</strong>.</p>
                    <p>NIF: <strong>02821905Q</strong>.</p>
                    <p>Domicilio: <strong>Calle Sangenjo, 6, 2.º D, 28034 Madrid, España</strong>.</p>
                    <p>Dominio: <strong>primeroelvoleibol.es</strong>.</p>
                    <p>Correo de contacto: <a class="font-semibold text-accent-700 underline" href="mailto:javier.arrua@primeroelvoleibol.es">javier.arrua@primeroelvoleibol.es</a>.</p>
                    <p>Correo general del proyecto: <a class="font-semibold text-accent-700 underline" href="mailto:contacto@primeroelvoleibol.es">contacto@primeroelvoleibol.es</a>.</p>
                    <p>“Primero el Voleibol” es el nombre de un proyecto o movimiento. Actualmente no constituye una sociedad, asociación ni persona jurídica independiente.</p>
                </section>

                <section>
                    <h2 class="text-2xl font-semibold tracking-tight text-slate-950">2. Objeto del sitio web</h2>
                    <p class="mt-3">Primero el Voleibol es un proyecto relacionado con el voleibol madrileño que, entre otras finalidades, busca difundir propuestas, publicar información y opiniones, fomentar la participación, recibir ideas y dar a conocer proyectos, colaboradores y contenidos relacionados con el voleibol.</p>
                    <p class="mt-3">El sitio no se presenta como un partido político oficialmente constituido, una asociación registrada ni una candidatura electoral.</p>
                </section>

                <section>
                    <h2 class="text-2xl font-semibold tracking-tight text-slate-950">3. Condiciones de uso</h2>
                    <p class="mt-3">El acceso y uso del sitio deben realizarse de forma lícita, diligente y de buena fe. No está permitido utilizarlo con fines ilícitos, intentar dañar, bloquear o alterar su funcionamiento, ni introducir elementos que puedan perjudicar el sitio, sus sistemas o a otras personas usuarias.</p>
                    <p class="mt-3">Cada persona usuaria es responsable de la información que facilite a través de los formularios y del uso que haga del sitio.</p>
                </section>

                <section>
                    <h2 class="text-2xl font-semibold tracking-tight text-slate-950">4. Contenidos enviados por las personas usuarias</h2>
                    <p class="mt-3">El sitio permite enviar propuestas a través de <a class="font-semibold text-accent-700 underline" href="{{ route('participa') }}">/participa</a> y solicitudes de colaboración a través de <a class="font-semibold text-accent-700 underline" href="{{ route('proyecto') }}">/proyecto</a>.</p>
                    <p class="mt-3">La persona remitente se compromete a facilitar información y contenidos veraces y lícitos y a disponer de las autorizaciones necesarias cuando corresponda. No debe enviar datos personales de terceras personas sin autorización, ni contenidos ilícitos, ofensivos o que vulneren derechos de terceros.</p>
                    <p class="mt-3">Primero el Voleibol puede revisar, rechazar o no utilizar los contenidos recibidos. El envío de una propuesta no implica la obligación de publicarla ni de aceptarla.</p>
                </section>

                <section>
                    <h2 class="text-2xl font-semibold tracking-tight text-slate-950">5. Propiedad intelectual e industrial</h2>
                    <p class="mt-3">Los textos, el diseño, la estructura, la identidad visual, el código propio, los gráficos y demás contenidos originales del sitio están protegidos cuando corresponda por la normativa aplicable. No se permite reproducirlos o explotarlos fuera de los límites legales sin la autorización que resulte necesaria.</p>
                    <p class="mt-3">Las marcas, escudos, logos, fotografías u otros materiales de terceros pertenecen a sus respectivos titulares cuando corresponda. Su aparición en el sitio no implica necesariamente que sean propiedad de Primero el Voleibol.</p>
                </section>

                <section>
                    <h2 class="text-2xl font-semibold tracking-tight text-slate-950">6. Imágenes y contenidos de colaboradores</h2>
                    <p class="mt-3">Los clubes, árbitros, entrenadores y jugadores pueden facilitar fotografías o logos a través del formulario de colaboración y autorizar su posible publicación. Estos materiales se utilizarán conforme a la autorización facilitada.</p>
                    <p class="mt-3">La persona remitente declara disponer de los derechos o autorización suficiente para facilitar las imágenes, logos y demás contenidos. Si existe una reclamación legítima sobre una imagen o contenido, puede solicitarse su revisión o retirada escribiendo a <a class="font-semibold text-accent-700 underline" href="mailto:javier.arrua@primeroelvoleibol.es">javier.arrua@primeroelvoleibol.es</a> o a <a class="font-semibold text-accent-700 underline" href="mailto:contacto@primeroelvoleibol.es">contacto@primeroelvoleibol.es</a>.</p>
                </section>

                <section>
                    <h2 class="text-2xl font-semibold tracking-tight text-slate-950">7. Exactitud y actualización de la información</h2>
                    <p class="mt-3">Se intenta mantener la información del sitio actualizada y correcta. No obstante, pueden existir errores, cambios o información desactualizada. Primero el Voleibol puede modificar los contenidos cuando sea necesario y no garantiza que toda la información permanezca permanentemente actualizada.</p>
                </section>

                <section>
                    <h2 class="text-2xl font-semibold tracking-tight text-slate-950">8. Responsabilidad</h2>
                    <p class="mt-3">No se garantiza la disponibilidad ininterrumpida del sitio, que puede sufrir interrupciones técnicas, tareas de mantenimiento o incidencias ajenas al control razonable del titular.</p>
                    <p class="mt-3">El titular no responde de los daños derivados de actuaciones de terceros fuera de su control razonable. Los contenidos tienen carácter informativo u opinativo cuando corresponda. Esta limitación se entiende sin perjuicio de las responsabilidades que legalmente no puedan excluirse.</p>
                </section>

                <section>
                    <h2 class="text-2xl font-semibold tracking-tight text-slate-950">9. Enlaces externos</h2>
                    <p class="mt-3">El sitio puede incluir enlaces a páginas o servicios de terceros, normalmente como referencia o utilidad. El titular no controla necesariamente sus contenidos ni su funcionamiento. La inclusión de un enlace no implica aprobación, asociación ni responsabilidad sobre el sitio de destino.</p>
                </section>

                <section>
                    <h2 class="text-2xl font-semibold tracking-tight text-slate-950">10. Relación con entidades deportivas</h2>
                    <p class="mt-3">Primero el Voleibol es un proyecto independiente. Salvo que se indique expresamente lo contrario, no representa oficialmente a la Federación de Madrid de Voleibol, a la RFEVB, a clubes, árbitros, entrenadores, jugadores ni a otras entidades mencionadas.</p>
                    <p class="mt-3">La aparición de nombres, marcas, escudos o referencias a entidades deportivas no implica relación oficial, respaldo o afiliación.</p>
                </section>

                <section>
                    <h2 class="text-2xl font-semibold tracking-tight text-slate-950">11. Protección de datos</h2>
                    <p class="mt-3">El tratamiento de datos personales se regula en la <a class="font-semibold text-accent-700 underline" href="{{ route('legal.politica-de-privacidad') }}">Política de Privacidad</a>.</p>
                </section>

                <section>
                    <h2 class="text-2xl font-semibold tracking-tight text-slate-950">12. Cookies</h2>
                    <p class="mt-3">El uso de cookies y tecnologías similares se explica en la <a class="font-semibold text-accent-700 underline" href="{{ route('legal.politica-de-cookies') }}">Política de Cookies</a>.</p>
                </section>

                <section>
                    <h2 class="text-2xl font-semibold tracking-tight text-slate-950">13. Modificaciones</h2>
                    <p class="mt-3">Este Aviso Legal puede modificarse para adaptarse a cambios legales, técnicos, nuevas funcionalidades o cambios en el proyecto. La versión vigente será la publicada en esta página.</p>
                </section>

                <section>
                    <h2 class="text-2xl font-semibold tracking-tight text-slate-950">14. Legislación aplicable</h2>
                    <p class="mt-3">Este Aviso Legal se rige por el ordenamiento jurídico español. Cualquier controversia se someterá a los juzgados y tribunales que resulten competentes conforme a la normativa aplicable.</p>
                </section>

                <section>
                    <h2 class="text-2xl font-semibold tracking-tight text-slate-950">15. Última actualización</h2>
                    <p class="mt-3"><strong>Última actualización: 8 de septiembre de 2026.</strong></p>
                </section>
            </div>
        </div>
    </section>
@endsection
