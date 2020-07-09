<?php

function my_courses_register_metabox()
{

    add_meta_box("mc-page-id", "Página do Curso", "mc_pages_function", "page", "side", "high");
}

add_action("add_meta_boxes", "my_courses_register_metabox");


function mc_pages_function($post)
{
    wp_nonce_field(basename(__FILE__), "mc_page_nonce");

    global $wpdb;
    $course_id = get_post_meta($post->ID, "mc_restrict_page", true);

    $all_courses = $wpdb->get_results(
        $wpdb->prepare("SELECT * FROM " . my_course_table() . " ORDER BY id DESC", ""),
        ARRAY_A
    );

?>
    <label for="mc_courses"></label>

    <select class="form-control" name="page_course" id="mc_courses">
        <option value="0">Selecione o curso</option>

        <?php if (count($all_courses) > 0) :
            foreach ($all_courses as $key => $value) :  ?>

                <option <?php if ($value['id'] == $course_id) {
                            echo "selected='selected'";
                        } else {
                            echo "";
                        } ?> value="<?php echo $value['id'];  ?>"><?php echo $value['name'];  ?></option>

        <?php endforeach;
        endif;   ?>

    </select>


<?php
}






add_action("save_post", "mc_save_course_page", 10, 2);

function mc_save_course_page($post_id, $post)
{

    /* verificações */
    if (!isset($_POST['mc_page_nonce']) || !wp_verify_nonce($_POST['mc_page_nonce'], basename(__FILE__))) {
        return $post_id;
    }



    /* se foi enviado certinho */
    if (isset($_POST['page_course'])) {
        $course = sanitize_text_field($_POST['page_course']);
        if ($course == 0) {
            return;
        }
    } else {
        $course = "";
    }

    update_post_meta($post_id, "mc_restrict_page", $course);
}
