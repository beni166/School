@extends('admin.layout.app')

@section('title', 'Modifier une matière')

@section('content')
<div class="container-fluid px-3 px-md-4 py-4">

    <div class="mb-4">
        <a href="{{ route('director.matieres.index') }}"
           class="text-decoration-none text-secondary small">
            <i class="bi bi-arrow-left me-1"></i> Retour aux matières
        </a>

        <h1 class="h3 fw-bold mt-3 mb-1">Modifier la matière</h1>
        <p class="text-secondary mb-0">
            Modifiez les informations de {{ $matiere->nom }}.
        </p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger rounded-3">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-12 col-lg-8 col-xl-7">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 px-4 pt-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-3 bg-warning bg-opacity-10 text-warning
                                    d-flex align-items-center justify-content-center"
                             style="width:48px;height:48px;font-size:22px;">
                            <i class="bi bi-pencil-square"></i>
                        </div>
                        <div>
                            <h2 class="h5 fw-bold mb-1">Informations de la matière</h2>
                            <p class="text-secondary small mb-0">
                                Identifiant : MAT-{{ str_pad($matiere->id, 3, '0', STR_PAD_LEFT) }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                   <form action="{{ route('director.matieres.update', $matiere->id) }}" method="POST">
    @csrf
    @method('PUT')

                        <div class="mb-4">
                            <label for="nom" class="form-label fw-semibold">
                                Nom de la matière <span class="text-danger">*</span>
                            </label>

                            <input type="text"
                                   name="nom"
                                   id="nom"
                                   class="form-control form-control-lg rounded-3
                                          @error('nom') is-invalid @enderror"
                                   value="{{ old('nom', $matiere->nom) }}"
                                   maxlength="100"
                                   required>

                            @error('nom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex flex-wrap gap-2 justify-content-end">
                            <a href="{{ route('director.matieres.index') }}"
                               class="btn btn-light border rounded-3 px-4">
                                Annuler
                            </a>

                            <button type="submit" class="btn btn-primary rounded-3 px-4">
                                <i class="bi bi-check2-circle me-2"></i>
                                Enregistrer les modifications
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
