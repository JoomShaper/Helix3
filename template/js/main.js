/**
* @package Helix3 Framework
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2015 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/
jQuery(function($) {

    var $body = $('body'),
    $wrapper = $('.body-innerwrapper'),
    $toggler = $('#offcanvas-toggler'),
    $close = $('.close-offcanvas'),
    $offCanvas = $('.offcanvas-menu');

    $toggler.on('click', function(event){
        event.preventDefault();
        stopBubble (event);
        setTimeout(offCanvasShow, 50);
    });

    $close.on('click', function(event){
        event.preventDefault();
        offCanvasClose();
    });

    var offCanvasShow = function(){
        $body.addClass('offcanvas');
        $wrapper.on('click',offCanvasClose);
        $close.on('click',offCanvasClose);
        $offCanvas.on('click',stopBubble);

    };

    var offCanvasClose = function(){
        $body.removeClass('offcanvas');
        $wrapper.off('click',offCanvasClose);
        $close.off('click',offCanvasClose);
        $offCanvas.off('click',stopBubble);
    };

    var stopBubble = function (e) {
        e.stopPropagation();
        return true;
    };

    //Mega Menu
    $('.sp-megamenu-wrapper').parent().parent().css('position','static').parent().css('position', 'relative');
    $('.sp-menu-full').each(function(){
        $(this).parent().addClass('menu-justify');
    });

    //Sticky Menu
    $(document).ready(function(){
        $("body.sticky-header").find('#sp-header').sticky({topSpacing:0})
    });

    //Tooltip
    $('[data-toggle="tooltip"]').tooltip();
    
    $(document).on('click', '.sp-rating .star', function(event) {
        event.preventDefault();

        var data = {
            'action':'voting',
            'user_rating' : $(this).data('number'),
            'id' : $(this).closest('.post_rating').attr('id')
        };

        var request = {
                'option' : 'com_ajax',
                'plugin' : 'helix3',
                'data'   : data,
                'format' : 'json'
            };

        $.ajax({
            type   : 'POST',
            data   : request,
            beforeSend: function(){
                $('.post_rating .ajax-loader').show();
            },
            success: function (response) {
                var data = $.parseJSON(response.data);

                $('.post_rating .ajax-loader').hide();

                if (data.status == 'invalid') {
                    $('.post_rating .voting-result').text('You have already rated this entry!').fadeIn('fast');
                }else if(data.status == 'false'){
                    $('.post_rating .voting-result').text('Somethings wrong here, try again!').fadeIn('fast');
                }else if(data.status == 'true'){
                    var rate = data.action;
                    $('.voting-symbol').find('.star').each(function(i) {
                        if (i < rate) {
                           $( ".star" ).eq( -(i+1) ).addClass('active');
                        }
                    });

                    $('.post_rating .voting-result').text('Thank You!').fadeIn('fast');
                }

            },
            error: function(){
                $('.post_rating .ajax-loader').hide();
                $('.post_rating .voting-result').text('Failed to rate, try again!').fadeIn('fast');
            }
        });
    });

});