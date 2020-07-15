<?php

/**
 * Plugin Name: My Courses
 * Plugin URI: https://coursespress.com
 * Description: This is the best Course management plugin.
 * Author: Danilo Cardoso Beluco
 * Author URI: https://Coursespress.com
 * Version: 1.0
 */


if (!defined("ABSPATH")) {
    exit;
}

if (!defined("MY_COURSE_PLUGIN_DIR_PATH")) {
    define("MY_COURSE_PLUGIN_DIR_PATH", plugin_dir_path(__FILE__));
}

if (!defined("MY_COURSE_PLUGIN_URL")) {
    define("MY_COURSE_PLUGIN_URL", plugins_url() . "/my-courses");
}




/* -- Assets e Libraries -- */





function my_courses_include_assets()
{

    $slug = '';

    $pages_includes = array("frontendpage", "course-list", "add-new", "edit", "add-author", "remove-author", "add-student", "remove-student", "course-tracker", "my-course");

    $currentPage = $_GET['page'];


    // $_SERVER[REQUEST_URI]

    // $_SERVER[HTTP_HOST]: http://, https://


    /* Se o slug estiver vazio, a pagina atual é do site e nao do wp admin */
    if (empty($currentPage)) {

        /* Pega o link da pagina atual */
        $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        /* Se no final do link for a pagina my_course, atribui ela na variavel */
        if (preg_match("/my_course/", $actual_link)) {
            $currentPage = "frontendpage";
        }
    }

    /* Só vai registrar os assets se estiver em uma página do plugin */
    if (in_array($currentPage, $pages_includes)) {

        wp_enqueue_script("jquery", "https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js");
        wp_enqueue_script("validate", "https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/jquery.validate.min.js");
        

        wp_enqueue_script("bootstrapjs", "https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js");
        wp_enqueue_style("bootstrap", "https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css");

        wp_enqueue_style("datatable", "https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css");
        wp_enqueue_style("datatable2", "http://cdn.datatables.net/plug-ins/e9421181788/integration/bootstrap/3/dataTables.bootstrap.css ");

        wp_enqueue_script("datatable", "http://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js");
        wp_enqueue_script("notify", MY_COURSE_PLUGIN_URL . "/assets/js/jquery.notifyBar.js");
        wp_enqueue_script("script.js", MY_COURSE_PLUGIN_URL . "/assets/js/script.js");
        wp_enqueue_style("style", MY_COURSE_PLUGIN_URL . "/assets/css/style.css");

        // passa um valor php para javascript, no caso a url do ajax
        wp_localize_script("script.js", "mycourseajaxurl", admin_url("admin-ajax.php"));
    }
}

add_action("init", "my_courses_include_assets");






/* -- WP Menus e Submenus -- */





function my_course_plugin_menus()
{
    add_menu_page(
        "Meus Cursos",
        "Meus Cursos",
        "manage_options",
        "course-list",
        "my_course_list",
        "dashicons-book-alt",
        30 // Posição
    );

    add_submenu_page(
        "course-list",
        "Lista de Cursos",
        "Lista de Cursos",
        "manage_options",
        "course-list",
        "my_course_list"
    );

    add_submenu_page(
        "course-list",
        "Adicionar Curso",
        "Adicionar Curso",
        "manage_options",
        "add-new",
        "my_course_add"
    );

    add_submenu_page(
        null,
        "Editar Curso",
        "Editar Curso",
        "manage_options",
        "edit",
        "my_course_edit"
    );

    //my extended submenus

    add_submenu_page("course-list", "Adicionar Autor", "Adicionar Autor", "manage_options", "add-author", "my_author_add");
    add_submenu_page("course-list", "Todos Autores", "Todos Autores", "manage_options", "remove-author", "my_author_remove");
    add_submenu_page("course-list", "Adicionar Estudante", "Adicionar Estudante", "manage_options", "add-student", "my_student_add");
    add_submenu_page("course-list", "Todos Estudantes", "Todos Estudantes", "manage_options", "remove-student", "my_student_remove");
    add_submenu_page("course-list", "Matrículas", "Matrículas", "manage_options", "course-tracker", "course_tracker");
}

add_action("admin_menu", "my_course_plugin_menus");

function my_course_list()
{
    include_once MY_COURSE_PLUGIN_DIR_PATH . "/views/course-list.php";
}

function my_course_add()
{
    include_once MY_COURSE_PLUGIN_DIR_PATH . "/views/course-add.php";
}

function my_course_edit()
{
    include_once MY_COURSE_PLUGIN_DIR_PATH . "/views/course-edit.php";
}

function my_author_add()
{
    include_once MY_COURSE_PLUGIN_DIR_PATH . "/views/author-add.php";
}

function my_author_remove()
{
    include_once MY_COURSE_PLUGIN_DIR_PATH . "/views/manage-author.php";
}

function my_student_add()
{
    include_once MY_COURSE_PLUGIN_DIR_PATH . "/views/student-add.php";
}

function my_student_remove()
{
    include_once MY_COURSE_PLUGIN_DIR_PATH . "/views/manage-student.php";
}

function course_tracker()
{
    include_once MY_COURSE_PLUGIN_DIR_PATH . "/views/course-tracker.php";
}






/* -- Database -- */





/* Retorna o nome da tabela certinho com o prefixo */
function my_course_table()
{

    global $wpdb;
    return $wpdb->prefix . "my_course"; //wp_my_courses

}

function my_authors_table()
{

    global $wpdb;
    return $wpdb->prefix . "my_authors"; //wp_my_authors

}

function my_students_table()
{

    global $wpdb;
    return $wpdb->prefix . "my_students"; //wp_my_students

}

function my_enrol_table()
{

    global $wpdb;
    return $wpdb->prefix . "my_enrol"; //wp_my_enrol

}

/* Função que gera as tabelas */
function my_course_generates_table_script()
{

    global $wpdb;
    require_once ABSPATH . "wp-admin/includes/upgrade.php";

    $sql = "CREATE TABLE " . my_course_table() . " (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(255) DEFAULT NULL,
    `author` varchar(255) DEFAULT NULL,
    `about` text,
    `course_image` text,
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=latin1";

    dbDelta($sql);

    $sql2 = "CREATE TABLE " . my_authors_table() . " (
        `id` int(20) NOT NULL AUTO_INCREMENT,
        `name` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
        `fb_link` text COLLATE utf8mb4_unicode_ci NOT NULL,
        `about` text COLLATE utf8mb4_unicode_ci NOT NULL,
        `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
        PRIMARY KEY (`id`)
       ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

    dbDelta($sql2);

    $sql3 = "CREATE TABLE " . my_students_table() . " (
        `id` int(20) NOT NULL AUTO_INCREMENT,
        `name` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
        `email` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
        `user_login_id` int(20) NOT NULL,
        `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
        PRIMARY KEY (`id`)
       ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

    dbDelta($sql3);


    $sql4 = "CREATE TABLE " . my_enrol_table() . " (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `student_id` int(11) NOT NULL,
    `course_id` int(11) NOT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY (`id`)
   ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";


    dbDelta($sql4);

    /* Adicionar role no wordpress, para uso do usuário dos estudantes */
    add_role("wp_course_user_key", "Usuário MyCourses", [
        "read" => true
    ]);

    /* Criar página, com shortcode no conteúdo */
    $my_post = [
        'post_title' => 'Meus Cursos',
        'post_content' => '[course_page]',
        'post_status' => 'publish',
        'post_type' => 'page',
        'post_name' => 'my_course',
    ];
    /* Inserindo a página no banco */
    $course_id = wp_insert_post($my_post);

    add_option("my_course_page_id", $course_id);
}

register_activation_hook(__FILE__, "my_course_generates_table_script");

function drop_table_plugin_courses()
{

    global $wpdb;
    $wpdb->query("DROP TABLE IF EXISTS " . my_course_table());
    $wpdb->query("DROP TABLE IF EXISTS " . my_authors_table());
    $wpdb->query("DROP TABLE IF EXISTS " . my_students_table());
    $wpdb->query("DROP TABLE IF EXISTS " . my_enrol_table());

    //removendo o role de usuario
    if (get_role("wp_course_user_key")) {
        remove_role("wp_course_user_key");
    }

    //removendo a pagina
    if (!empty(get_option("my_course_page_id"))) {

        $page_id = get_option("my_course_page_id");

        wp_delete_post($page_id, "true");

        delete_option("my_course_page_id");
    }
}

// register_deactivation_hook(__FILE__, "drop_table_plugin_courses");
register_uninstall_hook(__FILE__, "drop_table_plugin_courses");






/* Se houver uma req ajax com action mycourselibrary */

add_action("wp_ajax_mycourselibrary", "my_course_ajax_handler");

function my_course_ajax_handler()
{
    global $wpdb;

    include_once MY_COURSE_PLUGIN_DIR_PATH . '/library/my_course_library.php';

    wp_die();
}







/* Adiciona um Filter ao entrar em cada página */






add_filter("page_template", "owt_custom_page_layout");

/* Se a página atual for a página de livros ele adiciona um template */
function owt_custom_page_layout($page_template)
{
    global $post;
    $page_slug = $post->post_name; //pega o slug da page/post atual

    if ($page_slug == "my_course") {
        $page_template = MY_COURSE_PLUGIN_DIR_PATH . '/views/frontend-courses-template.php';
    }
    return $page_template;
}







/* Adiciona um Filter ao fazer login, clicando em adquirir */




function owt_login_user_role_filter($redirect_to, $request, $user)
{

    global $user; //pega o usuario logado

    if (isset($user->roles) && is_array($user->roles)) { //array que contem o user role

        /* Se o usuario tiver este role */
        if (in_array("wp_course_user_key", $user->roles)) {

            /* redireciona para pagina de livros */
            return $redirect_to = site_url() . "/my_course";
        } else {

            return $redirect_to = site_url() . "/wp-admin";
        }
    }
}

add_filter("login_redirect", "owt_login_user_role_filter", 10, 3);

/* Ao fazer logout, também retorna para a página de livros */
function owt_logout_user_role_filter()
{
    global $user;
    if (isset($user->roles) && is_array($user->roles)) {

        if (in_array("wp_course_user_key", $user->roles)) {
            wp_redirect(site_url() . "/my_course");
            exit();
        }
    }
}

add_filter("wp_logout", "owt_logout_user_role_filter");







/* Shortcodes */






function my_course_page_functions()
{
    include_once MY_COURSE_PLUGIN_DIR_PATH . '/views/my_courses_frontend_lists.php';
}

add_shortcode("course_page", "my_course_page_functions");












/* Includes */




include_once MY_COURSE_PLUGIN_DIR_PATH . '/includes/my-courses-pages-meta.php';
include_once MY_COURSE_PLUGIN_DIR_PATH . '/includes/my-courses-pages-restrict.php';
