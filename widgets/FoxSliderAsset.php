<?php
namespace foxslider\widgets;

// Yii Imports
use yii\web\AssetBundle;
use yii\web\View;

class FoxSliderAsset extends AssetBundle {

	// Constructor and Initialisation ------------------------------

	public function __construct()  {

		parent::__construct();

		// Path Configuration

	    $this->sourcePath = dirname( __DIR__ ) . '/widgets/resources';

		// Load CSS
 
	    $this->css     = [

	    ];

		// Load Javascript

	    $this->js      = [
	            "foxslider-core.js"
	    ];

		// Define the Position to load Assets
	    $this->jsOptions = [
	        "position" => View::POS_END
	    ];

		// Define dependent Asset Loaders
	    $this->depends = [
			'yii\web\JqueryAsset'
	    ];
	}
}

?>