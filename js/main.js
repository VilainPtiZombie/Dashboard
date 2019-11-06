// Refresh du minichat toutes les 3 secondes
$(document).ready(function(){
    setInterval(function() {
    $("#reload").load(location.href+" #reload>*","");
    }, 3000);
});

/*window.addEventListener('resize', function() {
    linechart.execute();
});
*/
/*
$(document).ready(function () {
    $(window).resize(function(){
        $('div.graph').animate({height: '100px', width: '300px'}, 500);
    });
});*/

/*$(document).ready(function () {
    $(window).resize(function(){
        $('div.graph').css('transform', 'scale(0.85)');
    });
});*/

/*$(document).ready(function(){
    $(function(){

        var windowWidth = $(window).width();
        if (windowWidth < 650)
        {
            $(window).resize(function(){
        $('div.graph').css('transform', 'scale(0.85)');
    });*/
/*            $('div.graph').css('transform', 'scale(0.15)');*/
        /*}
    })

   
 })*/

/*$(document).ready(function(){
    $(function(){
        $(window).resize(function(){

            var windowWidth = $(window).width();
            if (windowWidth < 650)
            {
                $('div.graph').css('transform', 'scale(0.87)').css('padding-left', '-500px');
            }
            if (windowWidth > 650)
            {
                $('div.graph').css('transform', 'scale(1)').css('padding-left', '0');
            }

        })
    })
})*/

// Analytics charts responsiveness (working good)
$(document).ready(function(){
    $(function(){
            var windowWidth = $(window).width();

            if (windowWidth < 650)
            {
                $('div.graph').css('transform', 'scale(0.87)').css({marginLeft: '-7%', marginTop: '-2%'});
            }
            if (windowWidth > 650)
            {
                $('div.graph').css('transform', 'scale(1)').css({marginLeft: 0, marginTop: 0});
            }
    })

    $(function(){
            var windowWidth = $(window).width();

            if (windowWidth < 520)
            {
                $('div.graph').css('transform', 'scale(0.79)').css({marginLeft: '-15%', marginTop: '-5%'});
            }
    })

    $(function(){
            var windowWidth = $(window).width();

            if (windowWidth < 460)
            {
                $('div.graph').css('transform', 'scale(0.7)').css({marginLeft: '-20%', marginTop: '-13%'});
            }
    })

    $(function(){
            var windowWidth = $(window).width();

            if (windowWidth < 420)
            {
                $('div.graph').css('transform', 'scale(0.62)').css({marginLeft: '-23%', marginTop: '-17%'});
            }
    })

    $(function(){
            var windowWidth = $(window).width();

            if (windowWidth < 340)
            {
                $('div.graph').css('transform', 'scale(0.55)').css({marginLeft: '-26%', marginTop: '-25%'});
            }
    })
});

// Analytics charts responsivness on window resizing (working good)
$(document).ready(function(){

    $(function(){
        $(window).resize(function(){

            var windowWidth = $(window).width();

            if (windowWidth < 650)
            {
                $('div.graph').css('transform', 'scale(0.87)').css({marginLeft: '-7%', marginTop: '-2%'});
            }
            if (windowWidth > 650)
            {
                $('div.graph').css('transform', 'scale(1)').css({marginLeft: 0, marginTop: 0});
            }

        })
    })

    $(function(){
        $(window).resize(function(){

            var windowWidth = $(window).width();

            if (windowWidth < 520)
            {
                $('div.graph').css('transform', 'scale(0.79)').css({marginLeft: '-15%', marginTop: '-5%'});
            }
        })
    })

    $(function(){
        $(window).resize(function(){

            var windowWidth = $(window).width();

            if (windowWidth < 460)
            {
                $('div.graph').css('transform', 'scale(0.7)').css({marginLeft: '-20%', marginTop: '-13%'});
            }
        })
    })

    $(function(){
        $(window).resize(function(){

            var windowWidth = $(window).width();

            if (windowWidth < 420)
            {
                $('div.graph').css('transform', 'scale(0.62)').css({marginLeft: '-23%', marginTop: '-17%'});
            }
        })
    })

    $(function(){
        $(window).resize(function(){

            var windowWidth = $(window).width();

            if (windowWidth < 340)
            {
                $('div.graph').css('transform', 'scale(0.55)').css({marginLeft: '-26%', marginTop: '-25%'});
            }
        })
    })
})


// Fonction de recherche
$(document).ready(function(){

    // TABLE SERVEURS
  $("#servSearch").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#servTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });

  // TABLE UTILISATEURS
  $("#userSearch").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#userTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });


});


// Boutons '.updates_values' (tout en bas page backend)
$(document).ready(function(){
    $(function(){
        $('#btn_pass_update').click(function(){
                if ($('#pass_update').hasClass('active')){}
                else {
                    $('.update_values').removeClass('active', 400);
                    $('section#pass_update').toggleClass('active', 400);
                };
            });

            $('#btn_update_user_info').click(function(){
                if ($('#update_user_info').hasClass('active')){}
                else {
                $('.update_values').removeClass('active', 400);
                $('section#update_user_info').toggleClass('active', 400);
                };
            });
            $('#btn_alert_creator').click(function(){
                if ($('#alert_creator').hasClass('active')){}
                else {
                $('.update_values').removeClass('active', 400);
                $('#alert_creator').toggleClass('active', 400);
                };
            });
            $('#btn_update_contacts').click(function(){
                if ($('#update_contacts').hasClass('active')){}
                else {
                $('.update_values').removeClass('active', 400);
                $('#update_contacts').toggleClass('active', 400);
                };
            });
            $('#btn_add_analytics').click(function(){
                if ($('#add_analytics').hasClass('active')){}
                else {
                $('.update_values').removeClass('active', 400);
                $('#add_analytics').toggleClass('active', 400);
                };
            });
    });
});


// ===== ANIMATED / MOBILE MENU
$(document).ready(function(){
$(function() {

    var clicked = false;

    $("div#mobile_menu").click(function(event){
    clicked = !clicked;
    if(clicked)
    {
            $('#menu_section').animate({height: "400px", overflow: "visible", top: '90px'}, 850);
            $('#menu_section h2').css('display', 'none');
            $('#menu_icon').animate({top: "420px", left: "50px"}, 800);

    }
    else
    {
            $('#menu_section').animate({height: "0", overflow: "hidden"}, 850);
            $('#menu_icon').animate({top: "15px", left: "15px"}, 900);

    }
});
});
});


// Permet de colorer les champs "done" de la table "membres" affichés sur page accueil et page backend
$(document).ready(function(){
if ($('input[name=checked][value=DONE]')) {
    $('input[name=checked][value=DONE]').closest('div').addClass('done');
}

if ($('input[name=checked_2][value=DONE]')) {
    $('input[name=checked_2][value=DONE').closest('div tr').addClass('done_table');
}

if ($('input[name=checked][value=NO]')) {
    $('input[name=checked][value=NO]').closest('div').addClass('undone');
}

if ($('input[name=checked_2][value=NO]')) {
    $('input[name=checked_2][value=NO]').closest('div tr').addClass('undone_table');
}
});
