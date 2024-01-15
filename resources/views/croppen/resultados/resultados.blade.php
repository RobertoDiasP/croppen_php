@extends('welcome')
@section('title', "Resultados")

@section('content')

<div class="px-4">
    <div class="card px-4">
        <h4 class="mt-2">
            Resultados
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
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">Adicionar</button>
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
                                    Amostra
                                </th>
                                <th class="text-uppercase ps-1 text-secondary text-xxs font-weight-bolder opacity-9">
                                    descricao
                                </th>
                                <th class="text-uppercase ps-1 text-secondary text-xxs font-weight-bolder opacity-9 ">
                                    Ordem
                                </th>
                                <th class="text-secondary opacity-7">
                                    *
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($resultados as $iten)
                            <tr>                                
                                <td>
                                    <p class="text-xs text-secondary mb-0">{{ $iten->id }}</p>
                                </td>
                                <td>
                                    <p class="text-xs text-secondary mb-0">{{ $iten->amostra_id }}</p>
                                </td>
                                <td>
                                    <p class="text-xxs text-secondary mb-0">{{ $iten->descricao }} </p>
                                </td>
                                <td>
                                    <p class="text-xs text-start text-secondary mb-0">{{ $iten->ordem_id }}</p>
                                </td>
                                <td>
                                     <a href="{{ route('resultCadastro', ['id' => $iten->id]) }}">Editar</a>
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
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-weight-normal" id="exampleModalLabel">Adicionar</h5>
        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
            <form method="POST" action="resultados/cadastro">
                @csrf
                <div class="col-12">
                    <div class="input-group input-group-static mb-4">
                        <label>Identificação Amostra</label>
                        <input type="text" name="amostra_id" class="form-control" >
                    </div>
                </div>
                <div class="col-12">
                    <div class="input-group input-group-static mb-4">
                        <label>Ordem Seriço</label>
                        <input type="text" name="ordem_id" class="form-control" >
                    </div>
                </div>
                <div class="col-12">
                    <div class="input-group input-group-static mb-4">
                        <label>Descrição</label>
                        <input type="text" name="descricao" class="form-control" >
                    </div>
                </div>
                <button type="subimit" class="btn bg-gradient-primary">Salvar</button>
                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Fechar</button>
            </form>
        </div>
      </div>
    </div>
  </div>
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