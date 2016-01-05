var fxsApp		= new cmt.api.Application();

jQuery(document).ready( function() {

	var appControllers				= [];

	appControllers[ 'fxslider' ]	= 'FoxSliderController';

	jQuery( ".fxs-form" ).cmtRequestProcessor({
		app: fxsApp,
		controllers: appControllers
	});
});

// FoxSliderController --------------------------------------

FoxSliderController	= function() {};

FoxSliderController.inherits( cmt.api.controllers.BaseController );

FoxSliderController.prototype.updateSlideActionPost = function( success, parentElement, message, response ) {

	if( success ) {

		location.reload( true );
	}
};