jQuery(document).ready(function ($) {
	$('.modal-content').resizable({
		alsoResize: ".modal-dialog",
		handles: 'n, e, s, w, ne, sw, se, nw',
		start: function (event, ui) {
			$('.modal-body').addClass('resize_popup_wrap');
		}
	});
	$('.modal-dialog').draggable();
	function setCookie(name, value, days) {
		var expires = "";
		if (days) {
			var date = new Date();
			date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
			expires = "; expires=" + date.toUTCString();
		}
		document.cookie = name + "=" + (value || "") + expires + "; path=/";
	}
	function getCookie(name) {
		var nameEQ = name + "=";
		var cookies = document.cookie.split(';');
		for (var i = 0; i < cookies.length; i++) {
			var cookie = cookies[i];
			while (cookie.charAt(0) == ' ') {
				cookie = cookie.substring(1, cookie.length);
			}
			if (cookie.indexOf(nameEQ) == 0) {
				return cookie.substring(nameEQ.length, cookie.length);
			}
		}
		return null;
	}
	function deleteCookie(name) {
		document.cookie = name + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
	}

	/************** Desktop Screen ***************/

	var modalCookie = getCookie("modalOpened");
	if (modalCookie === "true") {
		$('#myModal_desktop').modal('show');
	}
	$('.desktop_screen_pop').click(function () {
		setCookie("modalOpened", "true", 1);
	});
	$(".modal-content button.close").click(function () {
		deleteCookie("modalOpened");
	});

	/************** Laptop Screen ***************/

	var modalCookie = getCookie("modalOpeneed");
	if (modalCookie === "true") {
		$('#myModal_laptop').modal('show');
	}
	$('.laptop_screen_pop').click(function () {
		setCookie("modalOpeneed", "true", 1);
	});
	$(".modal-content button.close").click(function () {
		deleteCookie("modalOpeneed");
	});

	/************** Tablet Screen ***************/
	if (modalCookie === "true") {
		$('#myModal_tablet').modal('show');
	}
	$('.tablet_screen_pop').click(function () {
		setCookie("modalOpened", "true", 1);
	});
	$(".modal-content button.close").click(function () {
		deleteCookie("modalOpened");
	});

	/*************** Mobile Screen ***************/

	if (modalCookie === "true") {
		$('#myModal_mobile').modal('show');
	}
	$('.mobile_screen_pop').click(function () {
		setCookie("modalOpened", "true", 1);
	});
	$(".modal-content button.close").click(function () {
		deleteCookie("modalOpened");
	});

});