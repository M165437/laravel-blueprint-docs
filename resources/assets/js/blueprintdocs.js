require('sticky-sidebar/dist/sticky-sidebar.js');

var hljs = require('highlight.js/lib/highlight');
hljs.registerLanguage('http', require('highlight.js/lib/languages/http'));
hljs.registerLanguage('json', require('highlight.js/lib/languages/json'));

$(document).ready(function () {
    var sidebar = new StickySidebar('.sidebar', {
        topSpacing: 22,
        bottomSpacing: 0,
        containerSelector: '.content-wrapper',
        innerWrapperSelector: '.sidebar__inner'
    });

    $(window).resize(function() {
        console.log('Resizing', sidebar);
        sidebar.updateSticky();
    });

    $('[id^=collapse-]').on('show.bs.collapse', function () {
        var id = $(this).prev().find('a').data('group-id'),
            scrollTop = $(document.getElementById(id)).offset().top - 33;
        $('html, body').animate({scrollTop: scrollTop});
    });

    $('[id^=collapse-]').on('hide.bs.collapse', function (e) {
        var id = $(this).prev().find('a').data('group-id'),
            scrollTop = $(document.getElementById(id)).offset().top - 33;
        if ($(window).scrollTop() !== scrollTop) {
            $('html, body').animate({scrollTop: scrollTop});
            e.preventDefault();
        }
        ;
    });

    $('.tabs').on('click', 'a', function (e) {
        var id = $(this).attr('href').substring(1),
            scrollTop = $(document.getElementById(id)).offset().top - 33;
        $('html, body').animate({scrollTop: scrollTop});
        e.preventDefault();
    });

    $('.nav-pills').on('click', '.active a', function (e) {
        e.preventDefault();
        var that = $(this);
        window.setTimeout(function () {
            that.closest('.nav-pills').next('.tab-content').find('.tab-pane').removeClass('active');
            that.parent('li').removeClass('active');
        }, 0);
    });

    $('pre code').each(function (i, block) {
        hljs.highlightBlock(block);
    });
});