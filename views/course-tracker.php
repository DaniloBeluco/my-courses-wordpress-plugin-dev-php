<?php
global $wpdb;
$all_enrols = $wpdb->get_results(
    $wpdb->prepare("SELECT e.id AS id, e.created_at AS created_at, s.name AS student, b.name AS course FROM " . my_enrol_table() . " AS e JOIN " . my_students_table() . " AS s ON e.student_id = s.id JOIN " . my_course_table() . " AS b ON e.course_id = b.id", ""),
    ARRAY_A
);
?>

<div class="container">
    <br />
    <div class="col-md-12">
        <div class="row">

            <h2>My Course Tracker List</h2>
            <div class="card">
                <div class="card-header">
                    Matrículas Feitas
                </div>
                <div class="card-body">
                    <table id="my-course" class="display table table-bordered">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Estudante</th>
                                <th>Curso</th>
                                <th>Data de Criação</th>
                                <th>Opções</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($all_enrols) > 0) :
                                $i = 1;
                                foreach ($all_enrols as $key => $value) : ?>

                                    <tr>
                                        <td><?php echo $i++ ?></td>
                                        <td><?php echo $value['student'] ?></td>
                                        <td><?php echo $value['course'] ?></td>
                                        <td><?php echo $value['created_at'] ?></td>
                                        <td><a href="javascript:void(0)" data-id="<?php echo $value['id']; ?>" class="btn btn-danger btnenroldelete">Excluir</a></td>
                                    </tr>

                            <?php endforeach;
                            endif; ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>