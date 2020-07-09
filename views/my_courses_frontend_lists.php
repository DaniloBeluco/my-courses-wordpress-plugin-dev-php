<!-- Lista de cursos -->
<?php
global $wpdb;
global $user_ID;
$all_courses = $wpdb->get_results(
    $wpdb->prepare(
        "SELECT b.*, a.name AS author_name FROM " . my_course_table() . " AS b JOIN " . my_authors_table() . " AS a ON b.author = a.id",
        ""
    ),
    ARRAY_A
);



$student = $wpdb->get_results($wpdb->prepare(
    "SELECT * FROM " . my_students_table() . " WHERE user_login_id = " . get_current_user_id(),
    ""
), ARRAY_A);

?>


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