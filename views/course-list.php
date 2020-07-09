<?php
global $wpdb;
$all_courses = $wpdb->get_results(
    $wpdb->prepare("SELECT * FROM " . my_course_table() . " ORDER BY id DESC", ""),
    ARRAY_A
);
?>

<div class="container">
    <br />
    <div class="col-md-12">
        <div class="row">

                <h2>Books List</h2>
            <div class="card">
                <div class="card-header">
                    Meus cursos cadastrados
                </div>
                <div class="card-body">
                    <table id="my-course" class="display table table-bordered">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Autor</th>
                                <th>Sobre</th>
                                <th>Imagem</th>
                                <th>Data de criação</th>
                                <th>Opções</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php if (count($all_courses) > 0) :

                                foreach ($all_courses as $key => $value) : ?>
                                    <tr>
                                        <td><?php echo $value['name']; ?></td>
                                        <td><?php echo $value['author']; ?></td>
                                        <td><?php echo $value['about']; ?></td>
                                        <td> <img src="<?php echo $value['course_image']; ?>" style="width:40px;height:40px;"></td>
                                        <td><?php echo $value['created_at']; ?></td>
                                        <td>
                                            <a href="admin.php?page=edit&edit=<?php echo $value['id']; ?>" class="btn btn-info btncourseedit">Editar</a>
                                            <a href="javascript:void(0)" data-id="<?php echo $value['id']; ?>" class="btn btn-danger btncoursedelete">Deletar</a>

                                        </td>
                                    </tr>

                            <?php endforeach;

                            endif; ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>