(function () {
    //===== Prealoder
    window.onload = function () {
        window.setTimeout(fadeout, 500);
        $('#sidebarCollapse').click(function(){
            $('#sidebar').toggleClass('active');
        });
    }

    function fadeout() {
        document.querySelector('.preloader').style.opacity = '0';
        document.querySelector('.preloader').style.display = 'none';
    }
})();