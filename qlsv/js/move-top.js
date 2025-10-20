$(document).ready(function() {
    $('#backToTopBtn').hide();

    $(window).scroll(function() {
        if ($(this).scrollTop() > 20) {
            $('#backToTopBtn').fadeIn();
        } else {
            $('#backToTopBtn').fadeOut();
        }
    });

    $('#backToTopBtn').click(function() {
        $('html, body').animate({scrollTop: 0}, 1);
        return false;
    });
});

$(document).ready(function() {
    $('#phonecall').click(function() {
        $('#callPanel').fadeIn(200);
    });

    $('#closePanel').click(function() {
        $('#callPanel').fadeOut(200);
    });
});

$(window).on('load', function() {
    const $headerContent = $('.header-content');
    const $headerImage = $('.header-image');

    setTimeout(function() {
        $headerContent.css('transform', 'translateX(0)');
        $headerImage.css('transform', 'translateX(0)');
    }, 100);
});

window.addEventListener('scroll', function() {
    var nav = document.querySelector('.navbar');
    var sticky = nav.offsetTop;
    
    if (window.pageYOffset > sticky) {
        nav.classList.add('fixed-top');
    } else {
        nav.classList.remove('fixed-top');
    }
});
