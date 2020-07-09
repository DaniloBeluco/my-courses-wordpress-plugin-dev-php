<?php

/* -- Ajax ao cadastrar -- */
if ($_REQUEST['param'] == "save_course") {

    // Pega os dados da req, e salva no banco de dados
    $wpdb->insert(my_course_table(), [
        "name" => $_REQUEST['name'],
        "author" => $_REQUEST['author'],
        "about" => $_REQUEST['about'],
        "course_image" => $_REQUEST['image_name']
    ]);
    echo json_encode(array("status" => 1, "message" => "Livro adicionado com sucesso!"));
} else if ($_REQUEST['param'] == "edit_course") {

    $wpdb->update(my_course_table(), [
        "name" => $_REQUEST['name'],
        "author" => $_REQUEST['author'],
        "about" => $_REQUEST['about'],
        "course_image" => $_REQUEST['image_name']
    ], ["id" => $_REQUEST['course_id']]);
    echo json_encode(array("status" => 1, "message" => "Livro editado com sucesso!"));
} else if ($_REQUEST['param'] == "delete_course") {

    $wpdb->delete(my_course_table(), [
        "id" => $_REQUEST['id']
    ]);

    echo json_encode(array("status" => 1, "message" => "Livro deletado com sucesso!"));
} else if ($_REQUEST['param'] == "save_author") {

    // Pega os dados da req, e salva no banco de dados
    $wpdb->insert(my_authors_table(), [
        "name" => $_REQUEST['name'],
        "fb_link" => $_REQUEST['fb-link'],
        "about" => $_REQUEST['about'],
    ]);
    echo json_encode(array("status" => 1, "message" => "Autor adicionado com sucesso!"));
} else if ($_REQUEST['param'] == "delete_author") {

    $wpdb->delete(my_authors_table(), [
        "id" => $_REQUEST['id']
    ]);

    echo json_encode(array("status" => 1, "message" => "Curso deletado com sucesso!"));
} else if ($_REQUEST['param'] == "save_student") {

    /* Chama a função nativa que cria o usuario para o estudante, retorna o id */
    $student_id = $user_id = wp_create_user($_REQUEST['username'], $_REQUEST['password'], $_REQUEST['email']);

    /* Pega o usuario que acabou de ser cadastrado, e atribui o role criado */
    $user = new WP_user($student_id);
    $user->set_role("wp_course_user_key");

    /* para fazer: O username e email não podem repetir */

    // Pega os dados da req, e salva no banco de dados
    $wpdb->insert(my_students_table(), [
        "name" => $_REQUEST['name'],
        "email" => $_REQUEST['email'],
        "user_login_id" => $user_id,
    ]);
    echo json_encode(array("status" => 1, "message" => "Estudante adicionado com sucesso!"));
} else if ($_REQUEST['param'] == "delete_student") {

    $wpdb->delete(my_students_table(), [
        "id" => $_REQUEST['id']
    ]);

    echo json_encode(array("status" => 1, "message" => "Curso deletado com sucesso!"));
} else if ($_REQUEST['param'] == "enrol_course") {

    $student = $wpdb->get_results($wpdb->prepare(
        "SELECT * FROM " . my_students_table() . " WHERE user_login_id = " . get_current_user_id(),
        ""
    ), ARRAY_A);

    $wpdb->insert(
        my_enrol_table(),
        [
            "student_id" =>  $student['0']['id'],
            "course_id" => $_REQUEST['id'],
        ],
    );

    echo json_encode(array("status" => 1, "message" => "Matriculado com Sucesso !!"));
} else if ($_REQUEST['param'] == "delete_enrol") {

    $wpdb->delete(my_enrol_table(), [
        "id" => $_REQUEST['id']
    ]);

    echo json_encode(array("status" => 1, "message" => "Matrícula deletada com sucesso!"));
}
