$(document).ready(function() {

	var windowHeight = $(window).height();
	var docHeight = $('body').height();
	var windowWidth = $(window).width();
	var carouselHeight = $('#section-slide .carousel-inner').height();
	var dismissMargin = $('#nav-dismissible .media-left').width();
	if ($(window).width() < 768) {
		
		$('#modal-cart .modal-content').height(windowHeight-2);
	
		$('.bg-jumbotron').height(carouselHeight+25);
		$('#section-slide').height(carouselHeight+25);

		var managerHeader = $('#main-nav-tool .navbar-header').width();
		$('.nav-title').width(managerHeader - 80);

		$('#nav-dismissible .media-right').css({
			'margin-left' : dismissMargin
		});
	}
	if ($(window).width() < 320){
		$('.bg-jumbotron').height(carouselHeight+100);
	}
	var navHeight = $('#main-nav-wrapper').height();
	var footerHeight = $('#footer-main').height();
	$('.main').css({
		'min-height' : windowHeight - (navHeight+footerHeight+60),
	});
	
	$('.slide-menu').hide();

	$('.slide-menu').css({
		'height' : docHeight,
		'width' : windowWidth,		
	});
	
		

	$('.close-slide').click(function() {
        $('.slide-menu.right').hide('slide', {direction: 'right'}, 300);
        $('.slide-menu.left').hide('slide', {direction: 'left'}, 300);
        $('body').removeClass('lock');
    });
	$('.btn-slide-right').click(function() {
        $('.slide-menu.right').show('slide', {direction: 'right'}, 300);
        setTimeout(function() {
            $('.slide-menu.right').addClass('in');
        },300);
        $('body').addClass('lock');      
    });
	$(".follow-btn").click(function() {
		var element = $(this);
		console.log(element);
		$.ajax({
			type: "GET",
			url: "/campaign/set-user-subscribe/" + element.data("subscriber-id") + "/" + element.data("user-id"),
			dataType: "json",
			success: function (data) {
				if (data.success) {
					if(data.is_subscribed) {
						/*element.find("i").removeClass("fa-plus");
						element.find("i").addClass("fa-check-circle");*/
						
						element.hide().fadeIn(500);
						element.removeClass('btn-default');
						element.addClass('btn-success');
						element.html('<i class="fa fa-check-circle"></i> Following');
						
					} else {
						/*element.find("i").removeClass("fa-check-circle");
						element.find("i").addClass("fa-plus");*/
						element.hide().fadeIn(500);
						element.removeClass('btn-success');
						element.addClass('btn-default');
						element.html('<i class="fa fa-plus-circle"></i> Follow');
						
					}
				}
			},
			failure: function (errMsg) {
				alert(errMsg);
			}
		});
	});
	$(".add-to-wish-list").click(function () {
		var element = $(this);
		$.ajax({
			type: "GET",
			url: "/campaign/add-to-wish-list/" + element.data("campaign-id") + "/" + element.data("user-id"),
			dataType: "json",
			success: function (data) {
				if (data.success) {
					console.log(data);
					if(data.is_wished) {
						element.find("i").addClass("fa-heart");
						element.find("i").removeClass("fa-heart-o");
						element.find("#wishlist-text").html("เพิ่มในรายการโปรดแล้ว")
					} else {
						element.find("i").addClass("fa-heart-o");
						element.find("i").removeClass("fa-heart");
						element.find("#wishlist-text").html("เพิ่มในรายการโปรด")
					}
				}
			},
			failure: function (errMsg) {
				alert(errMsg);
			}
		});
	});
});