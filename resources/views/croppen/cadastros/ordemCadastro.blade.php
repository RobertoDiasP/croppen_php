@extends('welcome')
@section('title', "Cadastro Ordem")

@section('content')


<div class="card p-4">
    <form method="POST" action="{{ $ordem->id ? route('ordemPut', ['id' => $ordem->id]) : route('ordemPost') }}" >
    @csrf
    @if($ordem->id)
        @method('PUT')
    @endif

    <h3>Cadastro Ordem Serviço</h3>
    <h6 class="mt-2">Numero da Ordem de Serviço: {{$ordem->id}}</h6>

        <div class="row mt-5">
            <div class="col-6">
                <div class="input-group input-group-static mb-4">
                    <label>Data</label>
                    <input type="date" name="data" id="data" class="form-control" value="{{ $ordem->data }}" required>
                </div>
            </div>
            <div class="col-6">
                <div class="input-group input-group-static mb-4">
                    <label>Descrição</label>
                    <input type="text" name="descricao" id="descricao" class="form-control" value="{{ $ordem->descricao }}" required>
                </div>
            </div>
            <div class="col-6">
                <button type="submit" class="btn btn-primary btn-sm">Salvar</button>
            </div>
           
        </div>
    </form>
    <div class="row d-flex justify-content-center align-items-center mt-3 mb-3">
    <div class="card p-3 me-2 col-4">
        <form action="{{ $ordem->id ? '/ordem/import/'.$ordem->id : '/ordem/import' }}" method="post" enctype="multipart/form-data">
            <h6 class="text-center mb-2">Importar amostras para essa ordem</h6>
            @csrf
            <input type="file" name="file" accept=".xlsx, .xls">
            <button type="submit" class="btn btn-info btn-sm">Importar</button>
        </form>
    </div>
    <div class="card p-3  justify-content-center align-items-center col-4">
        <h6 class="text-center mb-2">Adicionar amostras manualmente para essa ordem</h6>
        <div class="div">
            @if($ordem->id)
                <a href="{{ route('ordemAmostras', ['id' => $ordem->id]) }}" type="button" class="text-end btn btn-success btn-sm">Adicionar Amostras</a>
            @endif
        </div>
    </div>
</div>

    <h6 class="text-center mt-3 mb-2">Amostras Vinculadas a Essa Ordem</h6>
    <div class="card p-3">
        <div class="row">
            <div class="mt-3">
                <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-9">
                                    Id Interno
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-9 ps-2">
                                    Id Externo
                                </th>
                                <th class="text-uppercase ps-1 text-secondary text-xxs font-weight-bolder opacity-9">
                                    Status
                                </th>
                                <th class="text-uppercase ps-1 text-secondary text-xxs font-weight-bolder opacity-9 ">
                                    Data Amostra
                                </th>
                                <th class="text-secondary opacity-7">
                                    *
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($amostras as $iten)
                            <tr>                                
                                <td>
                                    <p class="text-xs text-secondary mb-0">{{ $iten->id_interno }}</p>
                                </td>
                                <td>
                                    <p class="text-xs text-secondary mb-0">{{ $iten->id_externo }}</p>
                                </td>
                                <td>
                                    <p class="text-xxs text-secondary mb-0">{{ $iten->status }} </p>
                                </td>
                                <td>
                                    <p class="text-xs text-start text-secondary mb-0">{{ $iten->data_amostra }}</p>
                                </td>
                                <td>
                                     <a href="{{ route('amostraCadastro', ['id' => $iten->id]) }}">Editar</a>
                                     
                                </td>
                            </tr>

                        </tbody>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection