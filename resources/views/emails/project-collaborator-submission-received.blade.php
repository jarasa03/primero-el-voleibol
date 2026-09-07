@component('mail::message')
# Nueva colaboración recibida

**Tipo:** {{ ucfirst($submission->collaborator_type) }}

**Nombre:** {{ $submission->full_name }}

@if ($submission->collaborator_type === 'club')
@if ($submission->club_locality)
**Localidad del club:** {{ $submission->club_locality }}
@endif

@if ($submission->club_contact_name)
**Nombre de la persona de contacto:** {{ $submission->club_contact_name }}
@endif

@if ($submission->club_contact_email)
**Correo de contacto del club:** {{ $submission->club_contact_email }}
@endif

@if ($submission->club_contact_phone)
**Teléfono de contacto del club:** {{ $submission->club_contact_phone }}
@endif
@endif

@if ($submission->collaborator_type === 'referee')
@if ($submission->referee_volleyball_level)
**Nivel de voleibol:** {{ $submission->referee_volleyball_level }}
@endif

@if ($submission->referee_beach_level)
**Nivel de voleyplaya:** {{ $submission->referee_beach_level }}
@endif

**Correo de contacto:** {{ $submission->referee_contact_email }}
**Teléfono de contacto:** {{ $submission->referee_contact_phone }}
@endif

@if ($submission->collaborator_type === 'coach')
@if ($submission->coach_volleyball_level)
**Nivel de voleibol:** {{ $submission->coach_volleyball_level }}
@endif

@if ($submission->coach_beach_level)
**Nivel de voleyplaya:** {{ $submission->coach_beach_level }}
@endif

@if ($submission->coach_main_club)
**Club principal:** {{ $submission->coach_main_club }}
@endif

**Correo de contacto:** {{ $submission->coach_contact_email }}
**Teléfono de contacto:** {{ $submission->coach_contact_phone }}
@unless ($submission->coach_show_club_on_profile)
**Identidad pública:** Anónima
@endunless
@endif

@if ($submission->collaborator_type === 'player')
**División:** {{ $submission->player_division }}
**Equipo:** {{ $submission->player_team }}
**Correo de contacto:** {{ $submission->player_contact_email }}
**Teléfono de contacto:** {{ $submission->player_contact_phone }}
@unless ($submission->player_show_team_on_profile)
**Identidad pública:** Anónima
@endunless
@endif

@if ($photoPath)
**Fotografía:**

<img src="{{ $message->embed($photoPath) }}" alt="Fotografía de {{ $submission->full_name }}" style="display: block; max-width: 100%; width: 360px; height: auto; border-radius: 12px;">
@endif
@endcomponent
