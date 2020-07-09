<?php


/* Verificação da Página atual, e redirecionamento apenas para o usuário do curso */





/* Verifica se o usuario pode entrar nessa pagina */
function verification()
{
    $acess = "false";

    global $wpdb;
    $user_id = get_current_user_id();

    $all_user_enrol = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT * FROM " . my_enrol_table() . " WHERE student_id = %s",
            "$user_id"
        ),
        ARRAY_A
    );

    /* Se o usuário atual estiver matriculado em algum curso */
    if (count($all_user_enrol) > 0) {

        $all_restrict_meta = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT * FROM " . $wpdb->prefix . "postmeta WHERE meta_key = %s",
                "mc_restrict_page"
            ),
            ARRAY_A
        );


        global $post;
        $post_id = $post->ID;

        if (count($all_restrict_meta) > 0) {

            /* Se esta for uma página de curso */
            foreach ($all_restrict_meta as $key => $value) {
                if ($value['post_id'] == $post_id) {

                    /* Se o usuário estiver matriculado */
                    foreach ($all_user_enrol as $ekey => $evalue) {

                        if ($value['meta_value'] == $evalue['course_id']) {
                            $acess = "true";
                        }
                    }
                }
            }
        }
    }
    return $acess;
}




/* Verifica se a pagina é restrita e faz o redirecionamento */
function verifyPage()
{
    global $wpdb;
    global $post;
    $restrict = false;

    $all_restrict_meta = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT * FROM " . $wpdb->prefix . "postmeta WHERE meta_key = %s",
            "mc_restrict_page"
        ),
        ARRAY_A
    );

    if (count($all_restrict_meta) > 0) {
        foreach ($all_restrict_meta as $key => $value) {
            if ($post->ID == $value['post_id']) {
                $restrict = true;
            }
        }
    }

    if ($restrict == true) {
        if (verification() == "false") {
            header ( "Location: ".site_url());
        }
    }
}

add_action("wp", "verifyPage");