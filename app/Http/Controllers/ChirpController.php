<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class ChirpController extends Controller
{
    public function index(): \Illuminate\Contracts\View\View
    {
        return view('chirps.index', [
            'chirps' => Chirp::with('user')
                ->latest()
                ->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'message' => 'required|string|max:255'
        ]);

        $request->user()->chirps()->create($validated);

        return redirect(route('chirps.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Chirp  $chirp
     * @return \Illuminate\Http\Response
     */
    public function show(Chirp $chirp)
    {
        //
    }

    /**
     * @throws AuthorizationException
     */
    public function edit(Chirp $chirp): \Illuminate\Contracts\View\View
    {
        $this->authorize('update', $chirp);

        return view('chirps.edit', ['chirp' => $chirp]);
    }

    public function update(Request $request, Chirp $chirp): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'message' => 'required|string|max:255'
        ]);

        $chirp->update($validated);

        return redirect(route('chirps.index'));
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(Chirp $chirp): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('delete', $chirp);

        $chirp->delete();

        return redirect(route('chirps.index'));
    }
}
