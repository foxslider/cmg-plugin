/* FoxSlider Controller */
var CONTROLLER_SLIDER			= 'slider';
var ACTION_SLIDE_UPDATE			= 'updateSlide';

// Forms --------------------------------------------------------------------------

function postFxsProcessorSuccess( formId, controllerId, actionId, data ) {

	switch( controllerId ) {
		
		case CONTROLLER_SLIDER:
		{
			switch( actionId ) {

				case ACTION_SLIDE_UPDATE:
				{
					location.reload();

					break;
				}
			}
			
			break;
		}
	}
}

if( typeof postAjaxProcessor != "undefined" ) {

	postAjaxProcessor.addSuccessListener( postFxsProcessorSuccess );	
}