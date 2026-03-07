@extends('welcome')
@section('title', "Imagens")

@section('content')

<style>
    .grid-imagens {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }

    /* CARD DAS IMAGENS */

    .card {
        background: white;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        text-align: center;
    }

    .card img {
        width: 200px;
        height: 200px;
        object-fit: cover;
        border-radius: 8px;
        cursor: pointer;
        display: block;
        margin: auto;
    }


    /* MODAL */

    .modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;

        background: rgba(0, 0, 0, 0.85);

        display: flex;
        align-items: center;
        justify-content: center;

        z-index: 999;
    }


    /* CONTEUDO DO MODAL */

    .modal-content {
        background: white;
        padding: 20px;
        border-radius: 10px;
        position: relative;
        text-align: center;

        width: 950px;
        max-width: 95%;
    }


    /* AREA DA IMAGEM */

    .imagem-container {
        width: 100%;
        height: 500px;

        overflow: auto;

        display: flex;
        align-items: center;
        justify-content: center;
    }


    /* IMAGEM */

    .imagem-modal {
        max-width: 600px;
        max-height: 500px;

        transition: transform 0.2s ease;

        transform-origin: center center;
    }


    /* CONTROLES DE ZOOM */

    .zoom-controls {
        margin-bottom: 10px;
    }

    .zoom-controls button {
        margin: 5px;
        padding: 6px 12px;
        font-size: 16px;
        cursor: pointer;

        border: none;
        background: #2d89ef;
        color: white;
        border-radius: 5px;
    }

    .zoom-controls button:hover {
        background: #1b5fbf;
    }


    /* BOTAO FECHAR */

    .fechar {
        position: absolute;
        top: 10px;
        right: 15px;

        font-size: 22px;
        font-weight: bold;
        cursor: pointer;
    }


    /* PAGINACAO */

    .paginacao {
        margin-top: 25px;
        display: flex;
        gap: 10px;
        align-items: center;
        justify-content: center;
    }

    .paginacao button {
        padding: 6px 12px;
        border: none;
        background: #444;
        color: white;
        border-radius: 4px;
        cursor: pointer;
    }

    .paginacao button:hover {
        background: #222;
    }

    .botoes-card {
        display: flex;
        gap: 10px;
        margin-top: 10px;
    }

    .botoes-card button {
        flex: 1;
    }
</style>

<div id="app">

    <h1>Galeria de Imagens</h1>

    <div class="grid-imagens">

        <div v-for="img in imagens.data" :key="img.id" class="card">

            <img
                @click="abrirImagem(img)"
                :src="'https://croppen.org/storage/' + img.caminho">

            <div>ID: @{{ img.id }}</div>
            <div class="input-group input-group-static mb-4">
                <label>Cultura</label>
                <input type="text" v-model="img.cultura" name="razao_social" id="razao_social" class="form-control">
            </div>
            <div class="input-group input-group-static mb-4">
                <label>Doença</label>
                <input type="text" v-model="img.doenca" name="razao_social" id="razao_social" class="form-control">
            </div>
            <div class="input-group input-group-static mb-4">
                <label>Cidade</label>
                <input type="text" v-model="img.cidade" name="razao_social" id="razao_social" class="form-control">
            </div>

            <div class="botoes-card">
                <button class="btn btn-info btn-sm" @click="salvar(img)">Salvar</button>
                <button class="btn btn-danger btn-sm" @click="deletar(img)">Deletar</button>
            </div>
        </div>

    </div>

    <div class="paginacao">

        <button
            v-if="imagens.prev_page_url"
            @click="carregarImagens(imagens.current_page-1)">
            Anterior
        </button>

        <span>
            Página @{{ imagens.current_page }} de @{{ imagens.last_page }}
        </span>

        <button
            v-if="imagens.next_page_url"
            @click="carregarImagens(imagens.current_page+1)">
            Próxima
        </button>

    </div>


    <!-- MODAL -->

    <div v-if="imagemSelecionada" class="modal" @click="fecharImagem">

        <div class="modal-content" @click.stop>

            <div class="fechar" @click="fecharImagem">✖</div>

            <div class="zoom-controls">
                <button @click="zoomOut">-</button>
                <button @click="zoomIn">+</button>
                <button @click="resetZoom">Reset</button>
            </div>

            <div class="imagem-container">
                <img
                    :src="'https://croppen.org/storage/' + imagemSelecionada.caminho"
                    :style="{ transform: 'scale(' + zoom + ')' }"
                    class="imagem-modal">
            </div>

        </div>

    </div>


</div>

<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    const {
        createApp
    } = Vue

    createApp({

        data() {
            return {
                imagens: {
                    data: []
                },
                imagemSelecionada: null,
                zoom: 1
            }
        },

        mounted() {
            this.carregarImagens()
        },

        methods: {

            zoomIn() {
                this.zoom += 0.2
            },

            zoomOut() {
                if (this.zoom > 0.4) {
                    this.zoom -= 0.2
                }
            },

            resetZoom() {
                this.zoom = 1
            },

            abrirImagem(img) {
                this.imagemSelecionada = img
                this.zoom = 1
            },

            fecharImagem() {
                this.imagemSelecionada = null
            },

            async carregarImagens(page = 1) {

                let response = await axios.get('https://croppen.org/api/imagens?page=' + page)

                this.imagens = response.data.data

            },

            async salvar(img) {

                try {

                    axios.put('/api/imagens/' + img.id, {
                        cultura: img.cultura,
                        doenca: img.doenca,
                        cidade: img.cidade
                    })

                    alert("Salvo com sucesso")

                } catch (e) {

                    console.log(e)
                    alert("Erro ao salvar")

                }

            },
            async deletar(img) {

                if (!confirm("Deseja realmente deletar esta imagem?")) {
                    return
                }

                try {

                    await axios.delete('https://croppen.org/api/imagens/' + img.id)

                    alert("Imagem deletada")

                    // remove da lista sem recarregar
                    this.imagens.data = this.imagens.data.filter(i => i.id !== img.id)

                } catch (e) {

                    console.log(e)

                    alert("Erro ao deletar")

                }

            }
        }

    }).mount('#app')
</script>

@endsection