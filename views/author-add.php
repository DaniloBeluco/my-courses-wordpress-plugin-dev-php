
<div class="container"><br />
  <div class="row">
      <h2>Author Add Page</h2>
    <div class="card">
      <div class="card-header">
        Adicionar novo Autor
      </div>
      <div class="card-body">
      <span id="mb_success_message"></span>
        <form action="javascript:void(0)" id="frmAddAuthor">
          <div class="form-group">
            <label for="name">Nome:</label>
            <input type="text" name="name" required class="form-control" id="name" placeholder="Entre com o nome do autor">
          </div>

          <div class="form-group">
            <label for="fb-link">Link do Facebook:</label>
            <input type="text" name="fb-link" required class="form-control" id="fb-link" placeholder="Entre link do facecourse">
          </div>

          <div class="form-group">
            <label for="about">Sobre o Autor:</label>
            <textarea name="about" required class="form-control" id="about" placeholder="Fale sobre o curso"></textarea>
          </div>

          <button type="submit" class="btn btn-success">Enviar</button>
        </form>
        
      </div>
    </div>
  </div>
</div>