// Hello.
//
// This is The Scripts used for ___________ Theme
//
//

function main() {

(function () {
   'use strict';

   /* ==============================================
  	Testimonial Slider
  	=============================================== */ 

  	$('a.page-scroll').click(function() {
        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
          var target = $(this.hash);
          target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
          if (target.length) {
            $('html,body').animate({
              scrollTop: target.offset().top - 40
            }, 900);
            return false;
          }
        }
      });

    /*====================================
    Show Menu on Book
    ======================================*/
    $(window).bind('scroll', function() {
        var navHeight = $(window).height() - 100;
        if ($(window).scrollTop() > navHeight) {
            $('.navbar-default').addClass('on');
        } else {
            $('.navbar-default').removeClass('on');
        }
    });

    $('body').scrollspy({ 
        target: '.navbar-default',
        offset: 80
    });

  	$(document).ready(function() {

        $('[data-toggle="popover"]').popover();

        $( "#member-login-button").click( function() {
            $('#login-form').toggle().insertAfter('.container-fluid');
            $('#login-form').css({
                'position' : 'fixed'
            });
        });


        $('#close-button').click( function() {
            $('#login-form').hide();
        });


        $(document).mouseup(function (e)
        {
            var container = $("#login-form");
            var button = $("#member-login-button");

            if ( !container.is(e.target) && container.has(e.target).length === 0 )  {
                container.hide();
            }
        });

        $(".course_remove").click( function() {
            $.post( '/php/doRemoveCoursefromCart.php' , {
                course_id : this.value,
                csrf_token : this.name
            });
            this.closest('tr').remove();
        });

  	  $("#team").owlCarousel({
  	 
  	      navigation : false, // Show next and prev buttons
  	      slideSpeed : 300,
  	      paginationSpeed : 400,
  	      autoHeight : true,
  	      itemsCustom : [
				        [0, 1],
				        [450, 2],
				        [600, 2],
				        [700, 2],
				        [1000, 4],
				        [1200, 4],
				        [1400, 4],
				        [1600, 4]
				      ],
  	  });

  	  $("#clients").owlCarousel({
  	 
  	      navigation : false, // Show next and prev buttons
  	      slideSpeed : 300,
  	      paginationSpeed : 400,
  	      autoHeight : true,
  	      itemsCustom : [
				        [0, 1],
				        [450, 2],
				        [600, 2],
				        [700, 2],
				        [1000, 4],
				        [1200, 5],
				        [1400, 5],
				        [1600, 5]
				      ],
  	  });

        $("#service").owlCarousel({

            navigation : false, // Show next and prev buttons
            slideSpeed : 300,
            paginationSpeed : 400,
            autoHeight : true,
            itemsCustom : [
                [0, 1],
                [450, 2],
                [600, 2],
                [700, 2],
                [1000, 4],
                [1200, 5],
                [1400, 5],
                [1600, 5]
            ],
        });

      $("#partner").owlCarousel({
        navigation : false, // Show next and prev buttons
        slideSpeed : 300,
        paginationSpeed : 400,
        singleItem:true
        });

        function showHide(d)
        {
            alert('clicked');
            var onediv = document.getElementById(d);
            var divs=['content1','content2','content3'];
            for (var i=0;i<divs.length;i++)
            {
                if (onediv != document.getElementById(divs[i]))
                {
                    document.getElementById(divs[i]).style.display='none';
                }
            }
            onediv.style.display = 'block';
        }


        $(function stay() {
            $('ul.menu li a').click(function () {
                $('ul.menu li a').removeClass('selected');
                $(this).addClass('selected');

            });
        });


    });

  	/*====================================
    Portfolio Isotope Filter
    ======================================*/
    $(window).load(function() {
        var $container = $('#lightbox');
        $container.isotope({
            filter: '*',
            animationOptions: {
                duration: 750,
                easing: 'linear',
                queue: false
            }
        });
        $('.cat a').click(function() {
            $('.cat .active').removeClass('active');
            $(this).addClass('active');
            var selector = $(this).attr('data-filter');
            $container.isotope({
                filter: selector,
                animationOptions: {
                    duration: 750,
                    easing: 'linear',
                    queue: false
                }
            });
            return false;
        });

    });



}());


}
main();