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
			<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#userModal">
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
				<h5 class="modal-title text-white" id="userModalLabel">Cadastrar Usuário</h5>
				<button id="btn-user-close" type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form id="userForm">
					<div class="mb-3">
						<label for="nome" class="form-label">Nome</label>
						<input type="text" class="form-control" id="nome" name="nome" required>
					</div>
					<div class="mb-3">
						<label for="email" class="form-label">Email</label>
						<input type="email" class="form-control" id="email" name="email" required>
					</div>
					<div class="mb-3">
						<label for="tel" class="form-label">Telefone</label>
						<input type="text" class="form-control" id="tel" name="tel">
					</div>
					<div class="mb-3">
						<label for="acesso" class="form-label">Acesso</label>
						<select class="form-select" id="acesso" name="acesso" required>
							<option value="user" selected>Usuário</option>
							<option value="admin">Administrador</option>
						</select>
					</div>
					<button type="submit" class="btn btn-primary">Salvar</button>
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
	const toastLiveExample = document.getElementById('info-cadastro-usuario')
	const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample)

	$(document).ready(function() {

		get_lista_usuarios()

		function get_lista_usuarios() {
			$.ajax({
				url: "db/get_lista_usuario.php", // Arquivo PHP para salvar no banco de dados
				type: "GET",
				success: function(response) {
					$("#table_usuarios tbody").html(response);
				},
				error: function() {
					alert("Erro ao cadastrar usuário!");
				}
			});
		}

		$("#userForm").on("submit", function(e) {
			e.preventDefault(); // Evita o envio padrão do formulário

			// Obtém os dados do formulário
			const formData = $(this).serialize();

			// Envia os dados via Ajax
			$.ajax({
				url: "db/cadastrar_usuario.php", // Arquivo PHP para salvar no banco de dados
				type: "POST",
				data: formData,
				success: function(response) {
					$("#userForm")[0].reset(); // Reseta o formulário
					$("#userModal").modal("hide"); // Fecha o modal
					toastBootstrap.show(); // Aviso cadastro com sucesso
				},
				error: function() {
					alert("Erro ao cadastrar usuário!");
				}
			});
		});

		$("#btn-user-close").click(function() {
			$("#userForm")[0].reset(); // Reseta o formulário
		})
	});
</script>

<?php
include "pages/footer.php";
?>