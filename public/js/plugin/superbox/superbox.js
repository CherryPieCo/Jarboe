/*
    SuperBox v1.0.0 (modified by bootstraphunter.com)
    by Todd Motto: http://www.toddmotto.com
    Latest version: https://github.com/toddmotto/superbox
    
    Copyright 2013 Todd Motto
    Licensed under the MIT license
    http://www.opensource.org/licenses/mit-license.php

    SuperBox, the lightbox reimagined. Fully responsive HTML5 image galleries.
    
    ::enh be me
*/
;(function($) {
        
    $.fn.SuperBox = function(options) {
        
        var superbox      = $('<div class="superbox-show"></div>');
        var superboximg   = $('<img src="" class="superbox-current-img"><div id="imgInfoBox" class="superbox-imageinfo inline-block"> <h1>Image Title</h1><span style="display:inline;margin:0;"><form class="smart-form"></form><p class="well" style="  overflow: auto;padding: 20px 8px 8px;margin: 0px;"><a href="javascript:void(0);" onclick="Superbox.saveImageInfo(this);" class="btn btn-success btn-sm pull-right j-btn-save">Сохранить</a> <a href="javascript:void(0);" onclick="Superbox.selectImage(this);" class="btn btn-primary btn-sm pull-right j-btn-save"style="margin-right: 6px;">Выбрать</a> <a href="javascript:void(0);" onclick="Superbox.deleteImage(this);" class="btn btn-danger btn-sm pull-left j-btn-del">Удалить</a></p></span> </div>');
        var superboxclose = $('<div class="superbox-close txt-color-white"><i class="fa fa-times fa-lg"></i></div>');
        
        superbox.append(superboximg).append(superboxclose);
        
        var imgInfoBox = $('.superbox-imageinfo');
        $('.superbox-list').unbind("click");
        
        return this.each(function() {
            
            $('.superbox-list').click(function() {
                $this = $(this);
        
                var currentimg = $this.find('.superbox-img');
                var imgData = currentimg.data('img');
                var info = currentimg.data('info') ? JSON.parse(currentimg.data('info').replace(/~/g, '"')) : {};
                console.table(info);
                var imgTitle = '#'+ currentimg.data('id') +': '+ currentimg.attr('title');
                    
                superboximg.find('.j-btn-del').data('id', currentimg.data('id'));
                superboximg.find('.j-btn-save').data('id', currentimg.data('id'));
                //console.log(imgData, imgDescription, imgLink, imgTitle)
                    
                superboximg.attr('src', imgData);
                
                $('.superbox-list').removeClass('active');
                $this.addClass('active');
                
                //$('#imgInfoBox em').text(imgLink);
                //$('#imgInfoBox >:first-child').text(imgTitle);
                //$('#imgInfoBox .superbox-img-description').text(imgDescription);
                
                //superboximg.find('em').text(imgLink);
                superboximg.find('>:first-child').text(imgTitle);
                
                var formContent = '<fieldset>';
                $.each(Superbox.fields.image, function(name, value) {
                    var fieldValue = typeof info[name] == 'undefined' ? '' : info[name];
                    formContent += '<section><label class="label">'+ value.caption +'</label><label class="input">';
                    formContent += '<input class="input-xs" name="'+ name +'" value="'+ fieldValue +'">';
                    formContent += '</label></section>';
                });
                formContent += '</fieldset>';
                
                superboximg.find('.smart-form').html(formContent);
                //superboximg.find('.superbox-img-description').text(imgDescription);
                
                //console.log("fierd")
                
                if($('.superbox-current-img').css('opacity') == 0) {
                    $('.superbox-current-img').animate({opacity: 1});
                }
                
                if ($(this).next().hasClass('superbox-show')) {
                    $('.superbox-list').removeClass('active');
                    superbox.toggle();
                } else {
                    superbox.insertAfter(this).css('display', 'block');
                    $this.addClass('active');
                }
                
                $('html, body').animate({
                    scrollTop:superbox.position().top - currentimg.width()
                }, 'medium');
            
            });
                        
            $('.superbox').on('click', '.superbox-close', function() {
                $('.superbox-list').removeClass('active');
                $('.superbox-current-img').animate({opacity: 0}, 200, function() {
                    $('.superbox-show').slideUp();
                });
            });
            
        });
    };
})(jQuery);