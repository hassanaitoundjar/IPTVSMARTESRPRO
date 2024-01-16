"use strict";

const Bundle = function() {

    const show = 'show';
    const open = 'open';
    const active = 'active';

    const body = $('body');

    let analyticsChart;

    /**
     * Check for dark mode
     * @returns {boolean}
     */
    const isDarkMode = function() {
        return localStorage.getItem('dark_mode') === 'true';
    }


    /**
     * Get CSS variable value
     * @param {string} name 
     * @returns {string}
     */
    const getCSSVarValue = function(name) {
        var hex = getComputedStyle(document.documentElement).getPropertyValue('--ns-' + name);
            if (hex && hex.length > 0) {
                hex = hex.trim();
            }

            return hex;
    }


    /**
     * Page loader
     */
    const loader = function() {
        const loading = $('#nsofts_loader');
        loading.fadeOut(500);
    }


    /**
     * Initialize perfect scrollbar
     */
    const initScrollbar = function() {
        $('[data-scroll="true"]').each(function() {
            // Bind perfect scrollbar with element.
            new PerfectScrollbar(this, {
                wheelSpeed: 2,
                swipeEasing: true,
                wheelPropagation: false,
                minScrollbarLength: 40
            });
        });
    }

    /**
     * Initialize select2
     */
    const initSelect = function() {
        $('.nsofts-select').select2();
    }


    /**
     * Initialize quill editor
     */
    const initEditor = function() {
        const toolbarOptions = [
            ['bold', 'italic', 'underline', 'strike'], 
            ['blockquote', 'code-block'],
            
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            [{ 'script': 'sub'}, { 'script': 'super' }],
            [{ 'indent': '-1'}, { 'indent': '+1' }],
            [{ 'direction': 'rtl' }],
          
            [{ 'size': ['small', false, 'large', 'huge'] }],
            [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
          
            [{ 'color': [] }, { 'background': [] }],
            [{ 'font': [] }],
            [{ 'align': [] }],
          
            ['clean']
        ];

        $('.nsofts-editor').each(function(i) {
            const editor = document.createElement('div');
            editor.className = this.className;
            editor.innerHTML = this.value;

            this.classList.add('d-none');
            $(this).parent().append(editor);

            // console.log(editor);
            const quill = new Quill(editor, {
                theme: 'snow',
                placeholder: 'Write here...',
                modules: {
                    toolbar: toolbarOptions
                },
            });
            
            quill.on('text-change', () => {
                $(this).html(quill.root.innerHTML);
            });
        });
    }



    /**
     * Initialize charts
     */
    const initChart = function() {
        globalChartSettings();
        analytics();
    }

    /**
     * Theme sidebar
     */
    const sidebar = function() {
        const hamburger = $('#nsofts_hamburger');
        const compact = 'nsofts-compact-sidebar';
        const compactSidebar = 'compact_sidebar';

        if (localStorage.getItem(compactSidebar) === 'true') {
            body.addClass(compact);
            hamburger.addClass(active);
        }

        hamburger.on('click', function() {
            $(this).toggleClass(active);
            body.toggleClass(compact);
            body.hasClass(compact) ? localStorage.setItem(compactSidebar, true) : localStorage.removeItem(compactSidebar);
        });

        // Submenu
        const link = $('.nsofts-has-menu > .nsofts-sidebar-nav__link');
        const menu = $('.nsofts-submenu');

        Array.from(menu).forEach(item => {
            if ($(item).hasClass(show)) {
                $(item).slideDown();
            }
        });

        link.on('click', function() {
            const _this = $(this);
            const next = _this.next();

            if (_this.hasClass(open)) {
                _this.removeClass(open);
                next.slideUp().removeClass(show);

            } else {
                Array.from(link).forEach(item => {
                    if (!$(item).hasClass(active)) {
                        $(item).removeClass(open);
                        $(item).next().slideUp().removeClass(show);
                    }
                });
                _this.addClass(open);
                next.slideDown().addClass(show);
            }
        });
    }


    /**
     * Theme dark 
     */
    const themeOptions = function() {
        const toggler = $('#nsofts_theme_toggler');
        const dark = 'nsofts-theme-dark';
        const mode = 'dark_mode'

        if (localStorage.getItem(mode) === 'true') {
            body.addClass(dark);
            toggler.addClass(active);
        }

        toggler.on('click', function() {
            const _this = $(this);
            if (_this.hasClass(active)) {
                _this.removeClass(active);
                body.removeClass(dark);
                localStorage.removeItem(mode);

            } else {
                _this.addClass(active);
                body.addClass(dark);
                localStorage.setItem(mode, true);
            }
        });
    }


    /**
     * Password toggle
     */
    const password = function() {
        const passwordInput = $('#nsofts_password_input');
        const passwordToggler = $('#nsofts_password_toggler');
        const passwordOpen = $('.nsofts-eye-open');
        const passwordClose = $('.nsofts-eye-close');
        const none = 'd-none';
        
        passwordToggler.on('click', function() {
            const _this = $(this);
            if (_this.hasClass(active)) {
                _this.removeClass(active);
                passwordOpen.removeClass(none);
                passwordClose.addClass(none);
                passwordInput.attr('type', 'password');
                
            } else {
                _this.addClass(active);
                passwordOpen.addClass(none);
                passwordClose.removeClass(none);
                passwordInput.attr('type', 'text');
            }
        });
    }
    
    /**
     * Tooltip
     */
    const initTooltip = function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
          return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    }
    
    return {
        init() { 
            loader();
            initScrollbar();
            initSelect();
            initEditor();
            sidebar();
            themeOptions();
            password();
            initTooltip();
        }
    }
    
}();

jQuery(window).on('load', Bundle.init());