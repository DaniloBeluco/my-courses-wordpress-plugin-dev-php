jQuery(document).ready(function() {
    /* Ao clicar em Matricular-se */
    jQuery(".enrol-course").on("click", function() {
        var course_id = jQuery(this).attr("course-id");
        var postdata = "action=mycourselibrary&param=enrol_course&id=" + course_id;

        jQuery.post(mycourseajaxurl, postdata, function(response) {
            var data = jQuery.parseJSON(response);
            console.log(data.status);
            console.log(data.message);
        });
    });

    /* Ação ao clicar em Deletar Matricula */
    jQuery(".btnenroldelete").on("click", function() {
        var conf = confirm("Deseja mesmo excluir esta matricula ?");
        if (conf) {
            var enrol_id = jQuery(this).attr("data-id");
            var postdata = "action=mycourselibrary&param=delete_enrol&id=" + enrol_id;
            jQuery.post(mycourseajaxurl, postdata, function(response) {
                var data = jQuery.parseJSON(response);
                if (data.status == 1) {
                    jQuery("#mb_success_message").html(
                        "<div class='alert alert-success'>" + data.message + "</div>"
                    );
                    setTimeout(function() {
                            location.reload();
                        }),
                        500;
                } else {}
            });
        }
    });

    /* Ação ao clicar em Fazer Upload da Imagem do curso */
    jQuery("#btn-upload").on("click", function() {
        var image = wp
            .media({
                title: "Upload Image for My Course",
                multiple: false,
            })
            .open()
            .on("select", function() {
                var uploaded_image = image.state().get("selection").first();
                var getImage = uploaded_image.toJSON().url;
                jQuery("#image_name").val(getImage);
                jQuery("#show-image").html(
                    "<img src='" +
                    getImage +
                    "' style='max-height:70px;max-width:70px;'/>"
                );
            });
    });

    /* Ação ao clicar em Cadastrar curso */
    jQuery("#frmAddCourse").validate({
        submitHandler: function() {
            var postdata =
                "action=mycourselibrary&param=save_course&" +
                jQuery("#frmAddCourse").serialize();
            jQuery.post(mycourseajaxurl, postdata, function(response) {
                var data = jQuery.parseJSON(response);
                if (data.status == 1) {
                    jQuery("#mb_success_message").html(
                        "<div class='alert alert-success'>" + data.message + "</div>"
                    );
                } else {}
            });
        },
    });

    /* Ação ao clicar em Editar curso */
    jQuery("#frmEditCourse").validate({
        submitHandler: function() {
            var postdata =
                "action=mycourselibrary&param=edit_course&" +
                jQuery("#frmEditCourse").serialize();
            jQuery.post(mycourseajaxurl, postdata, function(response) {
                var data = jQuery.parseJSON(response);
                if (data.status == 1) {
                    jQuery("#mb_success_message").html(
                        "<div class='alert alert-success'>" + data.message + "</div>"
                    );
                    setTimeout(function() {
                        //window.location.reload();
                        location.reload();
                    }, 1300);
                } else {}
            });
        },
    });

    /* Ação ao clicar em Deletar curso */
    jQuery(".btncoursedelete").on("click", function() {
        var conf = confirm("Deseja mesmo excluir este curso ?");
        if (conf) {
            var course_id = jQuery(this).attr("data-id");
            var postdata =
                "action=mycourselibrary&param=delete_course&id=" + course_id;
            jQuery.post(mycourseajaxurl, postdata, function(response) {
                var data = jQuery.parseJSON(response);
                if (data.status == 1) {
                    jQuery("#mb_success_message").html(
                        "<div class='alert alert-success'>" + data.message + "</div>"
                    );
                    setTimeout(function() {
                            location.reload();
                        }),
                        500;
                } else {}
            });
        }
    });

    /* Traduzindo o DataTables */
    jQuery("#my-course").DataTable({
        language: {
            lengthMenu: "Mostrar _MENU_ resultados por página",
            zeroRecords: "Nenhum resultado encontrado",
            info: "Página <strong> _PAGE_ de _PAGES_ </strong>",
            infoEmpty: "Nenhum resultado encontrado",
            infoFiltered: "(filtered from _MAX_ total records)",
            sSearch: "",
            oPaginate: {
                sFirst: "Primeiro ",
                sLast: " Último",
                sNext: "Próximo ",
                sPrevious: " Anterior",
            },
            searchPlaceholder: "Pesquisar..",
        },
    });

    /* Ao clicar em cadastrar Autor */
    jQuery("#frmAddAuthor").validate({
        submitHandler: function() {
            var postdata =
                "action=mycourselibrary&param=save_author&" +
                jQuery("#frmAddAuthor").serialize();
            jQuery.post(mycourseajaxurl, postdata, function(response) {
                var data = jQuery.parseJSON(response);
                if (data.status == 1) {
                    jQuery("#mb_success_message").html(
                        "<div class='alert alert-success'>" + data.message + "</div>"
                    );
                } else {}
            });
        },
    });

    /* Ação ao clicar em Deletar autor */
    jQuery(".btnauthordelete").on("click", function() {
        var conf = confirm("Deseja mesmo excluir este autor ?");
        if (conf) {
            var author_id = jQuery(this).attr("data-id");
            var postdata =
                "action=mycourselibrary&param=delete_author&id=" + author_id;
            jQuery.post(mycourseajaxurl, postdata, function(response) {
                var data = jQuery.parseJSON(response);
                if (data.status == 1) {
                    jQuery("#mb_success_message").html(
                        "<div class='alert alert-success'>" + data.message + "</div>"
                    );
                    setTimeout(function() {
                            location.reload();
                        }),
                        500;
                } else {}
            });
        }
    });

    /* Ao clicar em cadastrar Estudante */
    jQuery("#frmAddStudent").validate({
        submitHandler: function() {
            var postdata =
                "action=mycourselibrary&param=save_student&" +
                jQuery("#frmAddStudent").serialize();
            jQuery.post(mycourseajaxurl, postdata, function(response) {
                var data = jQuery.parseJSON(response);
                if (data.status == 1) {
                    jQuery("#mb_success_message").html(
                        "<div class='alert alert-success'>" + data.message + "</div>"
                    );
                } else {}
            });
        },
    });

    /* Ação ao clicar em Deletar estudante */
    jQuery(".btnstudentdelete").on("click", function() {
        var conf = confirm("Deseja mesmo excluir este estudante ?");
        if (conf) {
            var student_id = jQuery(this).attr("data-id");
            var postdata =
                "action=mycourselibrary&param=delete_student&id=" + student_id;
            jQuery.post(mycourseajaxurl, postdata, function(response) {
                var data = jQuery.parseJSON(response);
                if (data.status == 1) {
                    jQuery("#mb_success_message").html(
                        "<div class='alert alert-success'>" + data.message + "</div>"
                    );
                    setTimeout(function() {
                            location.reload();
                        }),
                        500;
                } else {}
            });
        }
    });

    /* Ao clicar em Filtrar */
    /* jQuery("#frmFilterCourse").validate({
         submitHandler: function() {
             var postdata =
                 "action=mycourselibrary&param=filter_course&" +
                 jQuery("#frmFilterCourse").serialize();

             jQuery.post(mycourseajaxurl, postdata, function(response) {
                 var data = jQuery.parseJSON(response);
                 if (data.status == 1) {

                 } else {
                     jQuery("#mb_success_message").html(
                         "<div class='alert alert-success'>" + data.message + "</div>"
                     );
                 }
             });
         },
     }); */
});