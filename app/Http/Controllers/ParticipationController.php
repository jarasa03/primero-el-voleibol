<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreParticipationIdeaRequest;
use App\Models\ParticipationIdea;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ParticipationController extends Controller
{
    public function show(): View
    {
        return view('participa')->with('body_class', 'page-interior page-participa');
    }

    public function store(StoreParticipationIdeaRequest $request): RedirectResponse
    {
        $isPrivate = $request->input('response_preference') === 'private';

        ParticipationIdea::create([
            'name' => $isPrivate ? null : $request->string('name')->toString(),
            'email' => $isPrivate ? null : $request->string('email')->toString(),
            'club_or_role' => $request->string('club_or_role')->toString() ?: null,
            'topic' => $request->string('topic')->toString(),
            'idea' => $request->string('idea')->toString(),
            'source' => 'participa-page',
            'is_anonymous' => $isPrivate,
            'consented_at' => now(),
        ]);

        return redirect()
            ->route('participa')
            ->with('status', 'Gracias. Hemos recibido tu idea y la revisaremos con calma.');
    }
}
