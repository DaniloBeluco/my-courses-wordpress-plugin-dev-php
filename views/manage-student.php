<?php
global $wpdb;
$all_students = $wpdb->get_results(
    $wpdb->prepare("SELECT * FROM " . my_students_table() . " ORDER BY id DESC", ""),
    ARRAY_A
);
?>

<div class="container">
    <br />
    <div class="col-md-12">
        <div class="row">

            <h2>My student list</h2>
            <div class="card">
                <div class="card-header">
                    Estudantes cadastrados
                </div>
                <div class="card-body">
                    <table id="my-course" class="display table table-bordered">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Nome de Usuário</th>
                                <th>Data de Criação</th>
                                <th>Opções</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($all_students) > 0) :
                                $i = 0;
                                foreach ($all_students as $key => $value) :

                                    /* Pega os dados do usuario na tabela wp_users */
                                    $user_details = get_userdata($value['user_login_id']);
                            ?>
                                    <tr>
                                        <td><?php echo $i++ ?></td>
                                        <td><?php echo $value['name'] ?></td>
                                        <td><?php echo $value['email'] ?></td>
                                        <td><?php echo $user_details->user_login; ?></td>
                                        <td><?php echo $value['created_at'] ?></td>
                                        <td><a href="javascript:void(0)" data-id="<?php echo $value['id']; ?>" class="btn btn-danger btnstudentdelete">Deletar</a></td>

                                    </tr>

                            <?php endforeach;
                            endif; ?>

                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>