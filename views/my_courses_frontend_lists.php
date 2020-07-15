<!-- Lista de cursos -->
<?php


global $wpdb;
global $user_ID;

$filtros = ['nome' => ''];

if (isset($_GET['filtros'])) {
    $filtros = $_GET['filtros'];
}




$filtrostring = array('1=1');

if (!empty($filtros['name'])) {
    $filtrostring[] = "UPPER(b.name) LIKE " . "UPPER('%" . $filtros['name'] . "%')";
}

if (!empty($filtros['author'])) {
    $filtrostring[] = "UPPER(a.name) LIKE " . "UPPER('%" . $filtros['author'] . "%')";
}

$all_courses = $wpdb->get_results(
    "SELECT b.*, a.name AS author_name FROM " . my_course_table() . " AS b JOIN " . my_authors_table() . " AS a ON b.author = a.id WHERE " . implode(' AND ', $filtrostring),
        
    
    ARRAY_A
);



$student = $wpdb->get_results($wpdb->prepare(
    "SELECT * FROM " . my_students_table() . " WHERE user_login_id = " . get_current_user_id(),
    ""
), ARRAY_A);



?>
<div class="row" style="margin-top:30px;" id="filtra_convenios">

    <form method="GET" style="width:100%;" class="row" action="<?php echo site_url(); ?>/my_course/#filtra_convenios">
        <br>

        <div class="col-md-4">
            <div class="form-group">
                <input type="text" class="form-control" name="filtros[name]" placeholder="Nome" />
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <input type="text" class="form-control" name="filtros[author]" placeholder="Autor" />
            </div>
        </div>

        <div class="col-md-4">
            <button type="submit" class="btn btn-success" id="">Filtrar Busca</button>
        </div>

        <span id="mb_success_message"></span>
    </form>

</div>

<div class="row">



    <?php if (count($all_courses) > 0) :
        foreach ($all_courses as $key => $value) :
    ?>
            <div class="col-md-3 text-center" style="margin-top:20px;margin-bottom:10px;">
                <p><img src="<?php echo $value['course_image']; ?>" style="max-height: 377px;"></p>
                <h5 class="bname"><?php echo $value['name']; ?></h5>
                <p class="bauthor"><?php echo $value['author_name']; ?></p>
                <!-- <p class="babout"><?php echo $value['about']; ?></p>-->


                <?php if ($user_ID > 0) { ?>

                    <a href="javascript:void(0);" class="owt-enrol-btn btn btn-primary enrol-course" course-id="<?php echo $value['id']; ?>">
                        Matricular-se
                    </a>

                <?php } else { ?>

                    <a href="<?php echo wp_login_url(); ?>" class="owt-enrol-btn btn btn-primary">
                        Entre para Matricular-se
                    </a>

                <?php } ?>
                <div class="container" style="height: 30px;"></div>
            </div>
    <?php
        endforeach;
    endif; ?>


</div>