@extends('admin.layout.app')

@section('content')
<div class="container-fluid py-4">

    <div class="mb-4">
        <a href="{{ route('director.bulletins-details.index', $bulletin) }}"
           class="text-decoration-none text-muted">
            <i class="fas fa-arrow-left me-1"></i> Retour aux détails
        </a>

        <h2 class="fw-bold mt-3 mb-1">
            <i class="fas fa-pen-to-square text-primary me-2"></i>
            Modifier une matière
        </h2>

        <p class="text-muted mb-0">
            Matière : <strong>{{ $detail->matiere_libelle }}</strong>
        </p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Veuillez corriger les erreurs suivantes :</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="fw-bold mb-0">Modification des notes</h5>
        </div>

        <div class="card-body p-4">
            <form action="{{ route('director.bulletins-details.update', [$bulletin, $detail]) }}"
                  method="POST">
                @csrf
                @method('PUT')

                @include('bulletin-details._form')
            </form>
        </div>
    </div>

</div>
@endsection
