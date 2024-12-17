<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    <h4>Inscrição de Usuário</h4>
                </div>
                <div class="card-body">
                    <form id="formInscricao" method="POST">
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome Completo</label>
                            <input type="text" class="form-control" id="nome" name="nome" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="tel" class="form-label">Telefone</label>
                            <input type="text" class="form-control" id="tel" name="tel" placeholder="(DDD) 12345-6789">
                        </div>
                        <div class="mb-3">
                            <label for="acesso" class="form-label">Tipo de Acesso</label>
                            <select class="form-select" id="acesso" name="acesso">
                                <option value="user" selected>Usuário</option>
                                <option value="admin">Administrador</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="senha" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="senha" name="senha" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirmaSenha" class="form-label">Confirme a Senha</label>
                            <input type="password" class="form-control" id="confirmaSenha" name="confirmaSenha" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Inscrever</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#formInscricao').on('submit', function(e) {
            e.preventDefault();

            // Verifica se as senhas são iguais
            const senha = $('#senha').val();
            const confirmaSenha = $('#confirmaSenha').val();
            if (senha !== confirmaSenha) {
                alert('As senhas não coincidem.');
                return;
            }

            const formData = $(this).serialize();

            $.post('db/cadastrar_usuario.php', formData, function(response) {
                if (response.status === "success") {
                    alert('Usuário inscrito com sucesso!');
                    $('#formInscricao')[0].reset();
                } else {
                    alert('Erro ao inscrever usuário: ' + response.message);
                }
            }, 'json').fail(function() {
                alert('Erro na comunicação com o servidor.');
            });
        });
    });
</script>