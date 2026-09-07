@component('mail::message')
# Nueva idea recibida

**Nombre:** {{ $idea->name ?: 'Envío privado' }}

**Correo:** {{ $idea->email ?: 'No facilitado' }}

**Club o función:** {{ $idea->club_or_role ?: 'No facilitado' }}

**Tema:** {{ $idea->topic }}

**Idea:**

{{ $idea->idea }}
@endcomponent
