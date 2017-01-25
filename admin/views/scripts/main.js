jQuery(document).ready( function() {

	fxsApp		= new cmt.api.Application( { basePath: ajaxUrl } );

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

FoxSliderController.prototype.updateSlideActionPost = function( success, parentElement, response ) {

	if( success ) {

		location.reload( true );
	}
};