@extends('welcome')
@section('title', "Imagens")

@section('content')

<style>
    .grid-imagens {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }

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

    .modal-imagem {
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

    .modal-content {
        background: white;
        padding: 20px;
        border-radius: 10px;
        position: relative;
        text-align: center;
        width: 950px;
        max-width: 95%;
    }

    .imagem-container {
        width: 100%;
        height: 500px;
        overflow: auto;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .imagem-modal {
        max-width: 600px;
        max-height: 500px;
        transition: transform 0.2s ease;
    }

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

    .fechar {
        position: absolute;
        top: 10px;
        right: 15px;
        font-size: 22px;
        font-weight: bold;
        cursor: pointer;
    }

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

    .botoes-card {
        display: flex;
        gap: 10px;
        margin-top: 10px;
    }

    .botoes-card button {
        flex: 1;
    }

    .filtros-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 25px 40px;
    }

    .campo {
        display: flex;
        flex-direction: column;
    }

    .campo label {
        font-size: 14px;
        margin-bottom: 6px;
        color: #555;
    }

    .campo input,
    .campo select {
        border: none;
        border-bottom: 2px solid #ddd;
        padding: 6px 4px;
        font-size: 15px;
        background: transparent;
    }

    .campo input:focus,
    .campo select:focus {
        outline: none;
        border-bottom: 2px solid #0d6efd;
    }

    .campo-agente {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .btn-add {
        white-space: nowrap;
    }

    .acoes {
        margin-top: 30px;
        display: flex;
        gap: 10px;
    }
</style>


<div id="app">

    <h1>Galeria de Imagens</h1>

    <div class="card mb-4 p-4">

        <div class="card-body p-5">

            <h5 class="mb-4">Filtros</h5>

            <div class="filtros-grid">

                <!-- ID -->
                <div class="campo">
                    <label>ID</label>
                    <input
                        type="text"
                        v-model="filtros.id">
                </div>

                <!-- Cultura -->
                <div class="campo">
                    <label>Cultura</label>
                    <input
                        type="text"
                        v-model="filtros.cultura">
                </div>

                <!-- Cidade -->
                <div class="campo">
                    <label>Cidade</label>
                    <input
                        type="text"
                        v-model="filtros.cidade">
                </div>

                <!-- Agente -->
                <div class="campo">

                    <label>Agente</label>

                    <div class="campo-agente">

                        <select v-model="filtros.agente">

                            <option value="">Todos</option>

                            <option
                                v-for="agente in agentes"
                                :key="agente.id"
                                :value="agente.id">

                                @{{ agente.nome }}

                            </option>

                        </select>

                        <button
                            class="btn btn-success"
                            @click="abrirModalAgente">

                            + Agente

                        </button>

                    </div>

                </div>

            </div>

            <div class="acoes">

                <button
                    class="btn btn-primary"
                    @click="buscar">

                    Buscar

                </button>

                <button
                    class="btn btn-secondary"
                    @click="limparFiltros">

                    Limpar

                </button>

            </div>

        </div>

    </div>

    <div class="grid-imagens p-3">

        <div v-for="img in imagens.data" :key="img.id" class="card">

            <img
                @click="abrirImagem(img)"
                :src="'https://croppen.org/storage/' + img.caminho">

            <div>ID: @{{ img.id }}</div>

            <div class="input-group input-group-static mb-4">
                <label>Cultura</label>
                <input type="text" v-model="img.cultura" class="form-control">
            </div>

            <div class="input-group input-group-static mb-4">
                <label>Cidade</label>
                <input type="text" v-model="img.cidade" class="form-control">
            </div>

            <div class="mb-3">

                <label>Agente</label>

                <div style="display:flex;gap:6px">

                    <select class="form-control" v-model="img.agenteSelecionado" style="flex:1">

                        <option value="">Selecione</option>

                        <option
                            v-for="agente in agentes"
                            :key="agente.id"
                            :value="agente.id">

                            @{{ agente.nome }}

                        </option>

                    </select>

                    <button
                        class="btn btn-success"
                        @click="adicionarAgente(img)">

                        +

                    </button>

                </div>

            </div>


            <div style="margin-top:10px">

                <div
                    v-for="agente in img.agentesLista"
                    :key="agente.id"
                    style="display:flex;justify-content:space-between;align-items:center;background:#f3f3f3;padding:6px;border-radius:4px;margin-bottom:4px">

                    <span>@{{ agente.nome }}</span>

                    <button
                        class="btn btn-sm btn-danger"
                        @click="removerAgente(img, agente.id)">

                        x

                    </button>

                </div>

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


    <div v-if="imagemSelecionada" class="modal-imagem" @click="fecharImagem">

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
    <div class="modal fade" id="modalAgente" tabindex="-1">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">Novo Agente</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

                </div>


                <div class="modal-body">

                    <input
                        class="form-control"
                        placeholder="Nome do agente"
                        v-model="novoAgente.nome">

                </div>


                <div class="modal-footer">

                    <button
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">

                        Cancelar

                    </button>

                    <button
                        class="btn btn-primary"
                        @click="salvarAgente">

                        Salvar

                    </button>

                </div>

            </div>

        </div>

    </div>

</div>


<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
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

                agentes: [],

                imagemSelecionada: null,

                zoom: 1,
                filtros: {
                    id: '',
                    cultura: '',
                    doenca: '',
                    cidade: '',
                    agente: ''
                },
                novoAgente: {
                    nome: ''
                }
            }

        },

        mounted() {

            this.carregarAgentes()

            this.carregarImagens()

        },

        methods: {

            abrirModalAgente() {

                let modal = new bootstrap.Modal(
                    document.getElementById('modalAgente')
                )

                modal.show()

            },
            async salvarAgente() {

                if (!this.novoAgente.nome) {
                    alert("Informe o nome")
                    return
                }

                try {

                    let response = await axios.post('/api/agentes', {
                        nome: this.novoAgente.nome
                    })

                    this.agentes.push(response.data)

                    this.novoAgente.nome = ""

                    bootstrap.Modal.getInstance(
                        document.getElementById('modalAgente')
                    ).hide()

                } catch (e) {

                    console.log(e)
                    alert("Erro ao salvar agente")

                }

            },

            async carregarAgentes() {

                try {

                    let response = await axios.get('/api/agentes')

                    this.agentes = response.data.data

                } catch (e) {

                    console.log("Erro ao carregar agentes", e)

                }

            },


            async carregarImagens(page = 1) {

                let params = {
                    page: page,
                    id: this.filtros.id,
                    cultura: this.filtros.cultura,
                    doenca: this.filtros.doenca,
                    cidade: this.filtros.cidade,
                    agente: this.filtros.agente
                }

                let response = await axios.get('/api/imagens', {
                    params
                })

                this.imagens = response.data

                this.imagens.data.forEach(img => {

                    img.agenteSelecionado = ""

                    img.agentesLista = img.agentes ? [...img.agentes] : []

                })

            },

            buscar() {

                this.carregarImagens()

            },
            limparFiltros() {

                this.filtros = {
                    id: '',
                    cultura: '',
                    doenca: '',
                    cidade: '',
                    agente: ''
                }

                this.carregarImagens()

            },

            adicionarAgente(img) {

                if (!img.agenteSelecionado) return

                let agente = this.agentes.find(a => a.id == img.agenteSelecionado)

                if (!agente) return

                // evitar duplicado
                let existe = img.agentesLista.find(a => a.id == agente.id)

                if (!existe) {

                    img.agentesLista.push(agente)

                }

                img.agenteSelecionado = ""

            },
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


            async salvar(img) {

                try {

                    let agentesIds = img.agentesLista.map(a => a.id)

                    await axios.put('/api/imagens/' + img.id, {

                        cultura: img.cultura,
                        doenca: img.doenca,
                        cidade: img.cidade,
                        agentes: agentesIds

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

                    await axios.delete('/api/imagens/' + img.id)

                    alert("Imagem deletada")

                    this.imagens.data = this.imagens.data.filter(i => i.id !== img.id)

                } catch (e) {

                    console.log(e)

                    alert("Erro ao deletar")

                }

            },
            removerAgente(img, agenteId) {

                img.agentesLista = img.agentesLista.filter(a => a.id !== agenteId)

            }

        },



    }).mount('#app')
</script>

@endsection