@extends('welcome')
@section('title', "Cadastro Orcamento")

@section('content')


<div class="card p-4">
    <form method="POST" action="{{ $orca->id ? route('orcaPut', ['id' => $orca->id]) : route('orcaPost') }}" >
    @csrf
    @if($orca->id)
        @method('PUT')
    @endif

    <h3>Cadastro Orcamento</h3>
    <h6 class="mt-2">{{$orca->id_interno}}</h6>

        <div class="row mt-5">
            <div class="col-6">
                <div class="input-group input-group-static mb-4">
                    <label>Cliente</label>
                    <input type="text" name="cliente_id" id="cliente_id" class="form-control" value="{{ $orca->cliente_id }}" >
                </div>
            </div>
            <div class="col-7">
                <div class="input-group input-group-static mb-4">
                    <label>Descriçao</label>
                    <input type="text" name="descricao" id="descricao" class="form-control" value="{{ $orca->descricao }}" required>
                </div>
            </div>
            <div class="col-2">
                <div class="input-group input-group-static mb-4">
                    <label>valor</label>
                    <input type="number" name="valor" id="valor" step="0.01" class="form-control" value="{{ $orca->valor }}" required>
                </div>
            </div>
            <div class="col-2">
                <div class="input-group input-group-static mb-4">
                    <label>Desconto</label>
                    <input type="number" name="desconto" id="desconto" step="0.01" class="form-control" value="{{ $orca->desconto }}" >
                </div>
            </div>
           
            <div class="col-6">
                <button type="submit" class="btn btn-primary btn-sm">Salvar</button>
            </div>
           
        </div>
    </form>
</div>