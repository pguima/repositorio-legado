<?php

/*
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
} 

// Caminho do arquivo (ex: /path)
$path = parse_url($_SERVER['REQUEST_URI']);

$content = match ($path['path']) {
    '/' => "pages/usuarios.html",
    '/pastas' => 'pages/pastas.html',
    '/perfil' => 'pages/perfil.html',
    default => "pages/usuarios.html"
};

include "pages/header.html";
include $content;
include "pages/footer.html";

include "database/conexao.php";

try {
	// Executa a consulta para listar todas as tabelas do banco
	$query = $pdo->query("SHOW TABLES");

	// Obtém os resultados
	$tables = $query->fetchAll(PDO::FETCH_COLUMN);

	// Exibe as tabelas
	echo "Tabelas no banco de dados '$db':<br>";
	foreach ($tables as $table) {
		echo $table . "<br>";
	}
} catch (PDOException $e) {
	// Trata erros
	echo "Erro ao listar tabelas: " . $e->getMessage();
}
*/

include "pages/header.php";
?>

<div class="container-fluid">
	<div class="row bg-dark">
		<div class="col-2 text-white">
			<h1>NatoVet</h1>
		</div>
	</div>

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
			<table id="table_usuarios" class="table">
				<thead class="table-dark">
					<tr>
						<th>Id</th>
						<th>Nome</th>
						<th>Email</th>
						<th>Telefone</th>
						<th>Acesso</th>
						<th>Perfil</th>
						<th>Editar</th>
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
<div class="modal fade" id="userModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg-dark">
				<h3 class="modal-title text-white" id="userModalLabel">Cadastrar Usuário</h3>
				<button id="btn-user-close" type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div id='alerta_excluir' class="alert alert-danger" role="alert">
					<h4 class="alert-heading">Atenção!</h4>
					<p>Ao excluir o usuário <b>"<span id='excluir_nome'></span>"</b> com id <b>"<span id='excluir_id'></span>"</b>, todas as <b>pastas</b> e <b>arquivos</b> deste usuários também <b>serão excluidos!</b></p>
					<hr>
					<p class="mb-0"><b>Tem certeza que deseja excluir este usuário?</b></p>
				</div>
				<form id="userForm">
					<input type="hidden" id="tipo_form">
					<input type="hidden" id="usuario_id" name="id">
					<div class="mb-3 inputs">
						<label for="nome" class="form-label">Nome</label>
						<input type="text" class="form-control" id="nome" name="nome" required>
					</div>
					<div class="mb-3 inputs">
						<label for="email" class="form-label">Email</label>
						<input type="email" class="form-control" id="email" name="email" required>
					</div>
					<div class="mb-3 inputs">
						<label for="tel" class="form-label">Telefone</label>
						<input type="text" class="form-control" id="tel" name="tel" minlength="15">
					</div>
					<div class="mb-3 inputs">
						<label for="acesso" class="form-label">Acesso</label>
						<select class="form-select" id="acesso" name="acesso" required>
							<option value="Usuário" selected>Usuário</option>
							<option value="Administrador">Administrador</option>
						</select>
					</div>
					<button id="submit_user_form" type="submit" class="btn btn-primary">Salvar</button>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="toast-container position-fixed bottom-0 end-0 p-3">
	<div id="info-cadastro-usuario" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
		<div class="d-flex">
			<div class="toast-body">
				Usuário cadastrado com sucesso!!!
			</div>
			<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
		</div>
	</div>
</div>

<script>
	const toast_cadastro = document.getElementById('info-cadastro-usuario')
	const aviso_cadastro = bootstrap.Toast.getOrCreateInstance(toast_cadastro)

	// Mácaras
	$('#tel').mask('(00) 00000-0000');

	get_lista_usuarios()

	async function get_lista_usuarios() {
		const response = await $.get("db/get_lista_usuario.php");
		$("#table_usuarios tbody").html(response);
	}

	const URL = {
		cadastrar: 'db/cadastrar_usuario.php',
		editar: 'db/editar_usuario.php',
		deletar: 'db/deletar_usuario.php'
	}

	const AVISO = {
		cadastrar: 'Usuário cadastrado com sucesso!!!',
		editar: 'Usuário atualizado com sucesso!!!',
		deletar: 'Usuário excluido com sucesso!!!'
	}

	$("#userForm").on("submit", function(e) {
		e.preventDefault(); // Evita o envio padrão do formulário

		let tipo = $("#tipo_form").val()
		let url = URL[tipo];
		// Obtém os dados do formulário
		const formData = $(this).serialize();
		form_usuarios_submit(formData, url, tipo)

	});

	async function form_usuarios_submit(formData, url, tipo) {
		const response = await $.post(url, formData);
		const obj = JSON.parse(response);
		$("#info-cadastro-usuario .toast-body").text(AVISO[obj.tipo])
		aviso_cadastro.show();
		get_lista_usuarios()
		$("#userForm")[0].reset(); // Reseta o formulário
		$("#userModal").modal("hide"); // Fecha o modal
	}

	$("#btn-user-close").click(function() {
		$("#userForm")[0].reset(); // Reseta o formulário
	})

	function atualizarFormularioUsuario(tipo, configuracoes) {
		const {
			titulo,
			botaoClasse,
			botaoTexto,
			mostrarInputs,
			alertaExcluir
		} = configuracoes;

		$("#tipo_form").val(tipo);
		$("#userModalLabel").text(titulo);
		$('#submit_user_form').attr('class', `btn ${botaoClasse}`).text(botaoTexto);

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

	function criar_usuario() {
		atualizarFormularioUsuario("cadastrar", {
			titulo: "Cadastrar Usuário",
			botaoClasse: "btn-primary",
			botaoTexto: "Salvar",
			mostrarInputs: true,
			alertaExcluir: false
		});
	}

	function editar_usuario(id) {
		const usuario = {
			id: document.querySelector(`#${id} .id`).textContent,
			nome: document.querySelector(`#${id} .nome`).textContent,
			email: document.querySelector(`#${id} .email`).textContent,
			tel: document.querySelector(`#${id} .tel a span span`).textContent,
			acesso: document.querySelector(`#${id} .acesso span`).textContent
		};

		$("form#userForm input#usuario_id").val(usuario.id);
		$("form#userForm input#nome").val(usuario.nome);
		$("form#userForm input#email").val(usuario.email);
		$("form#userForm input#tel").val(usuario.tel);
		$("form#userForm select#acesso").val(usuario.acesso);

		atualizarFormularioUsuario("editar", {
			titulo: "Atualizar Usuário",
			botaoClasse: "btn-primary",
			botaoTexto: "Atualizar",
			mostrarInputs: true,
			alertaExcluir: false
		});
	}

	function excluir_usuario(id) {
		const usuario = {
			id: document.querySelector(`#${id} .id`).textContent,
			nome: document.querySelector(`#${id} .nome`).textContent
		};

		$("input#nome, input#email").removeAttr('required');
		$("form#userForm input#usuario_id").val(usuario.id);
		$("#excluir_nome").text(usuario.nome);
		$("#excluir_id").text(usuario.id);

		atualizarFormularioUsuario("deletar", {
			titulo: "Excluir Usuário",
			botaoClasse: "btn-danger",
			botaoTexto: "Excluir",
			mostrarInputs: false,
			alertaExcluir: true
		});
	}
</script>

<?php
include "pages/footer.php";
?>