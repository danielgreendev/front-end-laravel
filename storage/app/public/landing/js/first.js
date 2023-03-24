/*
Template Name: Spark - App Landing Page Template.
Author: GrayGrids
*/

(function () {
    //===== Prealoder

    window.onload = function () {
        window.setTimeout(fadeout, 500);
    }

    function fadeout() {
        document.querySelector('.preloader').style.opacity = '0';
        document.querySelector('.preloader').style.display = 'none';
    }

    /*----------------------------------------
                Preloader
    ------------------------------------------*/
    $('.preloader').preloadinator({
      minTime: 2000,
      scroll: false
    });

    /*=====================================
    Sticky
    ======================================= */
    window.onscroll = function () {
        var header_navbar = document.querySelector(".navbar-area");
        if (header_navbar != null) {
            var sticky = header_navbar.offsetTop;
    
            var logo = document.querySelector('.navbar-brand img')
            if (window.pageYOffset > sticky) {
              header_navbar.classList.add("sticky");
              logo.src = 'storage/app/public/landing/img/nav-logo.png';
            } else {
              header_navbar.classList.remove("sticky");
              logo.src = 'storage/app/public/landing/img/logo.png';
            }
        }

        // show or hide the back-top-top button
        var backToTo = document.querySelector(".scroll-top");
        if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
            backToTo.style.display = "flex";
        } else {
            backToTo.style.display = "none";
        }
    };

    // WOW active
    new WOW().init();

    //===== mobile-menu-btn
    let navbarToggler = document.querySelector(".mobile-menu-btn");

    if (navbarToggler) {
        navbarToggler.addEventListener('click', function () {
            navbarToggler.classList.toggle("active");
        });
    }

})();