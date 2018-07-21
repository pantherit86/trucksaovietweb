 (function ($) {
	"use strict";
    /** PANEL FUNCTION **/
    var colorSetting = '';
    var defaultSetting = '';
    var timeout = 0;
    var html = '';
    var clickOutSite = false;

    function panel_setting() {
        $.ajax({
            type: "GET",
            url: inwaveCfg.baseUrl + '/wp-content/themes/motohero/assets/css/color.css',
            dataType: "html",
            success: function (result) {
                colorSetting = result;
            }
        });
        $('.color-setting button').each(function () {
            if (this.value[0] == '#') {
                $(this).css('background-color', this.value);
            } else {
                $(this).css('background', 'url(' + this.value + ')');
            }
        });
        $('body').append('<style type="text/css" id="color-setting"></style>');
        panelBindEvents();
        panelLoadSetting();
    }

    function panelBindEvents() {
        var clickOutSite = true;
        $('.panel-button').click(function () {
            if (!$(this).hasClass('active')) {
                $(this).addClass('active');
                $('.panel-content').show().animate({
                    'margin-left': 0
                }, 400, 'easeInOutExpo');
            } else {
                $(this).removeClass('active');
                $('.panel-content').animate({
                    'margin-left': '-240px'
                }, 400, 'easeInOutExpo', function () {
                    $('.panel-content').hide();
                });
            }
            clickOutSite = false;
            //setTimeout(function () {
            //    clickOutSite = true;
            //}, 100);
        });
        $('.panel-content').click(function () {
            clickOutSite = false;
            setTimeout(function () {
                clickOutSite = true;
            }, 100);
        });
        $(document).click(function () {
            if (clickOutSite && $('.panel-button').hasClass('active')) {
               $('.panel-button').trigger('click');
            }
        });

        $('.button-command-layout').click(function () {
            if (!$(this).hasClass('active')) {
                $('.button-command-layout').removeClass('active');
                $(this).addClass('active');
                panelAddOverlay();
                panelWriteSetting();
                $(window).resize();
            }
        });
        $('.button-command-style').click(function () {
            if (!$(this).hasClass('active')) {
                $('.button-command-style').removeClass('active');
                $(this).addClass('active');
                if ($(this).hasClass('dark')) {
                    $('body').addClass('index-dark');
                    $('head').append('<link id="theme-dark-css" rel="stylesheet" type="text/css" href="' + inwaveCfg.baseUrl + '/wp-content/themes/motohero/css/dark.css' + '">');
                } else {
                    $('body').removeClass('index-dark');
                    $('#theme-dark-css').remove();
                }
                $('body').addClass('active');
                panelWriteSetting();
            }
        });
        $('.background-setting button').click(function () {
            if ($('.button-command-layout.active').val() == 'wide') {
                return;
            }
            if (!$(this).hasClass('active')) {
                $('.background-setting button').removeClass('active');
                $(this).addClass('active');
                if (this.value[0] == '#') {
                    $('body').css('background', this.value);
                } else {
                    $('body').css('background', 'url(' + this.value + ')');
                }
                panelWriteSetting();
            }
        });
        $('.sample-setting button').click(function () {
            if (!$(this).hasClass('active')) {
                $('.sample-setting button').removeClass('active');
                $(this).addClass('active');
                var newColorSetting = colorSetting.replace(/#009fd7/g, this.value);
                $('#color-setting').html(newColorSetting);
                panelWriteSetting();
            }
        });
        $('.reset-button button').click(function () {
            panelApplySetting(defaultSetting);
            setCookie('motohero-setting', '');
            if ($('.rtl-setting .active').attr('data-value') == 'rtl') {
                var link;
                if (document.location.href.indexOf('=rtl') > 0) {
                    link = document.location.href.replace(/=rtl/, '=ltr')
                } else {
                    if (document.location.href.indexOf('&') > 0) {
                        link = document.location.href + '&d=ltr';
                    } else {
                        link = document.location.href + '?d=ltr';
                    }
                }
                document.location.href = link;
            }
        });
    }

    function panelAddOverlay() {
        if ($('.button-command-layout.active').hasClass('boxed')) {
            $('.overlay-setting').removeClass('disabled');
            $('body').addClass('body-boxed');
        } else {
            $('.overlay-setting').addClass('disabled');
            $('body').removeClass('body-boxed');
        }
    }

    function panelLoadSetting() {
        // remember default setting
        defaultSetting = getCookie('motohero-setting-default');
        if (defaultSetting) {
            defaultSetting = JSON.parse(defaultSetting);
        } else {
            defaultSetting = {
                layout: $('.button-command-layout.active').val(),
                mainColor: $('.sample-setting button.active').val(),
                bgColor: $('.background-setting button.active').val()
            }
            setCookie('motohero-setting-default', JSON.stringify(defaultSetting), 0);
        }
    }

    function panelApplySetting(setting) {
        $('.button-command-layout').each(function () {
            if (setting.layout == this.value) {
                $(this).trigger('click');
            }
        });
        $('.sample-setting button').each(function () {
            if (setting.mainColor == this.value) {
                $(this).trigger('click');
            }
        });
        $('.background-setting button').each(function () {
            if (setting.bgColor == this.value) {
                $(this).trigger('click');
            }
        });
    }

    function panelWriteSetting() {
        var activeSetting = {
            layout: $('.button-command-layout.active').val(),
            mainColor: $('.sample-setting button.active').val(),
            bgColor: $('.background-setting button.active').val()
        }
        setCookie('motohero-setting', JSON.stringify(activeSetting), 0);
    }

    /** COOKIE FUNCTION */
    function setCookie(cname, cvalue, exdays) {
        var expires = "";
        if (exdays) {
            var d = new Date();
            d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
            expires = " expires=" + d.toUTCString();
        }
        document.cookie = cname + "=" + cvalue + ";" + expires + '; path=/';
    }

    function getCookie(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ')
                c = c.substring(1);
            if (c.indexOf(name) == 0)
                return c.substring(name.length, c.length);
        }
        return "";
    }
	
	$(document).ready(function () {
        panel_setting();
    });
})(jQuery);