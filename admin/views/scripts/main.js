var fxsApp	= null;

jQuery( document ).ready( function() {

	// App
	fxsApp	= new cmt.api.Application( { basePath: ajaxUrl } );

	// Controllers
	var fxsControllers			= [];
	fxsControllers[ 'slider' ]	= 'FoxSliderController';

	// Init App
	jQuery( '[cmt-app=foxslider]' ).cmtRequestProcessor({
		app: fxsApp,
		controllers: fxsControllers
	});
});

// == FoxSlider App Controllers ==============================

// == FoxSlider Controller ================

FoxSliderController	= function() {};

FoxSliderController.inherits( cmt.api.controllers.BaseController );

FoxSliderController.prototype.updateSlideActionPost = function( success, parentElement, response ) {

	if( success ) {

		location.reload( true );
	}
};