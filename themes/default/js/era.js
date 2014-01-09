// carouFredSel Fonksiyonu
$(function() {
	$('ul#basic_config').carouFredSel();
	$('ul#user_interaction').carouFredSel({
		prev: '#prev1',
		next: '#next1',
		auto: false
	});
	$('#vnoviwvw').carouFredSel({
		scroll: 1,
		width: 620,
		next: '#next2',
		prev: '#prev2'
	});
});

// Google Plus için çalıştırıcı
gapi.plusone.go();


// ####################################################################### //
// Başlangıçta çalıştırılacaklar!
$(document).ready(function(){
	// Saati Çalıştır
	show_clock();
	
	// Newsticker
	$('#duyurular').newsticker( {
              'style'         : 'scroll',
              'tickerTitle'   : 'Duyurular',
              'letterRevealSpeed' : 70,        
              'transitionSpeed' : 2000,
              'pauseOnHover'  : false,
              'autoStart'     : true,              
              'showControls'  : true              
    });
	
	// Tab Kutusu
	$(".tab_content").hide(); //Hide all content
	$("ul.tabs li:first").addClass("active").show(); //Activate first tab
	$(".tab_content:first").show(); //Show first tab content

	//On Click Event
	$("ul.tabs li").click(function() {

		$("ul.tabs li").removeClass("active"); //Remove any "active" class
		$(this).addClass("active"); //Add "active" class to selected tab
		$(".tab_content").hide(); //Hide all tab content

		var activeTab = $(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
		$(activeTab).fadeIn(); //Fade in the active ID content
		return false;
	});
	
	// Manşet haber kutusu
	$("#manset").featuredbox({width: 620,
			height: 300,
			slidesAnimation: "slide-top",
			slidesSpeed: "slow",
			descriptionAnimation: "slide-bottom",
			descriptionSpeed: "slow"
	});
	
	// Header Images
	$("#header_images").featuredbox({
			width: 975,
			height: 160,
			slidesAnimation: "line",
			slidesSpeed: "slow",
			descriptionAnimation: "fade",
			descriptionSpeed: "slow",
			rotateInterval: 3500
	});	
	
	//
});