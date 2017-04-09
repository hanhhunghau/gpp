///<reference path="jquery-1.3.2-vsdoc2.js" />
/*
Copyright (c) 2009 Mikael Söderström.
Contact: vimpyboy@msn.com

Feel free to use this script as long as you don't remove this comment.
*/

(function(jQuery) {
    var isLoaded;
    var isClosed;

    jQuery.fn.Ribbon = function(ribbonSettings) {
        var settings = jQuery.extend({ theme: 'windows7' }, ribbonSettings || {});

        jQuery('.ribbon a').each(function() {
            if (jQuery(this).attr('accesskey')) {
                jQuery(this).append('<div rel="accesskeyhelper" style="display: none; position: absolute; background-image: url(images/accessbg.png); background-repeat: none; width: 16px; padding: 0px; text-align: center; height: 17px; line-height: 17px; top: ' + jQuery(this).offset().top + 'px; left: ' + (jQuery(this).offset().left + jQuery(this).width() - 15) + 'px;">' + jQuery(this).attr('accesskey') + '</div>');
            }
        });

        jQuery('head').append('<link href="assets/css/ribbon/themes/' + settings.theme + '/ribbon.css" rel="stylesheet" type="text/css" />" />');

        if (!isLoaded) {
            SetupMenu(settings);
        }

        jQuery(document).keydown(function(e) { ShowAccessKeys(e); });
        jQuery(document).keyup(function(e) { HideAccessKeys(e); });

        function SetupMenu(settings) {
			console.log(settings.activeId);
			if (settings.activeId === undefined) {
				jQuery('.ribbonmenu li a:first').addClass('ribbonactive');
			}
			else {
				jQuery(jQuery('.ribbonmenu>li>a')[settings.activeId]).addClass('ribbonactive');
				ShowSubMenu(jQuery('.ribbonmenu>li>a')[settings.activeId]);
			}
            jQuery('.ribbonmenu li ul').hide();
			if (settings.activeId === undefined) {
				jQuery('.ribbonmenu li a:first').parent().children('ul:first').show();
			}
			else
			{
				jQuery(jQuery('.ribbonmenu > li > a')[settings.activeId]).parent().children('ul:first').show();
			}
            jQuery('.ribbonmenu li a:first').parent().children('ul:first').addClass('submenu');
            jQuery('.ribbonmenu li > a').click(function() { ShowSubMenu(this); });
            jQuery('.orb').click(function() { ShowMenu(); });
            jQuery('.orb ul').hide();
            jQuery('.orb ul ul').hide();
            jQuery('.orb li ul li ul').show();
            jQuery('.orb li li ul').each(function() { jQuery(this).prepend('<div style="background-color: #EBF2F7; height: 25px; line-height: 25px; width: 292px; padding-left: 9px; border-bottom: 1px solid #CFDBEB;">' + jQuery(this).parent().children('a:first').text() + '</div>'); });
            jQuery('.orb li li a').each(function() { if (jQuery(this).parent().children('ul').length > 0) { jQuery(this).addClass('arrow') } });

            //jQuery('.ribbon-list div').each(function() { jQuery(this).parent().width(jQuery(this).parent().width()); });

            jQuery('.ribbon-list div').click(function(e) {
				var v = jQuery(this).find("ul:first").is(":visible");
                var elwidth = jQuery(this).parent().width();
                var insideX = e.pageX > jQuery(this).offset().left && e.pageX < jQuery(this).offset().left + jQuery(this).width();
                var insideY = e.pageY > jQuery(this).offset().top && e.pageY < jQuery(this).offset().top + jQuery(this).height();

                jQuery('.ribbon-list div ul').fadeOut('fast');
				if (!v) {
					if (insideX && insideY) {
						//jQuery(this).attr('style', 'background-image: ' + jQuery(this).css('background-image'));

						jQuery(this).parent().width(elwidth);

						jQuery(this).children('ul').width(elwidth - 4);
						jQuery(this).children('ul').fadeIn('fast');
					}
                } 
            });

            jQuery('.ribbon-list div').parents().click(function(e) {
                /*var outsideX = e.pageX < jQuery('.ribbon-list div ul:visible').parent().offset().left || e.pageX > jQuery('.ribbon-list div ul:visible').parent().offset().left + jQuery('.ribbon-list div ul:visible').parent().width();
				
                var outsideY = e.pageY < jQuery('.ribbon-list div ul:visible').parent().offset().top || e.pageY > jQuery('.ribbon-list div ul:visible').parent().offset().top + jQuery('.ribbon-list div ul:visible').parent().height();

                if (outsideX || outsideY) {
                    jQuery('.ribbon-list div ul:visible').each(function() {
                        jQuery(this).fadeOut('fast');
                    });
                    jQuery('.ribbon-list div').css('background-image', '');
                }*/
            });

            jQuery('.orb li li a').mouseover(function() { ShowOrbChildren(this); });

            jQuery('.ribbonmenu li > a').dblclick(function() {
                jQuery('ul .submenu').animate({ height: "hide" });
                jQuery('body').animate({ paddingTop: jQuery(this).parent().parent().parent().parent().height() });
                isClosed = true;
            });
        }

        jQuery('.ribbon').parents().click(function(e) {
            var outsideX = e.pageX < jQuery('.orb ul:first').offset().left || e.pageX > jQuery('.orb ul:first').offset().left + jQuery('.orb ul:first').width();
            var outsideY = e.pageY < jQuery('.orb ul:first img:first').offset().top || e.pageY > jQuery('.orb ul:first').offset().top + jQuery('.orb ul:first').height();

            if (outsideX || outsideY)
                jQuery('.orb ul').fadeOut('fast');
        });

        if (isLoaded) {
            jQuery('.orb li:first ul:first img:first').remove();
            jQuery('.orb li:first ul:first img:last').remove();
            jQuery('.ribbon-list div img[src*="/images/arrow_down.png"]').remove();
        }

        jQuery('.orb li:first ul:first').prepend('<img src="assets/css/ribbon/themes/' + settings.theme + '/images/menu_top.png" style="margin-left: -10px; margin-top: -22px;" />');
        jQuery('.orb li:first ul:first').append('<img src="assets/css/ribbon/themes/' + settings.theme + '/images/menu_bottom.png" style="margin-left: -10px; margin-bottom: -22px;" />');

        jQuery('.ribbon-list div').each(function() { if (jQuery(this).children('ul').length > 0) { jQuery(this).append('<img src="assets/css/ribbon/themes/' + settings.theme + '/images/arrow_down.png" style="float: right; margin-top: 5px;" />') } });

        //Hack for IE 7.
        if (navigator.appVersion.indexOf('MSIE 6.0') > -1 || navigator.appVersion.indexOf('MSIE 7.0') > -1) {
            jQuery('ul.ribbonmenu li li div').css('width', '90px');
            jQuery('ul.ribbonmenu').css('width', '500px');
            jQuery('ul.ribbonmenu').css('float', 'left');
            jQuery('ul.ribbonmenu .submenu li div.ribbon-list').css('width', '100px');
            jQuery('ul.ribbonmenu .submenu li div.ribbon-list div').css('width', '100px');
        }

        jQuery('a[href=' + window.location.hash + ']').click();

        isLoaded = true;

        function ResetSubMenu() {
            jQuery('.ribbonmenu li a').removeClass('ribbonactive');
            jQuery('.ribbonmenu ul').removeClass('submenu');
            jQuery('.ribbonmenu li ul').hide();
        }

        function ShowSubMenu(e) {
            var isActive = jQuery(e).next().css('display') == 'block';
            ResetSubMenu();

            jQuery(e).addClass('ribbonactive');
            jQuery(e).parent().children('ul:first').addClass('submenu');

            jQuery(e).parent().children('ul:first').show();
            //jQuery('body').css('padding-top', '0px');

            isClosed = false;
        }

        function ShowOrbChildren(e) {
            if ((jQuery(e).parent().children('ul').css('display') == 'none' || jQuery(e).parent().children('ul').length == 0) && jQuery(e).parent().parent().parent().parent().hasClass('orb')) {
                jQuery('.orb li li ul').fadeOut('fast');
                jQuery(e).parent().children('ul').fadeIn('fast');
            }
        }

        function ShowMenu() {
            jQuery('.orb ul').animate({ opacity: 'toggle' }, 'fast');
        }

        function ShowAccessKeys(e) {
            if (e.altKey) {
                jQuery('div[rel="accesskeyhelper"]').each(function() { jQuery(this).css('top', jQuery(this).parent().offset().top).css('left', jQuery(this).parent().offset().left - 20 + jQuery(this).parent().width()); jQuery(this).show(); });
            }
        }

        function HideAccessKeys(e) {
            jQuery('div[rel="accesskeyhelper"]').hide();
        }
    }
})(jQuery);