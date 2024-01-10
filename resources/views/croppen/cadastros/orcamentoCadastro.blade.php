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
    <h6 class="mt-2">{{$orca->id}}</h6>

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

    <h6 class="text-center mt-3 mb-2">Itens do Orçamentosss</h6>
    <div class="card p-3">
    <h6>Total: R$ {{$totalValorId}}</h6>
        <div class="row">
        <div class="col-6">
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">Adicionar</button>
            </div>
            <div class="mt-3">
                <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-9 ps-2">
                                    Descrição
                                </th>
                                <th class="text-uppercase ps-1 text-secondary text-xxs font-weight-bolder opacity-9">
                                    Valor
                                </th>
                                <th class="text-uppercase ps-1 text-secondary text-xxs font-weight-bolder opacity-9 ">
                                    *
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orcaitem as $iten)
                            <tr>                                
                                <td>
                                    <p class="text-xs text-secondary mb-0">{{ $iten->descricao }}</p>
                                </td>
                                <td>
                                    <p class="text-xxs text-secondary mb-0">{{ $iten->valor }} </p>
                                </td>
                                <td>
                                    <form action="{{ route('orcamentoid.destroy', ['id' => $iten->id]) }}" method="POST">
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
            <form method="POST" action="/orcamentoid">
                @csrf
                <div class="col-12">
                    <div class="input-group input-group-static mb-4">
                        <label>Id Orçamento</label>
                        <input type="text" name="orcamento_id" class="form-control" value="{{ $orca->id }}" readonly>
                    </div>
                </div>
                <div class="col-12">
                    <div class="input-group input-group-static mb-4">
                        <label>Descrição</label>
                        <input type="text" name="descricao" class="form-control" required>
                    </div>
                </div>
                <div class="col-12">
                    <div class="input-group input-group-static mb-4">
                        <label>Valor</label>
                        <input type="number" name="valor" step="0.01" class="form-control" required>
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

@endsection