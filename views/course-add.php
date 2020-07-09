<?php
/* Vamos usar a biblioteca de mídia para carregar a imagem */
wp_enqueue_media();

/* Carregando a lista de autores */
global $wpdb;

$all_authors = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . my_authors_table() . " ORDER BY id DESC"), ARRAY_A);

?>

<div class="container"><br />
  <div class="row">
    <h2>Course Add Page</h2>
    <div class="card">
      <div class="card-header">
        Adicionar novo curso
      </div>
      <div class="card-body">
        <span id="mb_success_message"></span>
        <form action="javascript:void(0)" id="frmAddCourse">
          <div class="form-group">
            <label for="name">Nome:</label>
            <input type="text" name="name" required class="form-control" id="name" placeholder="Entre com o nome do curso">
          </div>

          <div class="form-group">
            <label for="author">Autor:</label>
            <select name="author" id="author" class="form-control">
            <option value=""> -- Selecionar o Autor -- </option>
              <?php if (count($all_authors > 0)) :
                foreach ($all_authors as $key => $value) :  ?>
                  
                  <option value="<?php echo $value['id']; ?>"> <?php echo $value['name']; ?> </option>
              <?php endforeach;
              endif;
              ?>

            </select>
          </div>

          <div class="form-group">
            <label for="about">Descrição:</label>
            <textarea name="about" required class="form-control" id="about" placeholder="Fale sobre o curso"></textarea>
          </div>

          <div class="form-group">
            <input type="button" class="btn btn-info" value="Upload Imagem" id="btn-upload" />
            <span id="show-image"></span>
            <input type="hidden" id="image_name" name="image_name">
          </div>

          <button type="submit" class="btn btn-success">Enviar</button>
        </form>

      </div>
    </div>
  </div>
</div>