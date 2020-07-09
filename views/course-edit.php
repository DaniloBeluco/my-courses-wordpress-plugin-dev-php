<?php
/* Vamos usar a biblioteca de mídia para carregar a imagem */
wp_enqueue_media();

/* Pega os dados deste lovro no banco */
$course_id = isset($_GET['edit']) ? intval($_GET['edit']) : 0;

global $wpdb;
$course_detail = $wpdb->get_row(
  $wpdb->prepare(
    "SELECT * FROM " . my_course_table() . " WHERE id = %d",
    $course_id
  ),
  ARRAY_A
);


$all_authors = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . my_authors_table() . " ORDER BY id DESC"), ARRAY_A);


?>
<div class="container"><br />
  <div class="row">
    <div class="alert alert-info">
      <h4>Book Add Page</h4>
    </div>
    <div class="card">
      <div class="card-header">
        Editar curso
      </div>
      <div class="card-body">
        <span id="mb_success_message"></span>
        <form action="javascript:void(0)" id="frmEditCourse">
          <input type="hidden" name="course_id" value="<?php echo isset($_GET['edit']) ? intval($_GET['edit']) : 0; ?>">
          <div class="form-group">
            <label for="name">Nome:</label>
            <input value="<?php echo $course_detail['name']; ?>" type="text" name="name" required class="form-control" id="name" placeholder="Entre com o nome do curso">
          </div>

          <div class="form-group">
            <label for="author">Autor:</label>
            <select name="author" id="author" class="form-control">
            <option value=""> -- Selecionar o Autor -- </option>
              <?php if (count($all_authors > 0)) :
                foreach ($all_authors as $key => $value) :  ?>
                  <option <?php if($value['id'] == $course_detail['author']){ echo "selected='selected'"; } else {} ?> value="<?php echo $value['id']; ?>"> <?php echo $value['name']; ?> </option>
              <?php endforeach;
              endif;
              ?>

            </select>
          </div>

          <div class="form-group">
            <label for="about">Descrição:</label>
            <textarea name="about" required class="form-control" id="about" placeholder="Fale sobre o curso"><?php echo $course_detail['about']; ?></textarea>
          </div>

          <div class="form-group">
            <input type="button" class="btn btn-info" value="Upload Imagem" id="btn-upload" />
            <span id="show-image">
              <image src="<?php echo $course_detail['course_image']; ?>" style="max-width:70px;max-height:70px;" />
            </span>
            <input value="<?php echo $course_detail['course_image']; ?>" type="hidden" id="image_name" name="image_name">
          </div>

          <button type="submit" class="btn btn-success">Editar</button>
        </form>
      </div>
    </div>
  </div>
</div>