
@extends('admin.layout.app')

@section('title', 'Détails du niveau')

@section('content')
<style>
.niveau-show{background:#f5f8fd;min-height:85vh;padding:32px 0}
.niveau-show .heading{color:#172b4d;font-weight:750}
.niveau-show .muted{color:#7b879b}
.niveau-show .panel{background:#fff;border:1px solid #edf1f7;border-radius:16px;box-shadow:0 8px 28px rgba(27,53,87,.045);overflow:hidden}
.niveau-show .panel-head{padding:24px 28px;border-bottom:1px solid #edf1f7}
.niveau-show .panel-body{padding:28px}
.niveau-show .ico{width:60px;height:60px;display:flex;align-items:center;justify-content:center;border-radius:16px;background:#eaf2ff;color:#1769e0;font-size:27px;flex-shrink:0}
.niveau-show .detail-box{height:100%;padding:20px;border-radius:13px;background:#f8faff;border:1px solid #eaf0f7}
.niveau-show .detail-label{color:#8491a5;font-size:13px;margin-bottom:7px}
.niveau-show .detail-value{color:#263b5b;font-size:17px;font-weight:700}
.niveau-show .class-card{padding:18px;border:1px solid #e8edf5;border-radius:12px;background:#fff}
.niveau-show .btn{padding:10px 16px;border-radius:10px;font-weight:650}
.niveau-show .edit{background:#1769e0;color:white;border:1px solid #1769e0}
.niveau-show .edit:hover{background:#1055bc;color:white}
.niveau-show .back{background:#f70000;color:#fafcff;border:1px solid #dce5f1}
.niveau-show .pill{display:inline-block;background:#edf4ff;color:#1769e0;border-radius:30px;padding:7px 11px;font-size:12px;font-weight:650}
@media(max-width:576px){.niveau-show .panel-head,.niveau-show .panel-body{padding:20px}.niveau-show .actions{flex-direction:column-reverse}.niveau-show .actions .btn{width:100%}}
</style>

<div class="niveau-show">
<div class="container">

    <div class="mb-4">
        <a href="{{ route('director.niveau.index') }}" class="text-decoration-none">
            ← Retour à la liste
        </a>
    </div>

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h2 class="heading mb-2">Détails du niveau</h2>
            <p class="muted mb-0">Consultez le cycle et les classes associées.</p>
        </div>
        <a href="{{ route('director.niveau.edit', $niveau) }}" class="btn edit">✎ Modifier le niveau</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 rounded-3">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger border-0 rounded-3">{{ session('error') }}</div>
    @endif

    <div class="panel mb-4">
        <div class="panel-head">
            <div class="d-flex align-items-center gap-3">
                <div class="ico">▦</div>
                <div>
                    <div class="muted small mb-1">Niveau scolaire</div>
                    <h3 class="heading mb-1">{{ $niveau->nom }}</h3>
                    <div class="muted small">Référence #{{ $niveau->id }}</div>
                </div>
            </div>
        </div>

        <div class="panel-body">
            <h5 class="heading mb-3">Vue d'ensemble</h5>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <div class="detail-box">
                        <div class="detail-label">Nom du niveau</div>
                        <div class="detail-value">{{ $niveau->nom }}</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="detail-box">
                        <div class="detail-label">Cycle de rattachement</div>
                        <div class="detail-value">
                            {{ $niveau->cycle->nom ?? 'Aucun cycle associé' }}
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="detail-box">
                        <div class="detail-label">Classes associées</div>
                        <div class="detail-value">{{ $niveau->classes->count() }} classe(s)</div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                <h5 class="heading mb-0">Classes de ce niveau</h5>
                <span class="pill">{{ $niveau->classes->count() }} classe(s)</span>
            </div>

            @forelse($niveau->classes as $classe)
                <div class="class-card mb-3">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div>
                            <div class="fw-bold" style="color:#263b5b">
                                {{ $classe->nom ?? $classe->name ?? 'Classe #'.$classe->id }}
                            </div>
                            <small class="muted">Référence #{{ $classe->id }}</small>
                        </div>
                        <span class="pill">Classe associée</span>
                    </div>
                </div>
            @empty
                <div class="text-center py-4">
                    <div class="ico mx-auto mb-3">▤</div>
                    <h6 class="heading">Aucune classe associée</h6>
                    <p class="muted mb-0">
                        Aucune classe n'a encore été créée pour ce niveau.
                    </p>
                </div>
            @endforelse

            <div class="actions d-flex justify-content-between gap-3 mt-4 pt-4 border-top">
                <a href="{{ route('director.niveau.index') }}" class="btn back">← Retour à la liste</a>
                <a href="{{ route('director.niveau.edit', $niveau) }}" class="btn edit">Modifier les informations</a>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
