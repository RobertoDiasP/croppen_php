


    <h1>Sua Página</h1>

    <h1>teste</h1>
    <ul>
        @foreach ($nema as $item)
            <li>{{ $item['nome'] }}: {{ $item['outra_propriedade'] }}</li>
            {{-- Adicione mais propriedades conforme necessário --}}
        @endforeach
    </ul>
    <label for="nema_select">Nematoides</label>
                    <select name="nematode_id"  class="form-control" id="nema_select">
                        @foreach ($nema as $item)
                            <option value="{{ $item->id }}">{{ $item->genero }} - {{ $item->especie }}</option>
                        @endforeach
                    </select>

    <div id="dadosNema" data-nema="@json($nema)"></div>
    
<script>
    // Acesse a variável no JavaScript
    var dadosNema = JSON.parse(document.getElementById('dadosNema').getAttribute('data-nema'));

    // Agora, 'dadosNema' é uma variável JavaScript contendo os dados do PHP
    console.log(dadosNema);
</script>