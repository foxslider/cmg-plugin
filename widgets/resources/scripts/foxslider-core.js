(function( fxs ) {

	/**
	 * Notes:
	 * ----------------------------------------------------
	 * 1. Circular slider need filmstrip arrangement.
	 * 2. Non-Circular slider need stacked arrangement.
	 * 3. Auto Scroll and Circular work together.
	 */

	// Slider
	fxs.fn.foxslider = function( options ) {

		// == Init =================================================================== //

		// Configure Sliders
		var settings 		= fxs.extend( {}, fxs.fn.foxslider.defaults, options );
		var sliders			= this;

		// Iterate and initialise all the fox sliders
		sliders.each( function() {

			var slider	= fxs( this );

			init( slider );
		});

		// Autoplay
		if( settings.autoScroll ) {

			startAutoScroll();
		}

		// Windows resize
		fxs( window ).resize(function() {

			// Iterate and resize all the fox sliders
			sliders.each( function() {

				var slider	= fxs( this );

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

				var slide = fxs( this );

				slide.addClass( 'slide' );
			});

			// wrap the slides
			var sliderHtml		= "<div class='slides-wrap'>" + slider.html() + "</div>";
			sliderHtml		   += "<div class='control control-left'></div><div class='control control-right'></div>";

			if( settings.bullets ) {

				sliderHtml	   += "<div class='bullets'></div>";
			}

			slider.html( sliderHtml );
		}

		// Set Slider and Slides based on configuration params and make filmstrip of all slides
		function normaliseSlides( slider ) {

			// Calculate and set Slider Width
			var sliderWidth		= slider.width();
			var sliderHeight	= slider.height();
			var slidesWrapper	= slider.find( ".slides-wrap" );
			var slidesSelector	= slider.find( ".slide" );

			// Use settings for Slider dimensions
			if( settings.sliderWidth > 0 && settings.sliderHeight > 0 ) {

				slider.css( { 'width': settings.sliderWidth + "px", 'height': settings.sliderHeight + "px" } );

				sliderWidth		= settings.sliderWidth;
				sliderHeight	= settings.sliderHeight;
			}

			var slideWidth		= parseInt( sliderWidth );
			var slideHeight		= parseInt( sliderHeight );
			var slidesCount		= slidesSelector.length;

			// Initialise Slide Width and reposition
			var count			= 0;
			var currentPosition	= 0;

			// Use settings for Slide dimensions
			if( settings.slideWidth > 0 ) {

				slideWidth 		= parseInt( settings.slideWidth );
			}

			if( settings.slideHeight > 0 ) {

				slideHeight		= parseInt( settings.slideHeight );
			}

			if( settings.slideArrangement == 'filmstrip' ) {

				slidesWrapper.width( slideWidth * slidesCount );
			}

			// Set slides dimensions
			slidesSelector.each( function() {

				var currentSlide	= fxs( this );

				// Use settings for Slide dimensions
				if( settings.slideWidth > 0 && settings.slideHeight > 0 ) {

					currentSlide.css( { 'width': settings.slideWidth + "px", 'height': settings.slideHeight + "px" } );
				}
				else {

					currentSlide.css( { width: slideWidth } );
				}

				if( settings.slideArrangement == 'filmstrip' ) {

					currentSlide.css( 'left', currentPosition );
				}

				if( settings.slideArrangement == 'stacked' ) {

					if( count == 0 ) {

						currentSlide.show();

						slider.attr( "activeindex", count );
						slider.find( ".control-right" ).removeClass( "disabled" );
						slider.find( ".control-left" ).addClass( "disabled" );
					}
					else {

						currentSlide.hide();
					}
				}

				currentSlide.attr( "slide", count );

				currentPosition += slideWidth;
				count++;

				// Resize background image if required
				if( settings.resizeBkgImage && null != settings.bkgImageClass ) {

					var image 	= currentSlide.children( "." + settings.bkgImageClass );

					if( null != image && image.length > 0 ) {

						var slideAspectRatio	= slideWidth / slideHeight;
						var imageAspectRatio	= image[0].width / image[0].height;

						if ( slideAspectRatio > imageAspectRatio ) {

							image.removeClass( 'width-100 height-100' );
							image.addClass( 'width-100' );

							var adjust = ( image.height() - slideHeight ) / 2;

							image.css( { 'margin-top': "-" + adjust + "px" } );
						}
						else {

							image.removeClass( 'width-100 height-100' );
							image.addClass( 'height-100' );

							var adjust = ( image.width() - slideWidth ) / 2;

							image.css( { 'margin-left': "-" + adjust + "px" } );
						}
					}
				}
			});
		}

		// Initialise the Slider controls
		function initControls( slider ) {

			// Show Controls
			var controls 		= slider.find( ".controls" );
			var lControlClass	= settings.lControlClass;
			var rControlClass	= settings.rControlClass;
			var lControlContent	= settings.lControlContent;
			var rControlContent	= settings.rControlContent;

			controls.show();

			// Init Listeners
			var leftControl		= slider.find( ".control-left" );
			var rightControl	= slider.find( ".control-right" );

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

				showPrevSlide( fxs( this ).closest( ".fx-slider" ) );
			});

			rightControl.click( function() {

				showNextSlide( fxs( this ).closest( ".fx-slider" ) );
			});
		}

		// Initialise the Slider bullets
		function initBullets( slider, bulletClass ) {

			var slides			= slider.find( ".slide" );
			var slidesCount		= slides.length;
			var bullets			= slider.find( ".bullets" );

			// Generate Slider Bullets
			for( var i = 0; i < slidesCount; i++ ) {

				var bullet = null;

				if( settings.bulletsIndexing ) {

					if( null != bulletClass ) {

						bullet = "<div class='bullet " + bulletClass + "' slide='" + i + "'>" + ( i + 1 ) + "</div>";
					}
					else {

						bullet = "<div class='bullet' slide='" + i + "'>" + ( i + 1 ) + "</div>";
					}
				}
				else {

					if( null != bulletClass ) {

						bullet = "<div class='bullet " + bulletClass + "' slide='" + i + "'></div>";
					}
					else {

						bullet = "<div class='bullet' slide='" + i + "'></div>";
					}
				}

				bullets.append( bullet );
			}

			slider.find( ".bullet" ).click( function() {

				showSelectedSlide( fxs( this ) );
			});

			// set active bullet
			activateBullet( slider, 0 );
		}

		function startAutoScroll() {

			setInterval(function() {

				if( settings.autoScrollType == 'left' ) {

					sliders.each( function() {

						var slider	= fxs( this );
						var mouseIn	= slider.attr( 'mouse-over' );

						if( settings.stopOnHover && null != mouseIn && mouseIn ) {

							return;
						}

						showNextSlide( slider );
					});
				}
				else if( settings.autoScrollType == 'right' ) {

					sliders.each( function() {

						var slider	= fxs( this );
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
			var slideWidth		= parseInt( slider.css( "width" ) );
			var currentPosition	= 0;
			var filmstrip		= slider.find( ".slides-wrap" );

			// reset filmstrip
			filmstrip.css( { left: 0 + "px", 'right' : '' } );

			// Use settings for Slide dimensions
			if( settings.slideWidth > 0 && settings.slideHeight > 0 ) {

				slideWidth = parseInt( settings.slideWidth );
			}

			slidesSelector.each( function() {

				fxs( this ).css( { 'left': currentPosition + 'px', 'right' : '' } );

				currentPosition += slideWidth;
			});
		}

		// Show Previous Slide on clicking next button
		function showNextSlide( slider ) {

			if( settings.circular && settings.slideArrangement == 'filmstrip' ) {

				var slidesSelector	= slider.find( ".slide" );
				var firstSlide		= slidesSelector.first();
				var firstSlideIndex	= firstSlide.attr( "slide" );
				var slideWidth		= parseInt( slidesSelector.css( "width" ) );
				var filmstrip		= slider.find( ".slides-wrap" );

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

							var slider = fxs( this ).parent();

							// Remove first and append to last
							var slidesSelector	= slider.find( ".slide" );
							var firstSlide		= slidesSelector.first();
							firstSlide.insertAfter( slidesSelector.eq( slidesSelector.length - 1 ) );
							firstSlide.css( "right", -slideWidth );

							resetSlides( slider );

							slidesSelector		= slider.find( ".slide" );
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
			else if( settings.slideArrangement == 'stacked' ) {

				var slidesSelector	= slider.find( ".slide" );
				var currentIndex	= parseInt( slider.attr( "activeindex" ) );
				var totalSlides		= slidesSelector.length - 1;

				if( currentIndex < totalSlides ) {

					slidesSelector.eq( currentIndex ).fadeOut( 'slow' );

					currentIndex = currentIndex + 1;

					slidesSelector.eq( currentIndex ).fadeIn( 'slow' );

					slider.attr( "activeindex", currentIndex );

					// Disabled next control
					if( currentIndex == totalSlides ) {

						slider.find( ".control-right" ).addClass( "disabled" );
						slider.find( ".control-left" ).removeClass( "disabled" );
					}
					else {

						slider.find( ".control-right" ).removeClass( "disabled" );
						slider.find( ".control-left" ).removeClass( "disabled" );
					}

					// Activate Bullet
					if( settings.bullets ) {

						activateBullet( slider, currentIndex );
					}
				}
			}
		}

		// Show Next Slide on clicking previous button
		function showPrevSlide( slider ) {

			if( settings.circular && settings.slideArrangement == 'filmstrip' ) {

				var slidesSelector	= slider.find( ".slide" );
				var firstSlide		= slidesSelector.first();
				var firstSlideIndex	= firstSlide.attr( "slide" );
				var slideWidth		= parseInt( slidesSelector.css( "width" ) );
				var filmstrip		= slider.find( ".slides-wrap" );

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

							var slider = fxs( this ).parent();

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
			else if( settings.slideArrangement == 'stacked' ) {

				var slidesSelector	= slider.find( ".slide" );
				var currentIndex	= parseInt( slider.attr( "activeindex" ) );

				if( currentIndex > 0 ) {

					slidesSelector.eq( currentIndex ).fadeOut( 'slow' );

					currentIndex = currentIndex - 1;

					slidesSelector.eq( currentIndex ).fadeIn( 'slow' );

					slider.attr( "activeindex", currentIndex );

					// Disabled next control
					if( currentIndex == 0 ) {

						slider.find( ".control-right" ).removeClass( "disabled" );
						slider.find( ".control-left" ).addClass( "disabled" );
					}
					else {

						slider.find( ".control-right" ).removeClass( "disabled" );
						slider.find( ".control-left" ).removeClass( "disabled" );
					}

					// Activate Bullet
					if( settings.bullets ) {

						activateBullet( slider, currentIndex );
					}
				}
			}
		}

		// Change active Bullet
		function activateBullet( slider, bulletNum ) {

			slider.find(".bullet").removeClass( "active" );
			slider.find(".bullet[slide='" + bulletNum + "']").addClass( "active" );
		}

		// Show Slide on Bullet click
		function showSelectedSlide( bullet ) {

			var slider		= bullet.closest( ".fx-slider" );
			var bulletNum	= parseInt( bullet.attr( "slide" ) );

			if( settings.autoScroll && settings.slideArrangement == 'filmstrip' ) {

				var filmstrip		= slider.find( ".slides-wrap" );
				var slidesSelector	= slider.find( ".slide" );
				var slideWidth		= parseInt( slidesSelector.css( "width" ) );
				var slidesCount		= slidesSelector.length;

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
			else if( settings.slideArrangement == 'stacked' ) {

				var slidesSelector	= slider.find( ".slide" );
				var currentIndex	= parseInt( slider.attr( "activeindex" ) );
				var totalSlides		= slidesSelector.length - 1;

				if( bulletNum <= totalSlides ) {

					slidesSelector.eq( currentIndex ).fadeOut( 'slow' );

					slidesSelector.eq( bulletNum ).fadeIn( 'slow' );

					slider.attr( "activeindex", bulletNum );

					// Disabled next control
					if( bulletNum == totalSlides ) {

						slider.find( ".control-right" ).addClass( "disabled" );
						slider.find( ".control-left" ).removeClass( "disabled" );
					}
					else if( bulletNum == 0 ) {

						slider.find( ".control-right" ).removeClass( "disabled" );
						slider.find( ".control-left" ).addClass( "disabled" );
					}
					else {

						slider.find( ".control-right" ).removeClass( "disabled" );
						slider.find( ".control-left" ).removeClass( "disabled" );
					}

					// Activate Bullet
					if( settings.bullets ) {

						activateBullet( slider, bulletNum );
					}
				}
			}
		}
	};

	// Default Settings
	fxs.fn.foxslider.defaults = {
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
		slideWidth: 0,
		slideHeight: 0,
		// Slide arrangement - filmstrip, stacked
		circular: true,
		slideArrangement: 'filmstrip',
		// Resize Background Image
		resizeBkgImage: false,
		bkgImageClass: null,
		// Listener Callback for pre processing
		preSlideChange: null,
		// Listener Callback for post processing
		postSlideChange: null
	};

})( jQuery );