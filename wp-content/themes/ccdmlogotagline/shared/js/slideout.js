jQuery(function( $ ){

  $( '.nav-primary' ).prepend( '<h3 class="slideout-menu"><span class="slideout-menu-toggle">close x</span></h3>'); 
  $( '.nav-secondary' ).prepend( '<h3 class="slideout-menu"><span class="slideout-menu-toggle-two">close x</span></h3>'); 
 
    // Show/hide the navigation
    $('.slideout-menu-toggle').click(function(e){

        e.preventDefault();

        var slideoutMenuParent = $('.site-container');
        var slideoutMenu = $('.nav-primary');
        var slideoutMenuWidth = slideoutMenu.width();
        var dropdown = $('.genesis-nav-menu li');


        slideoutMenu.toggleClass("open");

        if(slideoutMenu.hasClass("open")){
            slideoutMenuParent.addClass('isopen');
            slideoutMenu.addClass('isopen');
        }

        else{
            slideoutMenu.removeClass('isopen');
            slideoutMenuParent.removeClass('isopen');
        }

        if(dropdown.hasClass('active')){
            dropdown.removeClass('active');
            $('.sub-menu').slideUp('normal');
        }

    });

    // Show/hide the navigation
    $('.slideout-menu-toggle-two').click(function(e){

        e.preventDefault();

        var slideoutMenuParent = $('.site-container');
        var slideoutMenu = $('.nav-secondary');
        var slideoutMenuWidth = slideoutMenu.width();
        var dropdown = $('.genesis-nav-menu li');


        slideoutMenu.toggleClass("open");

        if(slideoutMenu.hasClass("open")){
            slideoutMenuParent.addClass('isopen');
            slideoutMenu.addClass('isopen');
        }

        else{
            slideoutMenu.removeClass('isopen');
            slideoutMenuParent.removeClass('isopen');
        }

        if(dropdown.hasClass('active')){
            dropdown.removeClass('active');
            $('.sub-menu').slideUp('normal');
        }

    });    

   
   $('.sub-item').click(function(e) {
            //var previous = $(this).prev();
            //console.log($(this).prev().hasClass('sub'));
            // console.log('test');
            e.preventDefault();
            
            var checkElement = $(this).next();

            $('.genesis-nav-menu li').removeClass('active');
            $(this).closest('li').addClass('active');   

            if((checkElement.is('ul')) && (checkElement.is(':visible'))) {
                $(this).closest('li').removeClass('active');
                checkElement.slideUp('normal');
            }

            if((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
               //$('.nav-primary ul ul:visible').slideUp('normal');
                checkElement.slideDown('normal');
            }

            if (checkElement.is('ul')) {
                return false;
            } else {
                return true;    
            }
          
          
        });

});
