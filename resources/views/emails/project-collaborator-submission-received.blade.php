@component('mail::message')
# Nueva solicitud de colaboración

**Tipo:** {{ ucfirst($submission->collaborator_type) }}

**Nombre:** {{ $submission->full_name }}

@if ($submission->club_locality)
**Localidad:** {{ $submission->club_locality }}
@endif

@if ($submission->club_contact_name)
**Persona de contacto:** {{ $submission->club_contact_name }}
@endif

@if ($submission->club_contact_email)
**Correo de contacto:** {{ $submission->club_contact_email }}
@endif

@if ($submission->referee_contact_email)
**Correo de contacto:** {{ $submission->referee_contact_email }}
@endif

@if ($submission->coach_contact_email)
**Correo de contacto:** {{ $submission->coach_contact_email }}
@endif

@if ($submission->player_contact_email)
**Correo de contacto:** {{ $submission->player_contact_email }}
@endif

La solicitud se ha guardado como pendiente en el panel de administración.
@endcomponent
