(function( fx ) {

	// TODO: Add more options for stacking the slides for slides wrapper. The current slider works by making a filmstrip of slides. Others options could be piling the slides.

	// Slider
	fx.fn.foxslider = function( options ) {

		// == Init =================================================================== //

		// Configure Sliders
		var settings 	= fx.extend( {}, fx.fn.foxslider.defaults, options );
		var sliders		= this;

		// Iterate and initialise all the fox sliders
		sliders.each( function() {

			var slider	= fx( this );

			init( slider );
		});

		// Autoplay
		if( settings.autoScroll ) {
			
			startautoScroll();
		}

		// Windows resize
		fx( window ).resize(function() {

			// Iterate and resize all the fox sliders
			sliders.each( function() {
	
				var slider	= fx( this );
	
				normaliseSlides( slider );
			});
		});

		// return control
		return;

		// == Private Functions ===================================================== //
		
		// == Bootstrap ==================================== //

		// Initialise Slider
		function init( slider ) {

			// Update Slider html
			initSliderHtml( slider );
			
			// Set Slider and Slides based on configuration params
			normaliseSlides( slider );

			// Initialise controls
			if( settings.controls ) {

				initControls( slider );
			}
			else {

				jQuery( ".control" ).hide();
			}

			// Initialise Bullets
			if( settings.bullets ) {
	
				initBullets( slider, settings.bulletClass );
			}
			
			// Mouse Listener
			slider.mouseenter( function() {

				slider.attr( 'mouse-over', true );
			});
			
			slider.mouseleave( function() {

				slider.attr( 'mouse-over', null );
			});
		}

		// Update Slider html
		function initSliderHtml( slider ) {

			// Add slide class to all the slides
			slider.children().each( function() {
				
				var slide = fx( this );

				slide.addClass( 'slide' );
			});

			// wrap the slides
			var sliderHtml		= "<div class='slides-wrap'>" + slider.html() + "</div>";
			sliderHtml		   += "<div class='control control-left opaque-50'></div><div class='control control-right opaque-50'></div>";

			if( settings.bullets ) {

				sliderHtml	   += "<div class='bullets'></div>";				
			}

			slider.html( sliderHtml );	
		}

		// Set Slider and Slides based on configuration params and make filmstrip of all slides
		function normaliseSlides( slider ) {

			// Calculate and set Slider Width
			var sliderWidth		= slider.css( "width" );
			var slidesWrapper	= slider.find( ".slides-wrap" );
			var slidesSelector	= slider.find( ".slide" );

			// Use settings for Slider dimensions
			if( settings.sliderWidth > 0 && settings.sliderHeight > 0 ) {
				
				slider.css( { 'width': settings.sliderWidth + "px", 'height': settings.sliderHeight + "px" } );
				
				sliderWidth		= settings.sliderWidth;
			}

			var slideWidth		= parseInt( sliderWidth );
			var slidesCount		= slidesSelector.length;
			var sliderWidth		= slideWidth * slidesCount;

			slidesWrapper.width( sliderWidth );

			// Initialise Slide Width and reposition
			var count			= 0;
			var currentPosition	= 0;

			// Use settings for Slide dimensions
			if( settings.slideWidth > 0 && settings.slideHeight > 0 ) {
				
				slideWidth 		= parseInt( settings.slideWidth );
				sliderWidth		= slideWidth * slidesCount;

				slidesWrapper.width( sliderWidth );
			}
			
			// Set slides dimensions
			slidesSelector.each( function() {

				// Use settings for Slide dimensions
				if( settings.slideWidth > 0 && settings.slideHeight > 0 ) {
					
					fx( this ).css( { 'width': settings.slideWidth + "px", 'height': settings.slideHeight + "px",  left: currentPosition } );
				}
				else {

					fx( this ).css( { width: slideWidth, left: currentPosition } );
				}

				fx( this ).attr( "slide", count );
		
				currentPosition += slideWidth;
				count++;				
			});
		}
		
		// Initialise the Slider controls
		function initControls( slider ) {

			// Show Controls
			var controls 		= slider.find( ".controls" );
			var lcontrolClass	= settings.lcontrolClass;
			var rcontrolClass	= settings.rcontrolClass;
			var lcontrolContent	= settings.lcontrolContent;
			var rcontrolContent	= settings.rcontrolContent;

			controls.show();

			// Init Listeners				
			var leftControl		= slider.find( ".control-left" );
			var rightControl	= slider.find( ".control-right" );
			
			if( null != lcontrolClass ) {

				leftControl.addClass( lcontrolClass );
			}

			if( null != rcontrolClass ) {

				rightControl.addClass( rcontrolClass );
			}

			if( null != lcontrolContent ) {

				leftControl.html( lcontrolContent );
			}

			if( null != rcontrolContent ) {

				rightControl.html( rcontrolContent );
			}

			leftControl.click( function() {

				showPrevSlide( fx( this ).parent().parent() );
			});

			rightControl.click( function() {

				showNextSlide( fx( this ).parent().parent() );
			});
		}

		// Initialise the Slider bullets
		function initBullets( slider, bulletClass ) {

			var slides			= slider.find( ".slide" );
			var slidesCount		= slides.length;
			var bullets			= slider.find( ".bullets" );

			if( null != bulletClass ) {

				bullets.addClass( bulletClass );
			}

			// Generate Slider Bullets
			for( var i = 0; i < slidesCount; i++ ) {
		
				var bullet = null;
				
				if( settings.bulletsIndexing ) {
					
					bullet = "<div class='bullet' slide='" + i + "'>" + ( i + 1 ) + "</div>";
				}
				else {
					
					bullet = "<div class='bullet' slide='" + i + "'></div>";
				}
				
				bullets.append( bullet );
			}
		
			slider.find(".bullet").click( function() {
		
				showSelectedSlide( fx( this ) );
			});

			// set active bullet
			activateBullet( slider, 0 );
		}
		
		function startautoScroll() {

			setInterval(function() {
				
				if( settings.autoScrollType == 'left' ) {

					sliders.each( function() {
			
						var slider	= fx( this );
						var mouseIn	= slider.attr( 'mouse-over' );
						
						if( settings.stopOnHover && null != mouseIn && mouseIn ) {

							return;
						}

						showNextSlide( slider );
					});
				}
				else if( settings.autoScrollType == 'right' ) {

					sliders.each( function() {
			
						var slider	= fx( this );
						var mouseIn	= slider.attr( 'mouse-over' );
						
						if( settings.stopOnHover && null != mouseIn && mouseIn ) {

							return;
						}

						showPrevSlide( slider );
					});
				}

			}, settings.autoScrollDuration );
		}

		// == Slides Movements ============================= //
		
		// Calculate and re-position slides to form filmstrip
		function resetSlides( slider ) {

			var slidesSelector	= slider.find( ".slide" );
			var slideWidth		= parseInt( slider.css("width") );
			var currentPosition	= 0;
			var filmstrip		= slider.find( ".slides-wrap" );

			// reset filmstrip
			filmstrip.css( { left: 0 + "px", 'right' : '' } );

			// Use settings for Slide dimensions
			if( settings.slideWidth > 0 && settings.slideHeight > 0 ) {
				
				slideWidth = parseInt( settings.slideWidth );
			}

			slidesSelector.each( function() {
				
				fx( this ).css( { 'left': currentPosition + 'px', 'right' : '' } );

				currentPosition += slideWidth;
			});
		}

		// Show Previous Slide on clicking next button
		function showNextSlide( slider ) {

			var slidesSelector	= slider.find(".slide");
			var firstSlide		= slidesSelector.first();
			var firstSlideIndex	= firstSlide.attr( "slide" );
			var slideWidth		= parseInt( slidesSelector.css("width") );
			var filmstrip		= slider.find(".slides-wrap");

			// do pre processing
			if( null != settings.preSlideChange ) {
				
				settings.preSlideChange( firstSlideIndex );				
			}

			// TODO: Add animation extension and move this code to the animations extension

			// do animation - animate slider
			filmstrip.animate(
				{ left: -slideWidth },
				{
					duration: 500,
					complete: function() {

						var slider = fx( this ).parent();

						// Remove first and append to last
						var slidesSelector	= slider.find(".slide");
						var firstSlide		= slidesSelector.first();
						firstSlide.insertAfter( slidesSelector.eq( slidesSelector.length - 1 ) );
						firstSlide.css( "right", -slideWidth );
						
						resetSlides( slider );
						
						slidesSelector		= slider.find(".slide");
						firstSlide			= slidesSelector.first();
						var activeSlide		= firstSlide.attr( "slide" );

						// Activate Bullet
						if( settings.bullets ) {
							
							activateBullet( slider, activeSlide );
						}
					}
				}
			);

			firstSlide		= slidesSelector.first();
			firstSlideIndex	= firstSlide.attr( "slide" );

			// do post processing
			if( null != settings.postSlideChange ) {
				
				settings.postSlideChange( firstSlideIndex );				
			}
		}

		// Show Next Slide on clicking previous button
		function showPrevSlide( slider ) {

			var slidesSelector	= slider.find(".slide");
			var firstSlide		= slidesSelector.first();
			var firstSlideIndex	= firstSlide.attr( "slide" );
			var slideWidth		= parseInt( slidesSelector.css("width") );
			var filmstrip		= slider.find(".slides-wrap");

			// do pre processing
			if( null != settings.preSlideChange ) {
				
				settings.preSlideChange( firstSlideIndex );				
			}

			// Remove last and append to first
			var lastSlide		= slidesSelector.last();
			lastSlide.insertBefore( slidesSelector.eq(0) );
			lastSlide.css( "left", -slideWidth );
			var activeSlide		= lastSlide.attr( "slide" );

			// TODO: Add animation extension and move this code to the animations extension

			// do animation - animate slider
			filmstrip.animate(
				{ left: slideWidth },
				{
					duration: 500,
					complete: function() {
						
						var slider = fx( this ).parent();
						
						resetSlides( slider );
					}
				}
			);

			// Activate Bullet
			if( settings.bullets ) {

				activateBullet( slider, activeSlide );
			}
			
			firstSlide		= slidesSelector.first();
			firstSlideIndex	= firstSlide.attr( "slide" );

			// do post processing
			if( null != settings.postSlideChange ) {
				
				settings.postSlideChange( firstSlideIndex );				
			}
		}

		// Change active Bullet
		function activateBullet( slider, bulletNum ) {

			slider.find(".bullet").removeClass( "active" );
			slider.find(".bullet[slide='" + bulletNum + "']").addClass( "active" );
		}

		// Show Slide on Bullet click
		function showSelectedSlide( bullet ) {

			var slider			= bullet.parent().parent();
			var filmstrip		= slider.find(".slides-wrap");
			var slidesSelector	= slider.find(".slide");
			var slideWidth		= parseInt( slidesSelector.css("width") );
			var slidesCount		= slidesSelector.length;
			var bulletNum		= parseInt( bullet.html() ) - 1;

			var activeSlide		= slidesSelector.first();
			var activeSlideId	= parseInt( activeSlide.attr( "slide" ) );

			activateBullet( slider, bulletNum );

			if( bulletNum != activeSlideId ) {

				if( bulletNum < activeSlideId ) {
					
					var diff = activeSlideId - bulletNum;
					
					for( var i = 0; i < diff; i++ ) {

						// Remove last and append to first
						var slidesSelector	= slider.find(".slide");
						var lastSlide		= slidesSelector.last();
						lastSlide.insertBefore( slidesSelector.eq(0) );
					}
					
					resetSlides( slider );
				}
				else {
					
					var diff = bulletNum - activeSlideId;
					
					for( var i = 0; i < diff; i++ ) {

						// Remove first and append to last
						var slidesSelector	= slider.find(".slide");
						var firstSlide		= slidesSelector.first();
						firstSlide.insertAfter( slidesSelector.eq( slidesSelector.length - 1 ) );
					}

					resetSlides( slider );
				}
			}
		}
	};

	// Default Settings
	fx.fn.foxslider.defaults = {
		// Controls
		bullets: false,
		bulletsIndexing: false,
		controls: false,
		bulletClass: null,
		lcontrolClass: null,
		rcontrolClass: null,
		lcontrolContent: null,
		rcontrolContent: null,
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
		slideWidth: 0,
		slideHeight: 0,
		// Listener Callback for pre processing
		preSlideChange: null,
		// Listener Callback for post processing
		postSlideChange: null
	};

}( jQuery ) );