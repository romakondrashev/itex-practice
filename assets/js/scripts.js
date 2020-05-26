/*!
    * Start Bootstrap - SB Admin v6.0.0 (https://startbootstrap.com/templates/sb-admin)
    * Copyright 2013-2020 Start Bootstrap
    * Licensed under MIT (https://github.com/BlackrockDigital/startbootstrap-sb-admin/blob/master/LICENSE)
    */


(function($) {
	"use strict";


    // Add active state to sidbar nav links
    var path = window.location.href; // because the 'href' property of the DOM element is the absolute path
    $("#layoutSidenav_nav .sb-sidenav a.nav-link").each(function() {
    	if (this.href === path) {
    		$(this).addClass("active");
    	}
    });

    // Toggle the side navigation
    $("#sidebarToggle").on(function(e) {
    	$("body").toggleClass("sb-sidenav-toggled");
    });
    // Chat settings
    $.ajax('./backend/chat/show-condition.php').done(function(data){
        let chat = $('#floating_chat_wrapper');

        if (parseInt(data) === 1 && chat.html() === '' ) {
            chat.load('./frontend/chat.php');
        } else if (parseInt(data) === 0 && chat.html() !== '' ) {
            chat.html('');
        }
    });

    
    
    





})(jQuery);
