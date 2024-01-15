@extends('welcome')
@section('title', "Cadastro Resultados")

@section('content')


<div class="card p-4">
    <form method="POST" action="/postresultid" >
    @csrf

    <h3>Resultado Amostra {{ $resultados->amostra_id }}</h3>
        <input type="text" name="resultado_id" value="{{$resultados->id}}"  style="display:none">

        <div class="row mt-5">
            
            <div class="col-6">
                <div class="input-group input-group-static mb-4">
                <label for="nema_select">Nematoides</label>
                    <select name="nematode_id"  class="form-control" id="nema_select">
                        @foreach ($nema as $item)
                            <option value="{{ $item->id }}">{{ $item->genero }} - {{ $item->especie }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-6">
                <div class="input-group input-group-static mb-4">
                    <label>Quantidade</label>
                    <input type="number" name="quantidade" id="" class="form-control" >
                </div>
            </div>
            <div class="col-6">
                <button type="submit" class="btn btn-primary btn-sm">Salvar</button>
            </div>
           
        </div>
    </form>

</div>

<a href="/relatorioresultado">Relatório</a>

<div class="card p-2 mt-3">
        <div class="row">
            <div class="mt-3">
            <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-9 ps-2">
                                    Genero 
                                </th>
                                <th class="text-uppercase ps-1 text-secondary text-xxs font-weight-bolder opacity-9">
                                    Especie
                                </th>
                                <th class="text-uppercase ps-1 text-secondary text-xxs font-weight-bolder opacity-9 ">
                                    Quantidade
                                </th>
                                <th class="text-secondary opacity-7">
                                    *
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($idsresult as $iten)
                            <tr>                                
                                <td>
                                    <p class="text-xs text-secondary mb-0">{{ $iten->nematoides->genero }}</p>
                                </td>
                                <td>
                                    <p class="text-xxs text-secondary mb-0">{{ $iten->nematoides->especie }} </p>
                                </td>
                                <td>
                                    <p class="text-xs text-start text-secondary mb-0">{{ $iten->quantidade }}</p>
                                </td>
                                <td>
                                    <form action="{{ route('postresultid.destroy', ['id' => $iten->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este registro?')">Excluir</button>
                                    </form>
                                </td>
                            </tr>

                        </tbody>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection