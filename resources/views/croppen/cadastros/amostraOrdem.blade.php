@extends('welcome')
@section('title', "Cadastro Amostras")

@section('content')


<div class="card p-4">
    <form method="POST" action="{{ url('amostras/cadastro') }}">
    @csrf
    
    <h3>Cadastro Amostras</h3>
    
        
        <label>Numero da Ordem de serviço</label>
        <input type="text" name="ordem_servico_id" id="ordem_servico_id" class="form-control" value="{{ $ordemId}}" required readonly>

        <div class="row mt-5">
            <div class="col-6">
                <div class="input-group input-group-static mb-4">
                    <label>Identificação Interno</label>
                    <input type="text" name="id_interno" id="id_interno" class="form-control" required>
                </div>
            </div>
            <div class="col-6">
                <div class="input-group input-group-static mb-4">
                    <label>Identificação Externo</label>
                    <input type="text" name="id_externo" id="id_externo" class="form-control" required>
                </div>
            </div>
            <div class="col-6">
                <div class="input-group input-group-static mb-4">
                    <label>Cultura</label>
                    <input type="text" name="cultura" id="cultura" class="form-control"  required>
                </div>
            </div>
            <div class="col-6">
                <div class="input-group input-group-static mb-4">
                    <label>Propriedade</label>
                    <input type="text" name="propriedade" id="propriedade" class="form-control"  required>
                </div>
            </div>
            <div class="col-6">
                <div class="input-group input-group-static mb-4">
                    <label>tipo</label>
                    <input type="text" name="tipo" id="tipo" class="form-control"  required>
                </div>
            </div>
            <div class="col-6">
                <div class="input-group input-group-static mb-4">
                    <label>Lote</label>
                    <input type="text" name="lote" id="lote" class="form-control" required>
                </div>
            </div>
            <div class="col-6">
                <div class="input-group input-group-static mb-4">
                    <label>Status</label>
                    <input type="text" name="status" id="status" class="form-control"  required>
                </div>
            </div>
            <div class="col-6">
                <div class="input-group input-group-static mb-4">
                    <label>Data</label>
                    <input type="text" name="data_amostra" id="data_amostra" class="form-control" required>
                </div>
            </div>
            <div class="col-6">
                <div class="input-group input-group-static mb-4">
                    <label>Descriçao</label>
                    <input type="text" name="descricao" id="descricao" class="form-control"  >
                </div>
            </div>
            <div class="col-6">
                <div class="input-group input-group-static mb-4">
                    <label>Solicitante</label>
                    <input type="text" name="solicitantes" id="solicitantes" class="form-control" >
                </div>
            </div>
            <div class="col-6">
                <button type="submit" class="btn btn-primary btn-sm">Salvar</button>
            </div>
           
        </div>
    </form>

</div>

@endsection