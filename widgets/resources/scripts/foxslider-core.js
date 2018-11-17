( function( fxsjq ) {

	var manager = null;

	var methods = {
		init: function( options ) {

			// Init Elements
			try {

				manager.resetOptions( options );

				manager.initSliders( this );
			}
			// Init Component and Elements
			catch( err ) {

				manager = new fxs.FoxSliderManager( options );
				manager.init( options );
				manager.initSliders( this );
			}

			if( null != manager ) {

				// Window resize
				fxsjq( window ).resize( function() {

					manager.normaliseSliders();
				});
			}
		},
		normaliseSlider: function() {

			var sliderKey = parseInt( jQuery( this[ 0 ] ).attr( 'ldata-id' ) );

			manager.normaliseSlider( sliderKey );
		}
	};

	/**
	 * Notes:
	 * ----------------------------------------------------
	 * 1. Circular slider need filmstrip arrangement.
	 * 2. Non-Circular slider need stacked arrangement.
	 * 3. Auto Scroll and Circular work together.
	 */

	fxsjq.fn.foxslider = function( param ) {

		// Call exclusive method
        if( methods[ param ] ) {

            return methods[ param ].apply( this, Array.prototype.slice.call( arguments, 1 ) );
        }
		// Call init
		else if( typeof param === 'object' || ! param ) {

            return methods.init.apply( this, arguments );
        }
		// Log error
		else {

            fxsjq.error( 'FoxSlider - method ' +  param + ' does not exist.' );
        }

		// return control
		return;
	};

})( jQuery );

// == Bootstrap ===========================

var fxs = fxs || {};

fxs.FoxSliderManager = function() {

	// Id Tracker
	this.counter = 1;

	// Id & Index Prefix
	this.idKey		= 'fxs-slider-';
	this.indexKey	= 'sl-';

	// All Sliders
	this.sliders = {};

	// Component Options
	this.options = null;
};

fxs.FoxSliderManager.prototype.defaults = {
	// Controls
	bullets: false,
	bulletsIndexing: false,
	bulletClass: null,
	controls: false,
	lControlClass: null,
	rControlClass: null,
	lControlContent: null,
	rControlContent: null,
	// Scrolling
	autoScroll: true,
	autoScrollType: 'left',
	autoScrollDuration: 5000,
	stopOnHover: true,
	// Full Page Background - Body Background
	fullPage: false,
	// Custom Dimensions
	sliderWidth: 0,
	sliderHeight: 0,
	slideDimMax: true, // Keep slide width and height equal to slider width and height
	slideWidth: 0,
	slideHeight: 0,
	// Slide arrangement - filmstrip, stacked
	circular: true,
	slideArrangement: 'filmstrip',
	// Resize Background Image - A good option to use img tag within the slide element
	resizeBkgImage: false, // Flag to check whether image need resize maintaining aspect ratio
	bkgImageClass: null, // The class to identity background image for maintaining aspect ratio
	// Auto Height - Take height from the img tag having bkgImageClass class within the slide element
	autoHeight: false,
	// Animation Duration
	duration: 500,
	// Listener Callback for pre processing
	preSlideChange: null,
	// Listener Callback for post processing
	postSlideChange: null,
	onSlideClick: null
};

// == Slider Manager ======================

fxs.FoxSliderManager.prototype.init = function( options ) {

	// Merge Options
	this.options = jQuery.extend( {}, this.defaults, options );
};

fxs.FoxSliderManager.prototype.resetOptions = function( options ) {

	// Merge Options
	this.options = jQuery.extend( {}, this.defaults, options );
};

fxs.FoxSliderManager.prototype.initSliders = function( elements ) {

	var self = this;

	// Iterate and initialise the jQuery elements
	elements.each( function() {

		var element = jQuery( this );

		var slider = new fxs.FoxSlider( self, element );

		slider.init();

		element.addClass( self.idKey + self.counter );
		element.attr( 'ldata-id', self.counter );

		self.sliders[ self.indexKey + self.counter ] = slider;

		self.counter++;
	});
};

fxs.FoxSliderManager.prototype.normaliseSliders = function() {

	var sliders = this.sliders;

	// Iterate and normalise all the sliders
    for( var key in sliders ) {

		sliders[ key ].normalise();
    }
};

fxs.FoxSliderManager.prototype.normaliseSlider = function( sliderKey ) {

	this.sliders[ this.indexKey + sliderKey ].normalise();
};

// == Slider ==============================

fxs.FoxSlider = function( component, element ) {

	// Component & Options
	this.component	= component;
	this.options	= component.options;

	// The Element
	this.element = element;
};

fxs.FoxSlider.prototype.init = function() {
	
	var slider		= this.element;
	var settings	= this.options;

	// Update Slider html
	this.initView();

	// Set Slider and Slides based on configuration params
	this.normalise();

	// Initialise controls
	if( settings.controls && slider.find( '.slide' ).length > 1 ) {

		this.initControls();
	}
	else {

		slider.find( '.control' ).hide();
	}

	// Initialise Bullets
	if( settings.bullets && slider.find( '.slide' ).length > 1 ) {

		this.initBullets();
	}

	if( settings.autoScroll ) {

		this.startAutoScroll();
	}

	// Mouse Listener
	slider.mouseenter( function() {

		slider.attr( 'mouse-over', true );
	});

	slider.mouseleave( function() {

		slider.attr( 'mouse-over', null );
	});
};

// Update Slider html
fxs.FoxSlider.prototype.initView = function() {

	var slider		= this.element;
	var settings	= this.options;

	// Add slide class to all the slides
	slider.children().each( function() {

		var slide = jQuery( this );

		slide.addClass( 'slide' );
	});

	// wrap the slides
	var sliderHtml = '<div class="slides-wrap">' + slider.html() + '</div>';
	
	sliderHtml += '<div class="control control-left"></div><div class="control control-right"></div>';

	if( settings.bullets ) {

		sliderHtml += '<div class="bullets"></div>';
	}

	slider.html( sliderHtml );
};

// Set Slider and Slides based on configuration params and make filmstrip of all slides
fxs.FoxSlider.prototype.normalise = function() {

	var slider		= this.element;
	var settings	= this.options;

	// Calculate and set Slider Width
	var sliderWidth		= slider.width();
	var sliderHeight	= slider.height();
	var slidesWrapper	= slider.find( '.slides-wrap' );
	var slidesSelector	= slider.find( '.slide' );
	var slidesCount		= slidesSelector.length;

	var slideWidth	= 0;
	var slideHeight	= 0;

	// Slider dimensions
	if( settings.sliderWidth > 0 ) {

		slider.css( { 'width': settings.sliderWidth + 'px' } );

		sliderWidth = settings.sliderWidth;
	}

	if( settings.sliderHeight > 0 ) {

		slider.css( { 'height': settings.sliderHeight + 'px' } );

		sliderHeight = settings.sliderHeight;
	}

	if( slidesCount > 0 && settings.autoHeight && null != settings.bkgImageClass ) {

		var heightFinder = jQuery( slidesSelector[ 0 ] ).find( '.' + settings.bkgImageClass );

		sliderHeight = jQuery( heightFinder[ 0 ] ).height();

		slider.css( { 'height': sliderHeight + 'px' } );
		slidesWrapper.css( { 'height': sliderHeight + 'px' } );
	}

	// Slide dimensions
	if( slidesCount > 0 ) {

		var slide = jQuery( slidesSelector[ 0 ] );

		slideWidth	= slide.width();
		slideHeight	= slide.height();
	}

	if( settings.slideDimMax ) {

		slideWidth	= parseInt( sliderWidth );
		slideHeight	= parseInt( sliderHeight );
	}

	// Initialise Slide Width and reposition
	var count = 0;
	
	var currentPosition	= 0;

	// Use settings for Slide dimensions
	if( settings.slideWidth > 0 ) {

		slideWidth = parseInt( settings.slideWidth );
	}

	if( settings.slideHeight > 0 ) {

		slideHeight = parseInt( settings.slideHeight );
	}

	if( settings.slideArrangement == 'filmstrip' ) {

		slidesWrapper.width( slideWidth * slidesCount );
	}

	// Set slides dimensions
	slidesSelector.each( function() {

		var currentSlide = jQuery( this );

		currentSlide.css( { width: slideWidth } );
		currentSlide.css( { height: slideHeight } );

		if( settings.slideArrangement == 'filmstrip' ) {

			currentSlide.css( 'left', currentPosition );
		}

		if( settings.slideArrangement == 'stacked' ) {

			if( count == 0 ) {

				currentSlide.show();

				slider.attr( 'activeindex', count );
				slider.find( '.control-right' ).removeClass( 'disabled' );
				slider.find( '.control-left' ).addClass( 'disabled' );
			}
			else {

				currentSlide.hide();
			}
		}

		currentSlide.attr( 'slide', count );

		currentPosition += slideWidth;
		count++;

		// Resize background image if required
		if( settings.resizeBkgImage && null != settings.bkgImageClass ) {

			var image = currentSlide.children( '.' + settings.bkgImageClass );

			if( null != image && image.length > 0 ) {

				var slideAspectRatio	= slideWidth / slideHeight;
				var imageAspectRatio	= image[0].width / image[0].height;

				if ( slideAspectRatio > imageAspectRatio ) {

					image.removeClass( 'width-100 height-100' );
					image.addClass( 'width-100' );

					var adjust = ( image.height() - slideHeight ) / 2;

					image.css( { 'margin-top': '-' + adjust + 'px' } );
				}
				else {

					image.removeClass( 'width-100 height-100' );
					image.addClass( 'height-100' );

					var adjust = ( image.width() - slideWidth ) / 2;

					image.css( { 'margin-left': '-' + adjust + 'px' } );
				}
			}
		}

		if( null !== settings.onSlideClick ) {

			// remove existing click event
			currentSlide.unbind( 'click' );

			// reset click event
			currentSlide.click( function() {

				settings.onSlideClick( slider, currentSlide, currentSlide.attr( 'slide' ) );
			});
		}
	});
};

// Initialise the Slider controls
fxs.FoxSlider.prototype.initControls = function() {
	
	var self = this;

	var slider		= this.element;
	var settings	= this.options;

	// TODO: Check slider height for vertical scrollable slider according to scroll type

	// Calculate and set Slider Width
	var sliderWidth	= slider.width();
	var slidesWidth	= slider.find( '.slides-wrap' ).width();

	if( slidesWidth < sliderWidth ) {

		slider.find( '.control' ).hide();

		return;
	}

	// Show Controls
	var controls 		= slider.find( '.controls' );
	var lControlClass	= settings.lControlClass;
	var rControlClass	= settings.rControlClass;
	var lControlContent	= settings.lControlContent;
	var rControlContent	= settings.rControlContent;

	controls.show();

	// Init Listeners
	var leftControl		= slider.find( '.control-left' );
	var rightControl	= slider.find( '.control-right' );

	if( null != lControlClass ) {

		leftControl.addClass( lControlClass );
	}

	if( null != rControlClass ) {

		rightControl.addClass( rControlClass );
	}

	if( null != lControlContent ) {

		leftControl.html( lControlContent );
	}

	if( null != rControlContent ) {

		rightControl.html( rControlContent );
	}

	leftControl.click( function() {

		self.showPrevSlide();
	});

	rightControl.click( function() {

		self.showNextSlide();
	});
};

// Initialise the Slider bullets
fxs.FoxSlider.prototype.initBullets = function() {

	var self = this;

	var slider		= this.element;
	var settings	= this.options;
	var bulletClass	= settings.bulletClass;

	var slides			= slider.find( '.slide' );
	var slidesCount		= slides.length;
	var bullets			= slider.find( '.bullets' );

	// Generate Slider Bullets
	for( var i = 0; i < slidesCount; i++ ) {

		var bullet = null;

		if( settings.bulletsIndexing ) {

			if( null != bulletClass ) {

				bullet = '<div class="bullet ' + bulletClass + '" slide="' + i + '">' + ( i + 1 ) + '</div>';
			}
			else {

				bullet = '<div class="bullet" slide="' + i + '">' + ( i + 1 ) + '</div>';
			}
		}
		else {

			if( null != bulletClass ) {

				bullet = '<div class="bullet ' + bulletClass + '" slide="' + i + '"></div>';
			}
			else {

				bullet = '<div class="bullet" slide="' + i + '"></div>';
			}
		}

		bullets.append( bullet );
	}

	slider.find( '.bullet' ).click( function() {

		self.showSelectedSlide( jQuery( this ) );
	});

	// set active bullet
	self.activateBullet( 0 );
};

fxs.FoxSlider.prototype.startAutoScroll = function() {

	var self = this;

	var slider		= this.element;
	var settings	= this.options;

	setInterval( function() {

		if( settings.autoScrollType == 'left' ) {

			var mouseIn	= slider.attr( 'mouse-over' );

			if( settings.stopOnHover && null != mouseIn && mouseIn ) {

				return;
			}

			self.showNextSlide();
		}
		else if( settings.autoScrollType == 'right' ) {

			var mouseIn	= slider.attr( 'mouse-over' );

			if( settings.stopOnHover && null != mouseIn && mouseIn ) {

				return;
			}

			self.showPrevSlide( slider );
		}

	}, settings.autoScrollDuration );
};

// == Slides Movements ==========

// Calculate and re-position slides to form filmstrip
fxs.FoxSlider.prototype.resetSlides = function() {

	var slider		= this.element;
	var settings	= this.options;

	var slidesSelector	= slider.find( '.slide' );
	var slideWidth		= slidesSelector.first().width();
	var currentPosition	= 0;
	var filmstrip		= slider.find( '.slides-wrap' );

	// reset filmstrip
	filmstrip.css( { left: 0 + 'px', 'right' : '' } );

	// Slide Width
	if( settings.slideDimMax ) {

		slideWidth = slider.width();
	}

	if( settings.slideWidth > 0 ) {

		slideWidth = parseInt( settings.slideWidth );
	}

	slidesSelector.each( function() {

		var slide = jQuery( this );

		slide.css( { 'left': currentPosition + 'px', 'right' : '' } );

		currentPosition += slideWidth;
	});
};

// Show Previous Slide on clicking next button
fxs.FoxSlider.prototype.showNextSlide = function() {
	
	var self = this;

	var slider		= this.element;
	var settings	= this.options;
	
	if( settings.circular && settings.slideArrangement == 'filmstrip' ) {

		var slidesSelector	= slider.find( '.slide' );
		var firstSlide		= slidesSelector.first();
		var firstSlideIndex	= firstSlide.attr( 'slide' );
		var slideWidth		= firstSlide.width();
		var filmstrip		= slider.find( '.slides-wrap' );

		var duration = 500;

		// do pre processing
		if( null != settings.preSlideChange ) {

			settings.preSlideChange( firstSlideIndex );
		}

		// TODO: Add animation extension and move this code to the animations extension

		if( null != settings.duration ) {

			duration = settings.duration;
		}

		// do animation - animate slider
		filmstrip.animate(
			{ left: -slideWidth },
			{
				duration: duration,
				complete: function() {

					// Remove first and append to last
					var slidesSelector	= slider.find( '.slide' );
					var firstSlide		= slidesSelector.first();

					firstSlide.insertAfter( slidesSelector.eq( slidesSelector.length - 1 ) );
					firstSlide.css( 'right', -slideWidth );

					self.resetSlides( slider );

					slidesSelector	= slider.find( '.slide' );
					firstSlide		= slidesSelector.first();
					var activeSlide	= firstSlide.attr( 'slide' );

					// Activate Bullet
					if( settings.bullets ) {

						self.activateBullet( activeSlide );
					}
				}
			}
		);

		firstSlide		= slidesSelector.first();
		firstSlideIndex	= firstSlide.attr( 'slide' );

		// do post processing
		if( null != settings.postSlideChange ) {

			settings.postSlideChange( firstSlideIndex );
		}
	}
	else if( settings.slideArrangement == 'stacked' ) {

		var slidesSelector	= slider.find( '.slide' );
		var currentIndex	= parseInt( slider.attr( 'activeindex' ) );
		var totalSlides		= slidesSelector.length - 1;

		if( currentIndex < totalSlides ) {

			slidesSelector.eq( currentIndex ).fadeOut( 'slow' );

			currentIndex = currentIndex + 1;

			slidesSelector.eq( currentIndex ).fadeIn( 'slow' );

			slider.attr( 'activeindex', currentIndex );

			// Disabled next control
			if( currentIndex == totalSlides ) {

				slider.find( '.control-right' ).addClass( 'disabled' );
				slider.find( '.control-left' ).removeClass( 'disabled' );
			}
			else {

				slider.find( '.control-right' ).removeClass( 'disabled' );
				slider.find( '.control-left' ).removeClass( 'disabled' );
			}

			// Activate Bullet
			if( settings.bullets ) {

				self.activateBullet( currentIndex );
			}
		}
	}
};

// Show Next Slide on clicking previous button
fxs.FoxSlider.prototype.showPrevSlide = function() {

	var self = this;

	var slider		= this.element;
	var settings	= this.options;
	
	if( settings.circular && settings.slideArrangement == 'filmstrip' ) {

		var slidesSelector	= slider.find( '.slide' );
		var firstSlide		= slidesSelector.first();
		var firstSlideIndex	= firstSlide.attr( 'slide' );
		var slideWidth		= firstSlide.width();
		var filmstrip		= slider.find( '.slides-wrap' );

		// do pre processing
		if( null != settings.preSlideChange ) {

			settings.preSlideChange( firstSlideIndex );
		}

		// Remove last and append to first
		var lastSlide = slidesSelector.last();
		
		lastSlide.insertBefore( slidesSelector.eq(0) );
		lastSlide.css( 'left', -slideWidth );
		
		var activeSlide = lastSlide.attr( 'slide' );

		// TODO: Add animation extension and move this code to the animations extension

		// do animation - animate slider
		filmstrip.animate(
			{ left: slideWidth },
			{
				duration: 500,
				complete: function() {

					self.resetSlides( slider );
				}
			}
		);

		// Activate Bullet
		if( settings.bullets ) {

			self.activateBullet( activeSlide );
		}

		firstSlide = slidesSelector.first();
		
		firstSlideIndex	= firstSlide.attr( 'slide' );

		// do post processing
		if( null != settings.postSlideChange ) {

			settings.postSlideChange( firstSlideIndex );
		}
	}
	else if( settings.slideArrangement == 'stacked' ) {

		var slidesSelector	= slider.find( '.slide' );
		var currentIndex	= parseInt( slider.attr( 'activeindex' ) );

		if( currentIndex > 0 ) {

			slidesSelector.eq( currentIndex ).fadeOut( 'slow' );

			currentIndex = currentIndex - 1;

			slidesSelector.eq( currentIndex ).fadeIn( 'slow' );

			slider.attr( 'activeindex', currentIndex );

			// Disabled next control
			if( currentIndex == 0 ) {

				slider.find( '.control-right' ).removeClass( 'disabled' );
				slider.find( '.control-left' ).addClass( 'disabled' );
			}
			else {

				slider.find( '.control-right' ).removeClass( 'disabled' );
				slider.find( '.control-left' ).removeClass( 'disabled' );
			}

			// Activate Bullet
			if( settings.bullets ) {

				self.activateBullet( currentIndex );
			}
		}
	}
};

// Change active Bullet
fxs.FoxSlider.prototype.activateBullet = function( bulletNum ) {

	var slider		= this.element;
	var settings	= this.options;

	slider.find( '.bullet' ).removeClass( 'active' );
	slider.find( '.bullet[slide="' + bulletNum + '"]' ).addClass( 'active' );

	// slide titles
	jQuery( '.fx-slide-titles' ).find( '.fx-slide-title' ).removeClass( 'active' );
	jQuery( '.fx-slide-titles' ).find( '.fx-slide-title[slide="' + bulletNum + '"]' ).addClass( 'active' );
}

fxs.FoxSlider.prototype.showSelectedSlide = function( bullet ) {
	
	var self = this;

	var slider		= this.element;
	var settings	= this.options;
	var bulletNum	= parseInt( bullet.attr( 'slide' ) );
	
	if( settings.autoScroll && settings.slideArrangement == 'filmstrip' ) {

		var filmstrip		= slider.find( '.slides-wrap' );
		var slidesSelector	= slider.find( '.slide' );
		var slideWidth		= slidesSelector.first().width();
		var slidesCount		= slidesSelector.length;

		var activeSlide		= slidesSelector.first();
		var activeSlideId	= parseInt( activeSlide.attr( 'slide' ) );

		self.activateBullet( bulletNum );

		if( bulletNum != activeSlideId ) {

			if( bulletNum < activeSlideId ) {

				var diff = activeSlideId - bulletNum;

				for( var i = 0; i < diff; i++ ) {

					// Remove last and append to first
					//var slidesSelector	= slider.find('.slide');
					//var lastSlide		= slidesSelector.last();
					//lastSlide.insertBefore( slidesSelector.eq(0) );
					self.showBackwardSlides();
				}

				//self.resetSlides( slider );
			}
			else {

				var diff = bulletNum - activeSlideId;

				for( var i = 0; i < diff; i++ ) {

					// Remove first and append to last
					//var slidesSelector	= slider.find('.slide');
					//var firstSlide		= slidesSelector.first();
					//firstSlide.insertAfter( slidesSelector.eq( slidesSelector.length - 1 ) );
					self.showForwardSlides();
				}

				//self.resetSlides( slider );
			}
		}
	}
	else if( settings.slideArrangement == 'stacked' ) {

		var slidesSelector	= slider.find( '.slide' );
		var currentIndex	= parseInt( slider.attr( 'activeindex' ) );
		var totalSlides		= slidesSelector.length - 1;

		if( bulletNum <= totalSlides ) {

			slidesSelector.eq( currentIndex ).fadeOut( 'slow' );

			slidesSelector.eq( bulletNum ).fadeIn( 'slow' );

			slider.attr( 'activeindex', bulletNum );

			// Disabled next control
			if( bulletNum == totalSlides ) {

				slider.find( '.control-right' ).addClass( 'disabled' );
				slider.find( '.control-left' ).removeClass( 'disabled' );
			}
			else if( bulletNum == 0 ) {

				slider.find( '.control-right' ).removeClass( 'disabled' );
				slider.find( '.control-left' ).addClass( 'disabled' );
			}
			else {

				slider.find( '.control-right' ).removeClass( 'disabled' );
				slider.find( '.control-left' ).removeClass( 'disabled' );
			}

			// Activate Bullet
			if( settings.bullets ) {

				self.activateBullet( bulletNum );
			}
		}
	}
};

fxs.FoxSlider.prototype.showBackwardSlides = function() {
	
	var self = this;

	var slider		= this.element;
	var settings	= this.options;
	
	if( settings.circular && settings.slideArrangement == 'filmstrip' ) {

		var slidesSelector	= slider.find( '.slide' );
		var firstSlide		= slidesSelector.first();
		var firstSlideIndex	= firstSlide.attr( 'slide' );
		var slideWidth		= firstSlide.width();
		var filmstrip		= slider.find( '.slides-wrap' );

		// do pre processing
		if( null != settings.preSlideChange ) {

			settings.preSlideChange( firstSlideIndex );
		}

		// Remove last and append to first
		var lastSlide = slidesSelector.last();
		
		lastSlide.insertBefore( slidesSelector.eq(0) );
		lastSlide.css( 'left', -slideWidth );
		
		var activeSlide = lastSlide.attr( 'slide' );

		// TODO: Add animation extension and move this code to the animations extension

		// do animation - animate slider
		filmstrip.animate(
			{ left: slideWidth },
			{
				duration: 200,
				complete: function() {

					self.resetSlides();
				}
			}
		);

		firstSlide = slidesSelector.first();
		
		firstSlideIndex	= firstSlide.attr( 'slide' );

		// do post processing
		if( null != settings.postSlideChange ) {

			settings.postSlideChange( firstSlideIndex );
		}
	}
};

fxs.FoxSlider.prototype.showForwardSlides = function() {

	var self = this;

	var slider		= this.element;
	var settings	= this.options;

	if( settings.circular && settings.slideArrangement == 'filmstrip' ) {

		var slidesSelector	= slider.find( '.slide' );
		var firstSlide		= slidesSelector.first();
		var firstSlideIndex	= firstSlide.attr( 'slide' );
		var slideWidth		= firstSlide.width();
		var filmstrip		= slider.find( '.slides-wrap' );
		var duration		= 1000;

		// do pre processing
		if( null != settings.preSlideChange ) {

			settings.preSlideChange( firstSlideIndex );
		}

		// do animation - animate slider
		filmstrip.animate(
			{ left: -slideWidth },
			{
				duration: duration,
				complete: function() {

					// Remove first and append to last
					var slidesSelector = slider.find( '.slide' );
					
					var firstSlide = slidesSelector.first();
					
					firstSlide.insertAfter( slidesSelector.eq( slidesSelector.length - 1 ) );
					firstSlide.css( 'right', -slideWidth );

					self.resetSlides();

					slidesSelector	= slider.find( '.slide' );
					firstSlide		= slidesSelector.first();
					var activeSlide	= firstSlide.attr( 'slide' );
				}
			}
		);

		firstSlide = slidesSelector.first();
		
		firstSlideIndex	= firstSlide.attr( 'slide' );

		// do post processing
		if( null != settings.postSlideChange ) {

			settings.postSlideChange( firstSlideIndex );
		}
	}
};
