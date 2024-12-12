<div class="container-fluid">

    <div class="row">
        <div class="col-12 p-3 d-flex justify-content-start">
            <h2>PerfildoUsuário</h2>
        </div>
    </div>

    <div class="d-flex mb-3">
        <div class="flex-fill card p-3 text-bg-dark">
            <h3 style="color: #dde9f1;" id="usuario_nome"></h3>
            <p style="font-size: 20px; color: #dde9f1;" class="m-0" id="usuario_acesso"><b>Acesso:</b> <span></span></p>
            <p style="font-size: 20px; color: #dde9f1;" class="m-0" id="usuario_email"><b>Email:</b> <span></span></p>
            <p style="font-size: 20px; color: #dde9f1;" class="m-0" id="usuario_tel"><b>Whatsapp:</b> <span></span></p>
        </div>
    </div>

    <div class="d-flex gap-3">
        <div class="card p-3 text-bg-dark flex-fill w-50">
            <div>
                <h4 style="color: #dde9f1;">Pastas:</h4>
            </div>
            <div>
                <button onclick="criar_pasta()" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#folderModal">
                    Cadastrar Pasta
                </button>
            </div>
            <div id="lista_pastas" class="row">

            </div>
        </div>
        <div class="card p-3 text-bg-dark flex-fill w-50">
            <div>
                <h4 id="title_pasta" style="color: #dde9f1;">Seleciona uma pasta...</h4>
            </div>
            <div>
                <button id="btn-upload-arquivo" onclick="upload_arquivo()" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#folderModal" disabled>
                    Upload Arquivo
                </button>
            </div>
            <div class="row p-3" id="lista_arquivos">
                <table id="tabela_arquivos" class="table">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Visualizar</th>
                            <th>Excluir</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="folderModal" tabindex="-1" aria-labelledby="folderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-bg-dark">
                <h3 class="modal-title" id="folderModalLabel">Cadastrar Nova Pasta</h3>
                <button id='btn-folder-close' type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id='alerta_excluir' class="alert alert-danger" role="alert">
                    <h4 class="alert-heading">Atenção!</h4>
                    <p>Ao excluir a pasta <b>"<span id='excluir_pasta'></span>"</b>, todos os <b>arquivos</b> desta pasta também <b>serão excluidos!</b></p>
                    <hr>
                    <p class="mb-0"><b>Tem certeza que deseja excluir esta pasta?</b></p>
                </div>
                <form id="folderForm">
                    <input type="hidden" name="tipo" class="tipo_form">
                    <input type="hidden" name="id_pasta" id="id_pasta">
                    <input type="hidden" name="id_usuario" value="<?= $_GET["id"]; ?>" required>
                    <div class="mb-3 inputs">
                        <label for="nome" class="form-label">Nome da Pasta</label>
                        <input type="text" class="form-control" id="nome" name="nome" required>
                    </div>
                    <button id="submit_folder_form" type="submit" class="btn btn-primary">Salvar</button>
                </form>

                <form id="formCadastroArquivo" enctype="multipart/form-data">
                    <input type="hidden" name="tipo" class="tipo_form">
                    <input type="hidden" name="id_arquivo" id="id_arquivo">
                    <div class="mb-3">
                        <input type="hidden" class="form-control" name="id_usuario" value="<?= $_GET["id"]; ?>" required>
                    </div>
                    <div class="mb-3">
                        <input type="hidden" class="form-control" id="id_pasta" name="id_pasta">
                    </div>
                    <div class="mb-3 inputs">
                        <label for="arquivo" class="form-label">Arquivo (PDF apenas)</label>
                        <input type="file" class="form-control" id="arquivo" name="arquivo" accept="application/pdf" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Cadastrar</button>
                </form>

            </div>
        </div>
    </div>
</div>

<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="info-aviso-pasta" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                Usuário cadastrado com sucesso!!!
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<script>
    const toast_pasta = document.getElementById('info-aviso-pasta')
    const aviso_pasta = bootstrap.Toast.getOrCreateInstance(toast_pasta)

    async function get_usuario() {
        let data = {
            'id': <?= $_GET["id"]; ?>
        };
        const response = await $.get("db/perfil_usuario.php", data);
        const obj = JSON.parse(response);
        $("#usuario_nome").text(obj.nome)
        $("#usuario_acesso span").text(obj.acesso)
        $("#usuario_email span").text(obj.email)
        $("#usuario_tel span").text(obj.tel)
    }
    get_usuario()

    async function get_pastas() {
        let data = {
            'id': <?= $_GET["id"]; ?>
        };
        const response = await $.get("db/perfil_pastas.php", data);
        const obj = JSON.parse(response);
        $("#lista_pastas").html(obj.pastas)
    }
    get_pastas()

    const URL = {
        cadastrar: 'db/cadastrar_pasta.php',
        editar: 'db/editar_pasta.php',
        deletar: 'db/deletar_pasta.php',
        upload_file: 'db/cadastrar_arquivo.php',
        deletar_file: 'db/excluir_arquivo.php'
    }

    const AVISO = {
        cadastrar: 'Pasta criada com sucesso!!!',
        editar: 'Pasta atualizada com sucesso!!!',
        deletar: 'Pasta excluida com sucesso!!!',
        upload_file: 'Arquivo salvo com sucesso!!!',
        deletar_file: 'Arquivo deletado com sucesso!!!'
    }

    function atualizarFormularioPasta(tipo, configuracoes) {
        const {
            titulo,
            botaoClasse,
            botaoTexto,
            mostrarInputs,
            alertaExcluir,
            folderForm,
            formCadastroArquivo
        } = configuracoes;
        $(".tipo_form").val(tipo);
        $("#folderModalLabel").text(titulo);
        $('#submit_folder_form').attr('class', `btn ${botaoClasse}`).text(botaoTexto);
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

        if (folderForm) {
            $("#folderForm").show();
        } else {
            $("#folderForm").hide();
        }

        if (formCadastroArquivo) {
            $("#formCadastroArquivo").show();
        } else {
            $("#formCadastroArquivo").hide();
        }
    }

    function criar_pasta() {
        atualizarFormularioPasta("cadastrar", {
            titulo: "Cadastrar Pasta",
            botaoClasse: "btn-primary",
            botaoTexto: "Salvar",
            mostrarInputs: true,
            alertaExcluir: false,
            folderForm: true,
            formCadastroArquivo: false
        })
    }

    function editar_pasta(id, nome) {

        $("form#folderForm input#id_pasta").val(id);
        $("form#folderForm input#nome").val(nome);

        atualizarFormularioPasta("editar", {
            titulo: "Editar Pasta",
            botaoClasse: "btn-primary",
            botaoTexto: "Atualizar",
            mostrarInputs: true,
            alertaExcluir: false,
            folderForm: true,
            formCadastroArquivo: false
        })
    }

    function deletar_pasta(id, nome) {

        $("input#nome").removeAttr('required');
        $("form#folderForm input#id_pasta").val(id);
        $("form#folderForm input#nome").val(nome);
        $("span#excluir_pasta").text(nome)

        atualizarFormularioPasta("deletar", {
            titulo: "Excluir Pasta",
            botaoClasse: "btn-danger",
            botaoTexto: "Excluir",
            mostrarInputs: false,
            alertaExcluir: true,
            folderForm: true,
            formCadastroArquivo: false
        })
    }

    function upload_arquivo() {
        atualizarFormularioPasta("upload_file", {
            titulo: "Upload de Arquivo",
            botaoClasse: "btn-primary",
            botaoTexto: "Salvar",
            mostrarInputs: true,
            alertaExcluir: false,
            folderForm: false,
            formCadastroArquivo: true
        })
    }

    function excluir_arquivo(id, id_pasta) {
        $("form#formCadastroArquivo input#arquivo").removeAttr('required');
        $("form#formCadastroArquivo input#id_arquivo").val(id)
        $("form#formCadastroArquivo input#id_pasta").val(id_pasta)
        atualizarFormularioPasta("deletar_file", {
            titulo: "Excluir Arquivo",
            botaoClasse: "btn-danger",
            botaoTexto: "Excluir",
            mostrarInputs: false,
            alertaExcluir: true,
            folderForm: false,
            formCadastroArquivo: true
        })
    }

    async function form_pasta_submit(formData, url, tipo) {
        const response = await $.post(url, formData);
        $("#folderForm")[0].reset(); // Reseta o formulário
        $("#folderModal").modal("hide"); // Fecha o modal
        get_pastas()
        $("#info-aviso-pasta .toast-body").text(AVISO[tipo])
        aviso_pasta.show();
        if (tipo === "editar") {
            const obj = JSON.parse(response)
            $("#title_pasta").text(obj.pasta)
        }
    }

    $("#folderForm").on("submit", function(e) {
        e.preventDefault(); // Evita o comportamento padrão do formulário
        const formData = $(this).serializeJSON();
        let tipo = formData.tipo;
        let url = URL[tipo];

        form_pasta_submit(formData, url, tipo)
    });

    $("#btn-folder-close").click(function() {
        $("#folderForm")[0].reset(); // Reseta o formulário
        $('#formCadastroArquivo')[0].reset();
    })


    function listar_arquivos(id, nome) {
        $("button#btn-upload-arquivo").removeAttr('disabled');
        $("#title_pasta").html("<span>" + nome + "</span>")
        $("form#formCadastroArquivo input#id_pasta").val(id)
        get_arquivos(id)
    }

    $('#formCadastroArquivo').on('submit', function(e) {
        e.preventDefault();

        let tipo = $("form#formCadastroArquivo input.tipo_form").val()

        let formData = new FormData(this);
        // Faz a requisição AJAX
        $.ajax({
            url: URL[tipo],
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {

                if (response.status === "success") {
                    $('#folderModal').modal('hide');
                    $('#formCadastroArquivo')[0].reset();
                    get_arquivos(response.id_pasta)
                    $("#info-aviso-pasta .toast-body").text(AVISO[response.aviso])
                    aviso_pasta.show();
                } else {
                    alert('Erro: ' + response.message);
                }

            },
            error: function(xhr, status, error) {
                console.error('Erro na requisição:', error);
                alert('Erro ao cadastrar arquivo. Tente novamente mais tarde.');
            },
        });
    });

    async function get_arquivos(id) {
        let data = {
            'id': id
        };
        const response = await $.get("db/perfil_arquivos.php", data);
        $("table#tabela_arquivos tbody").html(response)
    }
</script>