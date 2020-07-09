<?php

/*
 * Template Name: Front end course page layout
 */

get_header(); //header.php
?>

<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <!--<div class="alert alert-success" style="background-color:white;">
                <h3>Cursos</h3>
            </div>-->

            <?php
            echo do_shortcode("[course_page]");
            ?>

        </div>
    </div>
</div>

<?php
get_footer(); //footer.php
?>