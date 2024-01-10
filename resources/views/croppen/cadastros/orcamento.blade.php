@extends('welcome')
@section('title', "Orcamento")

@section('content')

<div class="px-4">
    <div class="card px-4">
        <h4 class="mt-2">
            Orcamento
        </h4>
        <div class="row py-2">
            <div class="col-6">
                <div class="input-group input-group-static mb-4">
                    <label>Data de</label>
                    <input type="date" name="nome" class="form-control">
                </div>
            </div>
            <div class="col-6">
                <div class="input-group input-group-static mb-4">
                    <label>Data Até</label>
                    <input type="date" name="nome" class="form-control">
                </div>
            </div>
            <div class="col-6">
                <div class="input-group input-group-static mb-4">
                    <label>Nome Pasciente</label>
                    <input type="text" name="nome" class="form-control">
                </div>
            </div>
            <div class="col-6">
                <div class="input-group input-group-static mb-4">
                    <label>Status</label>
                    <input type="text" name="nome" class="form-control">
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4 justify-content-end">
        <div class="col-3 text-end">
          <a type="button" class="text-end btn btn-success btn-sm"  href="{{ route('orcaCreate') }}">Novo Orçamento</a>
        </div>
    </div>

     <div class="card">
        <div class="row">
            <div class="mt-3">
            <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-9">
                                    Id
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-9 ps-2">
                                    Data
                                </th>
                                <th class="text-uppercase ps-1 text-secondary text-xxs font-weight-bolder opacity-9">
                                    Status
                                </th>
                                <th class="text-uppercase ps-1 text-secondary text-xxs font-weight-bolder opacity-9 ">
                                    Descrição
                                </th>
                                <th class="text-secondary opacity-7">
                                    *
                                </th>
                                <th class="text-secondary opacity-7">
                                    *
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orca as $iten)
                            <tr>                                
                                <td>
                                    <p class="text-xs text-secondary mb-0">{{ $iten->id }}</p>
                                </td>
                                <td>
                                    <p class="text-xs text-secondary mb-0">{{ $iten->status }}</p>
                                </td>
                                <td>
                                    <p class="text-xxs text-secondary mb-0">{{ $iten->descricao }} </p>
                                </td>
                                <td>
                                    <p class="text-xs text-start text-secondary mb-0">{{ $iten->data }}</p>
                                </td>
                                <td>
                                     <a href="{{ route('orcaCadastro', ['id' => $iten->id]) }}">Editar</a>
                                </td>
                                <td>
                                    <a >importar Excel</a>
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


<div class="row justify-content-center">
    <div class="col-6">

        paginação
    </div>
    <!-- <div class="col">

    </div> -->
</div>



<style>
    .status-Recebido {
        background-color: #f2dfb1 !important;
        color: black !important /* ou a cor que desejar para Recebido */
    }
    .status-Pronto {
        background-color: #d1e389 !important;
        color: black !important /* ou a cor que desejar para Recebido */
    }
    .status-Processando {
        background-color: #a9e4cf !important;
        color: black !important /* ou a cor que desejar para Recebido */
    }
    .status-Postado {
        background-color: #b6deb9 !important;
        color: black !important /* ou a cor que desejar para Recebido */
    }
    .status-Pago {
        background-color: #5faae6 !important;
        color: black !important /* ou a cor que desejar para Recebido */
    }
</style>

@endsection