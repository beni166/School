@extends('secretariat.layout.app')

@section('title', 'Modifier les notes')

@section('content')
<div class="container-fluid px-3 px-md-4 py-4">
    <div class="mb-4">
        <a href="{{ route('secretariat.notes.index') }}" class="text-decoration-none text-secondary small"><i class="bi bi-arrow-left me-1"></i>Retour aux notes</a>
        <h1 class="h3 fw-bold mt-3 mb-1">Modifier les notes</h1>
        <p class="text-secondary mb-0">Modifiez les évaluations de l’élève. La matière, l’inscription et la période restent inchangées.</p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger border-0 shadow-sm rounded-3"><div class="fw-semibold mb-2">Veuillez corriger les erreurs suivantes :</div><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif
    @if(session('error'))<div class="alert alert-danger border-0 shadow-sm rounded-3"><i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}</div>@endif

    @php
        $nomEleve = trim(($note->inscription?->eleve?->nom ?? '') . ' ' . ($note->inscription?->eleve?->prenom ?? ''));
        $moyenne = ((float) $note->interrogation_1 + (float) $note->interrogation_2 + (float) $note->devoir + (float) $note->composition) / 4;
    @endphp

    <div class="row g-4">
        <div class="col-12 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 px-4 pt-4"><h2 class="h5 fw-bold mb-0"><i class="bi bi-info-circle text-primary me-2"></i>Contexte des notes</h2></div>
                <div class="card-body px-4">
                    <div class="detail-row"><span class="text-secondary">Élève</span><strong class="text-end">{{ $nomEleve !== '' ? $nomEleve : 'Non associé' }}</strong></div>
                    <div class="detail-row"><span class="text-secondary">Matricule</span><strong>{{ $note->inscription?->eleve?->matricule ?? '—' }}</strong></div>
                    <div class="detail-row"><span class="text-secondary">Classe</span><strong>{{ $note->inscription?->classe?->code ?? $note->inscription?->classe?->nom ?? '—' }}</strong></div>
                    <div class="detail-row"><span class="text-secondary">Matière</span><strong>{{ $note->matiere?->nom ?? '—' }}</strong></div>
                    <div class="detail-row"><span class="text-secondary">Période</span><strong>{{ $note->periode?->libelle ?? '—' }}</strong></div>
                    <div class="detail-row"><span class="text-secondary">Moyenne simple actuelle</span><span class="badge {{ $moyenne >= 10 ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} px-3 py-2">{{ number_format($moyenne, 2) }}/20</span></div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 px-4 pt-4">
                    <h2 class="h5 fw-bold mb-1"><i class="bi bi-pencil-square text-primary me-2"></i>Modifier les évaluations</h2>
                    <p class="text-secondary small mb-0">Les notes doivent rester comprises entre 0 et 20.</p>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('secretariat.notes.update', $note) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row g-4">
                            @foreach([
                                'interrogation_1' => 'Interrogation 1',
                                'interrogation_2' => 'Interrogation 2',
                                'devoir' => 'Devoir',
                                'composition' => 'Composition',
                            ] as $champ => $libelle)
                                <div class="col-12 col-md-6">
                                    <label for="{{ $champ }}" class="form-label fw-semibold">{{ $libelle }} <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-lg">
                                        <input type="number" name="{{ $champ }}" id="{{ $champ }}" class="form-control @error($champ) is-invalid @enderror" value="{{ old($champ, $note->$champ) }}" min="0" max="20" step="0.01" required>
                                        <span class="input-group-text">/20</span>
                                        @error($champ)<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="d-flex flex-wrap justify-content-end gap-2 border-top pt-4 mt-4">
                            <a href="{{ route('secretariat.notes.index') }}" class="btn btn-danger border rounded-3 px-4">Annuler</a>
                            <button type="submit" class="btn btn-primary rounded-3 px-4"><i class="bi bi-check2-circle me-2"></i>Enregistrer les modifications</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="alert alert-info border-0 rounded-3 mt-3 mb-0"><i class="bi bi-info-circle me-2"></i>Une période clôturée ou un bulletin déjà validé peut empêcher la modification. Ces contrôles sont vérifiés par le serveur.</div>
        </div>
    </div>
</div>

<style>
    .detail-row{display:flex;justify-content:space-between;align-items:flex-start;gap:14px;padding:15px 0;border-bottom:1px solid #edf0f5}
    .detail-row:last-child{border-bottom:0}
    .form-control,.input-group-text{border-radius:10px}
    .form-control:focus{border-color:#6d91e8;box-shadow:0 0 0 .2rem rgba(37,99,235,.10)}
    .rounded-4{border-radius:16px!important}
</style>
@endsection
