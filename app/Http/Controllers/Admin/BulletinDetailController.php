<?php

namespace App\Http\Controllers\Admin;

use App\Models\Bulletin;
use App\Models\BulletinDetail;
use App\Models\Matiere;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class BulletinDetailController extends Controller
{
    /**
     * Afficher les détails d'un bulletin.
     */
    public function index(Bulletin $bulletin)
    {
        $bulletinDetails = BulletinDetail::where('bulletin_id', $bulletin->id)
            ->with('matiere')
            ->get();

        return view('bulletin-details.index', compact('bulletin', 'bulletinDetails'));
    }

    public function show(Bulletin $bulletin, BulletinDetail $detail)
    {
        // Vérifier que cette matière appartient bien au bulletin demandé.
        abort_unless(
            $detail->bulletin_id === $bulletin->id,
            404
        );

        $detail->load('matiere');

        return view('bulletin-details.show', compact('bulletin', 'detail'));
    }

    public function edit(Bulletin $bulletin, BulletinDetail $detail)
    {
        // Vérifier que cette matière appartient bien au bulletin demandé.
        abort_unless(
            $detail->bulletin_id === $bulletin->id,
            404
        );

        $detail->load('matiere');

        return view('bulletin-details.edit', compact('bulletin', 'detail'));
    }
    public function update(Request $request, Bulletin $bulletin, BulletinDetail $detail)
    {
        // Vérifier que cette matière appartient bien au bulletin demandé.
        abort_unless(
            $detail->bulletin_id === $bulletin->id,
            404
        );

        // Validation des données
        $validatedData = $request->validate([
            'note' => 'required|numeric|min:0|max:20',
            'coefficient' => 'required|numeric|min:1',
        ]);

        // Mise à jour de la matière
        $detail->update($validatedData);

        return redirect()->route('director.bulletins-details.show', [$bulletin, $detail])
            ->with('success', 'Détails du bulletin mis à jour avec succès.');
    }
}
