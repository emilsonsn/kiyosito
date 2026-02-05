'use strict';


// ============== Header Hide Click On Body Js Start ========
$('.navbar-toggler').on('click', function() {
  $('.body-overlay').toggleClass('show-overlay')
}); 
$('.body-overlay').on('click', function() {
  $('.navbar-toggler').trigger('click')
  $(this).removeClass('show-overlay');
}); 
// =============== Header Hide Click On Body Js End =========


$( document ).ready(function() {
  //preloader js code
  $(".preloader-holder").delay(300).animate({
    "opacity" : "0"
    }, 300, function() {
    $(".preloader-holder").css("display","none");
  });
});

// menu options custom affix
var fixed_top = $(".header");
$(window).on("scroll", function(){
   windowScroll();
});


function windowScroll(){
    if( $(window).scrollTop() > 0){  
      fixed_top.addClass("animated fadeInDown menu-fixed");
  }
  else{
      fixed_top.removeClass("animated fadeInDown menu-fixed");
  }
}

windowScroll();

// mobile menu js
$(".navbar-collapse>ul>li>a, .navbar-collapse ul.sub-menu>li>a").on("click", function() {
  const element = $(this).parent("li");
  if (element.hasClass("open")) {
    element.removeClass("open");
    element.find("li").removeClass("open");
  }
  else {
    element.addClass("open");
    element.siblings("li").removeClass("open");
    element.siblings("li").find("li").removeClass("open");
  }
});

new WOW().init();

// lightcase plugin init
$('a[data-rel^=lightcase]').lightcase();

// main wrapper calculator
var bodySelector = document.querySelector('body');
var header = document.querySelector('.header');
var footer = document.querySelector('.footer');
(function(){
  if(bodySelector.contains(header) && bodySelector.contains(footer)){
    // var headerHeight = document.querySelector('.header').clientHeight;
    var footerHeight = document.querySelector('.footer').clientHeight;

    // var totalHeight = parseInt( headerHeight, 10 ) + parseInt( footerHeight, 10 ) + 'px'; // if header isn't fixed to top
    var totalHeight = parseInt( footerHeight, 10 ) + 'px'; // if header is fixed to top
    var minHeight = '100vh';
    document.querySelector('.main-wrapper').style.minHeight = `calc(${minHeight} - ${totalHeight})`;  
  }
})();

 

// Show or hide the sticky footer button
$(window).on("scroll", function() {
	if ($(this).scrollTop() > 200) {
			$(".scroll-to-top").fadeIn(200);
	} else {
			$(".scroll-to-top").fadeOut(200);
	}
});

// Animate the scroll to top
$(".scroll-to-top").on("click", function(event) {
	event.preventDefault();
	$("html, body").animate({scrollTop: 0}, 300);
});

$(function () {
  $('[data-toggle="tooltip"]').tooltip({
    boundary: 'window'
  })
});



/* ==============================
					slider area
================================= */

// payment-method-slider
$('.testimonial-slider').slick({
  autoplay: true,
  autoplaySpeed: 2000,
  dots: false,
  infinite: true,
  speed: 300,
  slidesToShow: 2,
  arrows: true,
  nextArrow: '<div class="next"><i class="las la-long-arrow-alt-right"></i></div>',
    prevArrow: '<div class="prev"><i class="las la-long-arrow-alt-left"></i></div>',
  slidesToScroll: 1,
  responsive: [
    {
      breakpoint: 992,
      settings: {
        slidesToShow: 1,
      }
    }
  ]
});


$("[data-paroller-factor]").paroller();
// button magnetic animation
var hoverMouse = function($el) {
  $el.each(function() {
    var $self = $(this);
    var hover = false;
    var offsetHoverMax = $self.attr("offset-hover-max") || 0.5;
    var offsetHoverMin = $self.attr("offset-hover-min") || 0.3;

    var attachEventsListener = function() {
      $(window).on("mousemove", function(e) {
        //
        var hoverArea = hover ? offsetHoverMax : offsetHoverMin;

        // cursor
        var cursor = {
          x: e.clientX,
          y: e.clientY - $(window).scrollTop()
        };

        // size
        var width = $self.outerWidth();
        var height = $self.outerHeight();

        // position
        var offset = $self.offset();
        var elPos = {
          x: offset.left + width / 2,
          y: offset.top + height / 2
        };

        // comparaison
        var x = cursor.x - elPos.x;
        var y = cursor.y - elPos.y;

        // dist
        var dist = Math.sqrt(x * x + y * y);

        // mutex hover
        var mutHover = false;

        // anim
        if (dist < width * hoverArea) {
          mutHover = true;
          if (!hover) {
            hover = true;
          }
          onHover(x, y);
        }

        // reset
        if (!mutHover && hover) {
          onLeave();
          hover = false;
        }
      });
    };

    var onHover = function(x, y) {
      TweenMax.to($self, 0.4, {
        x: x * 0.3,
        y: y * 0.3,
        //scale: .9,
        rotation: x * 0.03,
        ease: Power2.easeOut
      });
    };
    var onLeave = function() {
      TweenMax.to($self, 0.7, {
        x: 0,
        y: 0,
        scale: 1,
        rotation: 0,
        ease: Elastic.easeOut.config(1.2, 0.4)
      });
    };

    attachEventsListener();
  });
};
hoverMouse($('.magnetic-effect'));



// custom cursor 
var cursor = $(".cursor"),
    follower = $(".cursor-follower");

var posX = 0,
    posY = 0;

var mouseX = 0,
    mouseY = 0;

TweenMax.to({}, 0.016, {
  repeat: -1,
  onRepeat: function() {
    posX += (mouseX - posX) / 9;
    posY += (mouseY - posY) / 9;
    
    TweenMax.set(follower, {
        css: {    
        left: posX - 12,
        top: posY - 12
        }
    });
    
    TweenMax.set(cursor, {
        css: {    
        left: mouseX,
        top: mouseY
        }
    });
  }
});

$(document).on("mousemove", function(e) {
    mouseX = e.clientX;
    mouseY = e.clientY;
});

$("a").on("mouseenter", function() {
    cursor.addClass("active");
    follower.addClass("active");
});
$("a").on("mouseleave", function() {
    cursor.removeClass("active");
    follower.removeClass("active");
});

$('input').attr('autocomplete','off');



//required
$.each($('input, select, textarea'), function (i, element) {
  if (element.hasAttribute('required') && element.type != 'checkbox') {
    $(element).closest('.form-group').find('label').first().addClass('required');
  }

});


//data-label of table//
Array.from(document.querySelectorAll('table')).forEach(table => {
  let heading = table.querySelectorAll('thead tr th');
  Array.from(table.querySelectorAll('tbody tr')).forEach(row => {
    Array.from(row.querySelectorAll('td')).forEach((column, i) => {
      (column.colSpan == 100) || column.setAttribute('data-label', heading[i].innerText)
    });
  });
});

// restructure faq html
window.addEventListener('DOMContentLoaded', () => {
  
  let faqElements  = document.querySelectorAll('.accordion-item');
  let faqContainer = document.getElementById('faqAccordion');
  let oddElement   = '';
  let evenElement  = '';

  if (faqContainer == undefined || faqContainer.tagName != 'DIV' || typeof faqElements != 'object') 
  return false;

  Array.from(faqElements).forEach(function (element,i) {
    if (i % 2 == 0) {
      evenElement += element.outerHTML;
    } else {
      oddElement  += element.outerHTML;
    }
  });

faqContainer.innerHTML=`
  <div class="row gy-3">
    <div class="col-lg-6">${evenElement}</div>
    <div class="col-lg-6">${oddElement}</div>
  </div>`;
});


// lightcase plugin init
$('a[data-rel^=lightcase]').lightcase();