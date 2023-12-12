@extends('welcome')
@section('title', "Amostra")

@section('content')

<div class="px-4">
    <div class="card px-4">
        <h6>
            Amostras
        </h6>
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
                    <label>Id Interno</label>
                    <input type="text" name="nome" class="form-control">
                </div>
            </div>
            <div class="col-6">
                <div class="input-group input-group-static mb-4">
                    <label>Id Externo</label>
                    <input type="text" name="nome" class="form-control">
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4 justify-content-end">
        <div class="col-3 text-end">
          <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">Novo</button>
        </div>
    </div>
    <div class="card">
        <div class="row">
            <div class="mt-3">
                <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-9">
                                Id
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-9 ps-2">
                                    Nome
                                </th>
                                <th class="text-uppercase ps-1 text-secondary text-xxs font-weight-bolder opacity-9">
                                    Descriçao</th>
                                <th class="text-uppercase ps-1 text-secondary text-xxs font-weight-bolder opacity-9 ">
                                    Data Inicio</th>
                                <th class="text-secondary opacity-7">
                                    *
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($amostras as $iten)
                            <tr>
                                <td>
                                    <p class="text-xs text-center text-secondary mb-0">{{ $iten->id }}</p>
                                </td>
                                <td>
                                    <p class="text-xs text-secondary mb-0">{{ $iten->id_externo }}</p>
                                </td>
                                <td>
                                    <p class="text-xs text-secondary mb-0">{{ $iten->id_interno }}</p>
                                </td>
                                <td>
                                    <p class="text-xxs text-secondary mb-0">{{ $iten->id_cadastro }} </p>
                                </td>
                                <td class="">
                                    <button data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-secondary btn-sm mb-0">
                                        Editar
                                    </button>
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

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-weight-normal" id="exampleModalLabel">Amostras</h5>
        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
            <form method="POST" action="/cadastros/amostra">
                @csrf
                <div class="col-12">
                    <div class="input-group input-group-static mb-4">
                        <label>Id Interno</label>
                        <input type="text" name="id_interno" class="form-control">
                    </div>
                </div>
                <div class="col-12">
                    <div class="input-group input-group-static mb-4">
                        <label>Id Externo</label>
                        <input type="text" name="id_externo" class="form-control">
                    </div>
                </div>
                <div class="col-12">
                    <div class="input-group input-group-static mb-4">
                        <label>Cadastro Cadastro</label>
                        <input type="date" name="id_cadastro" class="form-control">
                    </div>
                </div>
                <div class="col-12">
                    <div class="input-group input-group-static mb-4">
                        <label>Cultura</label>
                        <input type="text" name="cultura" class="form-control">
                    </div>
                </div>
                <div class="col-12">
                    <div class="input-group input-group-static mb-4">
                        <label>Propriedade</label>
                        <input type="text" name="propriedade" class="form-control">
                    </div>
                </div>
                <div class="col-12">
                    <div class="input-group input-group-static mb-4">
                        <label>Tipo</label>
                        <input type="text" name="tipo" class="form-control">
                    </div>
                </div>
                <div class="col-12">
                    <div class="input-group input-group-static mb-4">
                        <label>Lote</label>
                        <input type="text" name="lote" class="form-control">
                    </div>
                </div>
                <div class="col-12">
                    <div class="input-group input-group-static mb-4">
                        <label>Status</label>
                        <input type="text" name="status" class="form-control">
                    </div>
                </div>
                <button type="subimit" class="btn bg-gradient-primary">Salvar</button>
                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
            </form>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection