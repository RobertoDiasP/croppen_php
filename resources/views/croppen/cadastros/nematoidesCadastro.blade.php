@extends('welcome')
@section('title', "Cadastro Amostras")

@section('content')


<div class="card p-4">
    <form method="POST" action="{{ $nema->id ? route('nemaPut', ['id' => $nema->id]) : route('nemaPost') }}" >
    @csrf
    @if($nema->id)
        @method('PUT')
    @endif

    <h3>Cadastro Nematoides</h3>
    <h6 class="mt-2">{{$nema->genero}}</h6>

        <div class="row mt-5">
            <div class="col-6">
                <div class="input-group input-group-static mb-4">
                    <label>Genero</label>
                    <input type="text" name="genero" id="genero" class="form-control" value="{{ $nema->genero }}" required>
                </div>
            </div>
            <div class="col-6">
                <div class="input-group input-group-static mb-4">
                    <label>Especie</label>
                    <input type="text" name="especie" id="especie" class="form-control" value="{{ $nema->especie }}" required>
                </div>
            </div>
            <div class="col-6">
                <button type="submit" class="btn btn-primary btn-sm">Salvar</button>
            </div>
           
        </div>
    </form>

</div>

@endsection