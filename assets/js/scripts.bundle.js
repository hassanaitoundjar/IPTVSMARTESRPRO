"use strict";

var ScriptsBundle = ScriptsBundle || {};

$(function() {
    ScriptsBundle = {
        init: function() {
            ScriptsBundle.pageLoader();
            ScriptsBundle.initTooltip();
            ScriptsBundle.headerEvent();
            ScriptsBundle.themeDark();
            ScriptsBundle.toggleDropdown();
            ScriptsBundle.editor();
            ScriptsBundle.selectC();
        },

        pageLoader: function () {
            var $loader = $('#pb_loader');
            $loader.addClass('pb-loaded').delay(500).fadeOut();
        },

        /*!
         * Initialize data function
         *---------------------------------------------------*/
        initTooltip() {
            var $dataTooltip = $('[data-bs-toggle="tooltip"]');
            
            if ($dataTooltip.length) {
                $dataTooltip.tooltip();
            }
        },

        headerEvent: function () {
            var $hamburger = $('#pb_hamburger');
            var $icon = $('#pb_search_icon');
            var $body = $('body');
            var show = 'show';
            var hideSidebar = 'pb-hide-sidebar';

            $hamburger.on('click', function () {
                $body.toggleClass(hideSidebar);
            });
            
            $icon.on('click', function () {
                $(this).parent().toggleClass(show);
            });
        },

        themeDark: function() {
            var $dark = $('#pb_dark_mode');
            var dark = 'pb-theme-dark';

            if (localStorage.getItem('dark') === 'true') {
                $body.addClass(dark);
                $dark.attr('checked', true);
            }

            $dark.on('change', function(event) {
                if (event.target.checked) {
                    $body.addClass(dark);
                    localStorage.setItem('dark', true);
                } else {
                    $body.removeClass(dark);
                    localStorage.setItem('dark', false);
                }
            });
        },

        toggleDropdown: function () {
            var $sidebarLink = $('.nav-item-has-submenu > a');
            var $showMenu = $('.nav-item-submenu.show');
            var open = 'open';
            var show = 'show';

            $showMenu.slideDown(350);

            $sidebarLink.on('click', function (e) {
                e.stopPropagation();
                var $this = $(this);
                if ($this.next().hasClass(show)) {
                    $this.next().removeClass(show);
                    $this.parent().removeClass(open);
                    $this.next().slideUp(350);
                } else {
                    $this.parent().parent().find('.nav-item-submenu').removeClass(show).slideUp(350);
                    $this.parent().parent().find('.nav-item-has-submenu').removeClass(open);
                    $this.next().toggleClass(show);
                    $this.parent().toggleClass(open);
                    $this.next().slideToggle(350);
                }
            });
        },
        
        editor: function() {
            $("#editor").richText();
            $("#editor2").richText();
            $("#editor3").richText();
        },
        
        selectC: function() {
            $(".basic").select2({
                tags: true,
            });
            $(".basic2").select2({
                tags: true,
            });
            
            $(".tagging").select2({
                tags: true
            });
        }
        
    };

    var $body = $('body');
    
    $(document).ready(ScriptsBundle.init);
});