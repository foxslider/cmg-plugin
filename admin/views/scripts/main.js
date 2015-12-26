jQuery(document).ready( function() {

	var appControllers				= [];

	appControllers[ 'fxslider' ]	= 'FoxSliderController';

	jQuery( ".fxs-form" ).processAjax({
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