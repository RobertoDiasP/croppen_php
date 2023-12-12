@extends('welcome')
@section('title', "Lista Amostras")

@section('content')


<div class="card p-4">
    <form action="/amostras" method="GET">

        <div class="row">
            <h3>Filtros</h3>
            <div class="col-6">
                <div class="input-group input-group-static mb-4">
                    <label>Id Interno</label>
                    <input type="text" name="id_interno" id="id_interno" class="form-control">
                </div>
            </div>
            <div class="col-6">
                <div class="input-group input-group-static mb-4">
                    <label>Id Externo</label>
                    <input type="text" name="id_externo" class="form-control" >
                </div>
            </div>
            <div class="col-6">
                <div class="input-group input-group-static mb-4">
                    <label>Cultura</label>
                    <input type="text" name="cultura" class="form-control">
                </div>
            </div>
            <div class="col-3">
                <div class="input-group input-group-static mb-4">
                    <label>De</label>
                    <input type="date"  class="form-control">
                </div>
            </div>
            <div class="col-3">
                <div class="input-group input-group-static mb-4">
                    <label>Até</label>
                    <input type="date" class="form-control">
                </div>
            </div>
            <div class="col-6">
                <button type="submit" class="btn btn-primary btn-sm">Buscar</button>
            </div>
            <div class="col-6 text-end">
            <a type="button" class="btn btn-success btn-sm"  href="{{ route('cadastroAmostra') }}">Nova Amostra</a>
            </div>
        </div>
    </form>
</div>


<div class="card p-4 mt-3">
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

@endsection