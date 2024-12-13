<div class="container-fluid">

    <div class="row">
        <div class="col-12 p-3 d-flex justify-content-end">
            <!-- Botão para abrir o modal -->
            <button onclick="criar_usuario()" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#userModal">
                Cadastrar Usuário
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <table id="table_pasta" class="table">
                <thead class="table-dark">
                    <tr>
                        <th>Id</th>
                        <th>Nome</th>
                        <th>Usuário</th>
                        <th>Telefone</th>
                        <th>Perfil</th>
                        <th>Excluir</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="pastaModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="pastaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h3 class="modal-title text-white" id="pastaModalLabel">Cadastrar Usuário</h3>
                <button id="btn-pasta-close" type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id='alerta_excluir' class="alert alert-danger" role="alert">
                    <h4 class="alert-heading">Atenção!</h4>
                    <p>Ao excluir a pasta <b>"<span id='excluir_nome'></span>"</b> com id <b>"<span id='excluir_id'></span>"</b>, todos os <b>arquivos</b> desta pasta também <b>serão excluidos!</b></p>
                    <hr>
                    <p class="mb-0"><b>Tem certeza que deseja excluir esta pasta?</b></p>
                </div>
                <form id="pastaForm">
                    <input type="hidden" id="tipo_form">
                    <input type="hidden" id="pasta_id" name="id_pasta">

                    <button id="submit_pasta_form" type="submit" class="btn btn-primary">Salvar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="info-cadastro-pasta" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                Usuário cadastrado com sucesso!!!
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<script>
    const toast_cadastro = document.getElementById('info-cadastro-pasta')
    const aviso_cadastro = bootstrap.Toast.getOrCreateInstance(toast_cadastro)

    get_lista_pasta()
    async function get_lista_pasta() {
        const response = await $.get("db/get_lista_pasta.php");
        $("#table_pasta tbody").html(response);
    }

    const URL = {
        deletar_pasta: 'db/deletar_pasta.php'
    }

    const AVISO = {
        deletar_pasta: 'Pasta excluída com sucesso!!!'
    }

    $("#pastaForm").on("submit", function(e) {
        e.preventDefault(); // Evita o envio padrão do formulário

        let tipo = $("#tipo_form").val()
        let url = URL[tipo];
        // Obtém os dados do formulário
        const formData = $(this).serialize();
        form_pasta_submit(formData, url, tipo)

    });

    async function form_pasta_submit(formData, url, tipo) {
        const response = await $.post(url, formData);
        const obj = JSON.parse(response);
        $("#info-cadastro-pasta .toast-body").text(AVISO[obj.tipo])
        aviso_cadastro.show();
        get_lista_pasta()
        $("#pastaForm")[0].reset(); // Reseta o formulário
        $("#pastaModal").modal("hide"); // Fecha o modal
    }

    $("#btn-pasta-close").click(function() {
        $("#pastaForm")[0].reset(); // Reseta o formulário
    })

    function atualizarFormularioPasta(tipo, configuracoes) {
        const {
            titulo,
            botaoClasse,
            botaoTexto,
            mostrarInputs,
            alertaExcluir
        } = configuracoes;

        $("#tipo_form").val(tipo);
        $("#pastaModalLabel").text(titulo);
        $('#submit_pasta_form').attr('class', `btn ${botaoClasse}`).text(botaoTexto);

        if (mostrarInputs) {
            $(".inputs").show();
        } else {
            $(".inputs").hide();
        }

        if (alertaExcluir) {
            $("#alerta_excluir").show();
        } else {
            $("#alerta_excluir").hide();
        }
    }

    function excluir_pasta(id) {
        const pasta = {
            id: document.querySelector(`#${id} .id`).textContent,
            nome: document.querySelector(`#${id} .nome`).textContent
        };

        $("input#nome, input#email").removeAttr('required');
        $("form#pastaForm input#pasta_id").val(pasta.id);
        $("#excluir_nome").text(pasta.nome);
        $("#excluir_id").text(pasta.id);

        atualizarFormularioPasta("deletar_pasta", {
            titulo: "Excluir Pasta",
            botaoClasse: "btn-danger",
            botaoTexto: "Excluir",
            mostrarInputs: false,
            alertaExcluir: true
        });
    }
</script>