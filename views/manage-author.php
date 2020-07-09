<?php
global $wpdb;
$all_authors = $wpdb->get_results(
    $wpdb->prepare("SELECT * FROM " . my_authors_table() . " ORDER BY id DESC", ""),
    ARRAY_A
);
?>

<div class="container">
    <br />
    <div class="col-md-12">
        <div class="row">

            <h2>My author list</h2>
            <div class="card">
                <div class="card-header">
                    Autores cadastrados
                </div>
                <div class="card-body">
                    <table id="my-course" class="display table table-bordered">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nome</th>
                                <th>Link do Facebook</th>
                                <th>Sobre</th>
                                <th>Data de criação</th>
                                <th>Opções</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $i = 1;
                            if (count($all_authors) > 0) :
                                foreach ($all_authors as $key => $value) :
                            ?>
                                    <tr>

                                        <td><?php echo $i++ ?></td>
                                        <td><?php echo $value['name']; ?></td>
                                        <td><?php echo $value['fb_link']; ?></td>
                                        <td><?php echo $value['about']; ?></td>
                                        <td><?php echo $value['created_at']; ?></td>
                                        <td> 
                                            <a href="javascript:void(0)" data-id="<?php echo $value['id']; ?>" class="btn btn-danger btnauthordelete">Deletar</a></td>

                                    </tr>
                            <?php
                                endforeach;
                            endif; ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>