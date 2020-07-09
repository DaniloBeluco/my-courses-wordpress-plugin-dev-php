<div class="container"><br />
    <div class="row">
        <h2>Student Add Page</h2>
        <div class="card">
            <div class="card-header">
                Adicionar novo estudante
            </div>
            <div class="card-body">
                <span id="mb_success_message"></span>

                <form action="javascript:void(0)" id="frmAddStudent">

                    <div class="form-group">
                        <label for="name">Nome:</label>
                        <input type="text" name="name" required class="form-control" id="name" placeholder="Entre com o nome do estudante">
                    </div>

                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" name="email" required class="form-control" id="email" placeholder="Entre com o email do estudante">
                    </div>

                    <div class="form-group">
                        <label for="username">Nome de Usuário:</label>
                        <input type="text" name="username" required class="form-control" id="username" placeholder="Entre com o nome de Usuário">
                    </div>

                    <div class="form-group">
                        <label for="password">Senha:</label>
                        <input type="password" name="password" required class="form-control" id="password" placeholder="Digite a senha">
                    </div>

                    <div class="form-group">
                        <label for="conf_password">Confirmação da Senha:</label>
                        <input type="password" name="conf_password" required class="form-control" id="conf_password" placeholder="Confirme a senha">
                    </div>

                    <button type="submit" class="btn btn-success">Enviar</button>
                </form>

            </div>
        </div>
    </div>
</div>