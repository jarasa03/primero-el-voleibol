<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreParticipationIdeaRequest;
use App\Mail\ParticipationIdeaReceived;
use App\Models\ParticipationIdea;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;

class ParticipationController extends Controller
{
    public function show(): View
    {
        return view('participa')->with('body_class', 'page-interior page-participa');
    }

    public function store(StoreParticipationIdeaRequest $request): RedirectResponse
    {
        $isAnonymous = $request->input('response_preference') === 'anonymous';

        $idea = ParticipationIdea::create([
            'name' => $isAnonymous ? null : $request->string('name')->toString(),
            'email' => $isAnonymous ? null : $request->string('email')->toString(),
            'club_or_role' => $request->string('club_or_role')->toString() ?: null,
            'topic' => $request->string('topic')->toString(),
            'idea' => $request->string('idea')->toString(),
            'source' => 'participa-page',
            'is_anonymous' => $isAnonymous,
            'consented_at' => now(),
            'adult_confirmed_at' => now(),
        ]);

        Mail::send(new ParticipationIdeaReceived($idea));

        return redirect()
            ->route('participa')
            ->with('status', 'Gracias. Hemos recibido tu idea y la revisaremos con calma.');
    }
}
