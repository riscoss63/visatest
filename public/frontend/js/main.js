$(document).ready(function(){
    //displayImageAsSVG();
    //includeRedundantPages();
    includeBootstrapTooltips();
    //scrollingSmoothAnchorsClick();
	
	
	//Faire apparaitre formulaire de facturation dans l'espace client
    $('#exampleCheck1').on('click', function(){
        $('#facturation').css('display', 'block');    
	});
	
    if($('.links-anchors').length){
        setLinksAnchorsToActive();
        setLinksAnchorsToStick();
		//scrollingSmoothAnchorsClick();
    }
	
    $(".nav-link[href='#info']").on('click', function(){
        setTimeout(function() {
            setLinksAnchorsToActive();
            setLinksAnchorsToStick('info');
			//scrollingSmoothAnchorsClick() ;
        }, 400);
    });
	
    if($('.order-recap .step-container').length && screen.width < 768){
        orderStepsAnimation();
    }

    //Change heart icon (like on photos) onclick
    $('.like-icon').on('click', function(){
        const emptyHeart = "images/heart.svg",
            fullHeart = "images/heart-full.svg";
        const imgElement = $(".like-icon img");

        if(imgElement.attr('src') === fullHeart){
            imgElement.attr('src', emptyHeart);
        }else{
            imgElement.attr("src", fullHeart);
        }
    });
	
	//Caroussel Avis Vérifiés
	$('#avis-verifies .owl-carousel, .actus-cards .owl-carousel').owlCarousel({
				loop:true,
				margin:50,
				nav:true,
				responsive:{
					0:{
						items:1
					},
					600:{
						items:2
					},
					1000:{
						items:3
					}
				}
			});
    //Faq : when click on sub-<li> in the left menu, the corresponding section appears on right side
    $(".tabs-faq .tabs-border-top .tab-content .links-anchors li").on( 'click', function(){
        if(screen.width > 768) {
            var anchorId = $(this).attr('id');
            var contentId = anchorId + '-content';

            $('.tabs-content').css('display', 'none');
            $('#' + contentId).css('display', 'block');

            //Close all dropdowns
           $('.row.faq > div:last-child div#' + contentId + ' > * > h4[aria-expanded="true"]').each(function () {
                //console.log(this);
                $(this).trigger("click");
            });

            //Make the first dropdown (1st question of questions section) active with little animation
            setTimeout(function () {
                $('.row.faq > div:last-child div#' + contentId + ' > div.row-with-margins:first-child > h4').trigger("click");
            }, 400);
        }
    });

    //Faq : when click on top-nav <li> in the left menu, the questions section corresponding to the first sub-<li> (top-nav <li> 1st child) appears on right side
    $(".tabs-faq .tabs-border-top .nav-tabs-navigation .nav-item a").on('click', function(){
        if(screen.width > 768) {
            var hrefId = $(this).attr('href');
            var contentId = hrefId + '-content';
            var activeSubmenu = contentId + " > .tabs-content:first-child > div.row-with-margins:first-child";

            /*1- Manage inactive tabpane*/
            //Make all questions sections (containing dropdowns on right side) of the INACTIVE tabpane invisible (display none)
            $('.row.faq > div:last-child > div.row:not(' + contentId + ') > .tabs-content').css('display', 'none');
            //Close all dropdowns
            //console.log("remove show from invisible tabpane");
            $('.row.faq > div:last-child > div.row:not(' + contentId + ') > .tabs-content > div.row-with-margins > div').removeClass("show");
            $('.row.faq > div:last-child > div.row:not(' + contentId + ') > .tabs-content > div.row-with-margins > h4').attr('aria-expanded', 'false');

            /*2- Manage active tabpane*/
            //Make the first 1st questions section (containing dropdowns on right side) of the ACTIVE tabpane visible (display block)
            $(contentId + " > .tabs-content:first-child").css('display', 'block');
            //Make the first tabpane link active to let it appear green (remove active on others before)
            $('div' + hrefId + ' li > a').removeClass('active');
            $('div' + hrefId + ' li:first-child > a').addClass('active');
            //Close all dropdowns
            $('.row.faq > div:last-child > div' + contentId + ' > .tabs-content > div.row-with-margins > div').removeClass("show");
            $('.row.faq > div:last-child > div' + contentId + ' > .tabs-content > div.row-with-margins > h4').attr('aria-expanded', 'false');
            //Make the first dropdown (1st question of questions section) active with little animation
            setTimeout(function () {
                $(activeSubmenu + " > h4").trigger("click");
            }, 400);
        }
    });

	// Displays btn 'Haut' when scrolling
	$(document).scroll(function() {
		var y = $(this).scrollTop();
		if (y > 400) {
			$('.fixed-element-scroll').addClass("show");
		} else {
			$('.fixed-element-scroll').removeClass("show");
		}
	});
	
	
	//Scroll Ancre Menu gauche et ancres avis des pages visas 
		$("#type-visa .links-anchors a[href^='#'] , #info .links-anchors a[href^='#']").on('click', function () {
			var hauteurHeader = $('#navigation').height();
			var the_id = $(this).attr("href");
			var elementPosition = $(the_id).offset().top;


			$('html, body').animate({
				scrollTop: elementPosition - hauteurHeader 
				}, 2000);   
				return false;
		});
	
	//Fixation de la barre de navigation générale 
		var position_top_raccourci = $("#navigation").offset().top;
		$(window).scroll(function () {
			if ($(this).scrollTop() > position_top_raccourci) {
				$('#navigation').addClass("fixNavigation");	
				
			} else {
				$('#navigation').removeClass("fixNavigation");
				
			}
		});
	//Scroll Ancre Avis du menu
	$("#onglets-avis a[href^='#'],  .ranking-stars a[href^='#']").on('click', function () {
		var hauteurHeader = $('#navigation').height();
		var the_id = $(this).attr("href");
		var elementPosition = $(the_id).offset().top;
		if ($(window).scrollTop() > position_top_raccourci) {
			$('html, body').animate({
				scrollTop: elementPosition - hauteurHeader
				}, 2000);   
				return false;
		}else{
			$('html, body').animate({
				scrollTop: elementPosition - 2* hauteurHeader
				}, 2000);   
				return false;
		}
	});
	// Hide submenu when clicking outside ------> voir utilité
	//document.onclick = function(e){
		//var submenu = $(".submenu-collapse");
		//if (!$('.submenu-link a').is(e.target) && !submenu.is(e.target) && submenu.has(e.target).length == 0) {
			//submenu.removeClass("show");
			//$('.submenu-link a').attr('aria-expanded', false);
		//}
	//};

	// Radio buttons with + and -
	$(document).on('click', '.range-box .range', function () {
		var btn = $(this),
			oldValue = btn.closest('.range-box').find('input').val().trim(),
			newVal = 0;

		if (btn.attr('data-dir') === 'up') {
			newVal = parseInt(oldValue) + 1;
		} else {
			if (oldValue > 1) {
				newVal = parseInt(oldValue) - 1;
			} else {
				newVal = 1;
			}
		}
		btn.closest('.range-box').find('input').val(newVal);
	});
});
// Cette fonction permet d'inclure des éléments qui se répètent dans les pages (Navbar, footer)
// Cette fonction est à enlever lors de la dynamisation des pages HTML
/*function includeRedundantPages(){
    var includes = $('[data-include]');
    var file;
    $.each(includes, function(){
        if($('[data-url]').length){
            file = $(this).data('url') + $(this).data('include') + '.html';
        }else{
            file = 'includes/' + $(this).data('include') + '.html';
        }
        $(this).load(file);
    });
}*/

// Ajout Bootstrap tooltips
function includeBootstrapTooltips() {
    $('[data-toggle="tooltip"]').tooltip()
}

// Scrolling with 'smooth' effect with clicking on anchors
/*function scrollingSmoothAnchorsClick() {
    $("#type-visa.links-anchors a[href='#']:not([href='#']), #info.links-anchors a[href='#']:not([href='#']), #navbar-reviews").on('click', function(e) {
        e.preventDefault();
        if (
            location.hostname === this.hostname
            && this.pathname.replace(/^\//,"") === location.pathname.replace(/^\//,"")
        ) {
            var anchor = $(this.hash);
            anchor = anchor.length ? anchor : $("[name=" + this.hash.slice(1) +"]");
            if ( anchor.length ) {
                $("html, body").animate( { scrollTop: anchor.offset().top }, 1500);
            }
        }
    })
	/*$('a[href^="#"]').on('click', function () {

    var the_id = $(this).attr("href");
    var elementPosition = $(the_id).offset().top;
    
    $('html, body').animate({
        scrollTop: elementPosition - 120
    }, 3000);
    return false;   
	});*/
    // When click on btn-top
    /*$("a[href='#top']").on('click', function() {
        $("html, body").animate({ scrollTop: 0 }, "slow");
        return false;
    });
}*/

// Allows SVG to be displayed as SVG in HTML doc
// This function permits to color SVG
/*function displayImageAsSVG() {
    $('img.svg').each(function () {
        var $img = $(this);
        var imgID = $img.attr('id');
        var imgClass = $img.attr('class');
        var imgURL = $img.attr('src');

        $.get(imgURL, function (data) {
            // Get the SVG tag, ignore the rest
            var $svg = $(data).find('svg');

            // Add replaced image's ID to the new SVG
            if (typeof imgID !== 'undefined') {
                $svg = $svg.attr('id', imgID);
            }
            // Add replaced image's classes to the new SVG
            if (typeof imgClass !== 'undefined') {
                $svg = $svg.attr('class', imgClass + ' replaced-svg');
            }

            // Remove any invalid XML tags as per http://validator.w3.org
            $svg = $svg.removeAttr('xmlns:a');

            // Check if the viewport is set, if the viewport is not set the SVG wont't scale.
            if (!$svg.attr('viewBox') && $svg.attr('height') && $svg.attr('width')) {
                $svg.attr('viewBox', '0 0 ' + $svg.attr('height') + ' ' + $svg.attr('width'))
            }

            // Replace image with new SVG
            $img.replaceWith($svg);

        }, 'xml');
    });
}*/

// Add active class on links-anchors
// Cf. Page visa classique - tabs Affaire, tourisme ...

function setLinksAnchorsToActive(){
    // 1. Add it on click
	
	$(" #pdf .on-tablet-desktop .links-anchors a").on('click', function(){
        $(" #pdf .links-anchors li a").removeClass('active');
		$("#pdf .links-anchors li a").attr(' aria-selected', function() {
			if(this.host == location.host) {
			return 'false'}
			else{ 
				return 'true'
			}
		});
        $(this).addClass('active');
	});

    $(".links-anchors a").on('click', function(){
        $(".links-anchors li a").removeClass('active');
        $(this).addClass('active');
	});
	
    // 2. Add on scroll
    var visaTypesContentPos = {}; // Array with position of all visa types contents (ex: visa-tourisme content, visa-affaires content...)
    var tabpaneId;

    // Populate array according to active pane (info or type de visa)
    if($('.tab-pane#info').hasClass('active')){
        $('.tab-pane#info > .row > div:last-child > div').each(function () {
            var visaTypeContentPos = $(this).offset().top - 120;
            var visaTypeContentId = $(this).attr('id'); //ex: démarches en ligne
            visaTypesContentPos[visaTypeContentId] = visaTypeContentPos;
            tabpaneId = "info";
        });
    }
    else {
        $('.tab-pane#type-visa > .row > div:last-child > div').each(function () {
            var visaTypeContentPos = $(this).offset().top -120;
            var visaTypeContentId = $(this).attr('id'); //ex: visa-affaires

            visaTypesContentPos[visaTypeContentId] = visaTypeContentPos;
            tabpaneId = "type-visa";
        });
    }

    // On each scroll event we compare windowpos with array. If windowPos goes over one of the array value, active class is updated.
    $(window).on('scroll', function() {
        var windowpos = $(window).scrollTop() + 120;

        $.each(visaTypesContentPos, function(id, pos) {
            if(windowpos >= pos){
                $(".tab-pane#" + tabpaneId + ">" + ".on-tablet-desktop .links-anchors li a").removeClass('active');
                $(".on-tablet-desktop .links-anchors a[href='#" + id +"']").addClass('active');
            }
        });
    });
}

// Tabs with anchors that are "fix" when up to their parent 'links-anchors'
function setLinksAnchorsToStick(id){
    var anchorsToStick;
    var pos;
    var end = $(".infos-in-tabs");
    var end_pos;
    if(id){
        anchorsToStick = ".tab-pane#" + id + " .links-anchors.to-stick";
        var posTop = $(anchorsToStick).offset().top - 120;
        var posLeft = $(anchorsToStick).offset().left;
        pos = {top: posTop , left: posLeft};
        end_pos = end.position().top + end.outerHeight(true) - 400;
    } else {
        anchorsToStick = ".tab-pane .links-anchors.to-stick:first-of-type";
        pos = $(anchorsToStick).offset();
        end_pos = end.position().top + end.outerHeight(true) - 400;
    }
    if( $(anchorsToStick).length){
        var s = $(anchorsToStick);
        var ulAbsolute = $(anchorsToStick + " ul");

        $(window).on('scroll', function() {
            var windowpos = $(window).scrollTop();
            if (windowpos >= (pos.top) && windowpos <= (end_pos)) { 
                ulAbsolute.css("top","");
                ulAbsolute.css("bottom","");
                s.addClass("sticky");
            } else {
                s.removeClass("sticky");
                if(windowpos < (pos.top )){
                    ulAbsolute.css("top","0");
                }
                else{
                    ulAbsolute.css("bottom","1400px");
                }
            }
        });
    }
}

function orderStepsAnimation(){
    var activeStep = 0;

    $('.order-recap .step-container > .step-wrapper').each(function (index) {
        if($(this).children('.step').hasClass('active')){
            activeStep = index + 1;
        }
    });

    $('.order-recap .step-container > .step-wrapper > .step').removeClass('active');

    $('.order-recap .step-container > .step-wrapper:nth-child(-n' + activeStep + ') > .step').each(function (index) {
        var i = index +1;

        $("html, body").animate(
            {
                scrollTop: $(this).offset().top
            }, 1300, function() {
                $('.order-recap .step-container > .step-wrapper:nth-child(' + i + ') > .step').addClass('active');
                if(i != activeStep) {
                    setTimeout(function () {
                        $('.order-recap .step-container > .step-wrapper:nth-child(' + i + ') > .step').removeClass('active');
                    }, 200);
                }
            });
    });
}