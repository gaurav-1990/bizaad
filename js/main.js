(function ($) {
"use strict";

/* meanmenu */
 $('#mob-menu').meanmenu({
	 meanMenuContainer: '.mobile-menu',
	 meanScreenWidth: "991"
 });	


/* slider-active */
$('.slider-active').owlCarousel({
    loop:true,
    nav:false,
	dots:true,
    responsive:{
        0:{
            items:1
        },
        767:{
            items:1
        },
        1000:{
            items:1
        }
    }
})
/* sliders-active */
$('.sliders-active').owlCarousel({
    loop:true,
    nav:false,
	dots:true,
    responsive:{
        0:{
            items:1
        },
        767:{
            items:1
        },
        1000:{
            items:1
        }
    }
})

$('.for-img-set').owlCarousel({
    loop:false,
  nav:true,
	navText:['<i class="fa fa-chevron-left"></i>','<i class="fa fa-chevron-right"></i>'],
	dots:true,
    responsive:{
        0:{
            items:1
        },
        767:{
            items:1
        },
        1000:{
            items:1
        }
    }
})
/* top-seller-active */
$('.top-seller-active').owlCarousel({
    loop:true,
    nav:false,
	dots:true,
    responsive:{
        0:{
            items:1
        },
        767:{
            items:3
        },
        1000:{
            items:4
        },
        1400:{
            items:5
        }
    }
})

/* product-active */
$('.product-active').owlCarousel({
    loop:true,
    nav:true,
	navText:['<i class="fa fa-chevron-left"></i>','<i class="fa fa-chevron-right"></i>'],
    responsive:{
        0:{
            items:1
        },
        767:{
            items:2
        },
        1000:{
            items:4
        }
    }
})

/* product1-active */
$('.product1-active').owlCarousel({
    loop:true,
    nav:true,
	navText:['<i class="fa fa-chevron-left"></i>','<i class="fa fa-chevron-right"></i>'],
    responsive:{
        0:{
            items:1
        },
        767:{
            items:2
        },
        1000:{
            items:4
        },
        1200:{
            items:5
        }
    }
})

/* product-2-slider */
$('.product-2-slider').owlCarousel({
    loop:true,
    nav:true,
    margin:30,
	navText:['<i class="fa fa-chevron-left"></i>','<i class="fa fa-chevron-right"></i>'],
    responsive:{
        0:{
             margin:18,
            items:2
        },
        768:{
            items:2
        },
        1000:{
            items:3
        },
        1200:{
            items:4
        },
        1500:{
            items:5
        }
    }
})


/* product-2-slider */
$('.product-category-home').owlCarousel({
    loop:true,
    nav:true,
    margin:30,
	navText:['<i class="fa fa-chevron-left"></i>','<i class="fa fa-chevron-right"></i>'],
    responsive:{
        0:{
            
            margin:18,
            items:2
        },
        768:{
            items:2
        },
        1000:{
            items:3
        },
        1200:{
            items:4
        },
        1500:{
            items:5
        }
    }
})

/* products-active */
$('.products-active').owlCarousel({
    loop:true,
    nav:true,
	navText:['<i class="fa fa-chevron-left"></i>','<i class="fa fa-chevron-right"></i>'],
    responsive:{
        0:{
            items:1
        },
        768:{
            items:2
        },
        1000:{
            items:2
        },
        1200:{
            items:3
        }
    }
})

/* testimonial-active */
$('.testimonial-active').owlCarousel({
    loop:true,
    nav:false,
	dots:true,
    responsive:{
        0:{
            items:1
        },
        767:{
            items:1
        },
        1000:{
            items:1
        }
    }
})

/* blog-active */
$('.blog-active').owlCarousel({
    loop:true,
    nav:true,
	navText:['<i class="fa fa-chevron-left"></i>','<i class="fa fa-chevron-right"></i>'],
    responsive:{
        0:{
            items:1
        },
        767:{
            items:2
        },
        1000:{
            items:3
        }
    }
})
/* item-active */
$('.item-active').owlCarousel({
    loop:true,
    nav:true,
    margin:18,
	navText:['<i class="fa fa-chevron-left"></i>','<i class="fa fa-chevron-right"></i>'],
    responsive:{
        0:{
          
            items:2
        },
        767:{
            items:2
        },
        1000:{
            items:2
        }
    }
})

/* brand-active */
$('.brand-active').owlCarousel({
    loop:true,
    nav:true,
	dots:false,
	autoplay:true,
	navText:['<i class="fa fa-chevron-left"></i>','<i class="fa fa-chevron-right"></i>'],
    responsive:{
        0:{
            items:2
        },
        450:{
            items:3
        },
        767:{
            items:4
        },
        1000:{
            items:6
        }
    }
})

/* related-slider */ 
$('.related-slider').owlCarousel({
	loop:true,
	nav:true,
	margin:10,
	navText:['<i class="fa fa-long-arrow-left"></i>','<i class="fa fa-long-arrow-right"></i>'],
	responsive:{
		0:{
			items:1
		},
		768:{
			items:3
		},
		1000:{
			items:3
		},
		1200:{
			items:4
		}
	}
})	

$('.cab-slider').owlCarousel({
	loop:true,
	nav:true,
	margin:10,
        autoplay:true,
	navText:['<i class="fa fa-long-arrow-left"></i>','<i class="fa fa-long-arrow-right"></i>'],
	responsive:{
		0:{
			items:1
		},
		768:{
			items:1
		},
		1000:{
			items:1
		},
		1200:{
			items:1
		}
	}
})

/* details-tab */ 
$('.details-tab').owlCarousel({
	loop:true,
	nav:true,
	margin:10,
	navText:['<i class="fa fa-long-arrow-left"></i>','<i class="fa fa-long-arrow-right"></i>'],
	responsive:{
		0:{
			items:3
		},
		450:{
			items:3
		},
		767:{
			items:3
		},
		1000:{
			items:4
		}
	}
})	

/* counter */
$('.counter').counterUp({
    delay: 10,
    time: 1000
});

/* portfolio */
$('.grid').imagesLoaded( function() {
	$('.portfolio-area').on( 'click', 'button', function() {
	  var filterValue = $(this).attr('data-filter');
	  $grid.isotope({ filter: filterValue });
	});

	 var $grid = $('.grid').isotope({
	  itemSelector: '.grid-item',
	  percentPosition: true,
	  masonry: {
		// use outer width of grid-sizer for columnWidth
		columnWidth: '.grid-item'
	  }
	})
});

//for filter menu active class
$('.portfolio-menu button').on('click', function(event) {
	$(this).siblings('.active').removeClass('active');
	$(this).addClass('active');
	event.preventDefault();
});

/* image-link */
$('.image-link,.popup-link').magnificPopup({
  type: 'image',
  gallery:{
    enabled:true
  }
});

/* slider-range */ 
$( "#slider-range" ).slider({
	range: true,
	min: 0,
	max: 500,
	values: [ 75, 300 ],
	slide: function( event, ui ) {
		$( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
	}
});
$( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +
" - $" + $( "#slider-range" ).slider( "values", 1 ) );

/* showlogin toggle function */
 $( '#showlogin' ).on('click', function() {
	$( '#checkout-login' ).slideToggle(900);
 }); 
	
/* showcoupon toggle function */
 $( '#showcoupon' ).on('click', function() {
	$( '#checkout_coupon' ).slideToggle(900);
 });
	 
/* Create an account toggle function */
 $( '#cbox' ).on('click', function() {
	$( '#cbox_info' ).slideToggle(900);
 });
	 
/* Create an account toggle function */
 $( '#ship-box' ).on('click', function() {
	$( '#ship-box-info' ).slideToggle(1000);
 });	



})(jQuery);	