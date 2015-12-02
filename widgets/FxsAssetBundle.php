<?php
namespace foxslider\widgets;

// Yii Imports
use yii\web\AssetBundle;
use yii\web\View;

class FxsAssetBundle extends AssetBundle {

	// Variables ---------------------------------------------------

	// Public ----

	// Load Javascript
    public $js = [
		'scripts/foxslider-core.js'
    ];

	// Define the Position to load scripts
    public $jsOptions = [
        'position' => View::POS_END
    ];

	// Define dependent Asset Loaders
    public $depends = [
		'yii\web\JqueryAsset'
    ];

	// Constructor and Initialisation ------------------------------

	public function __construct()  {
		
		parent::__construct();

		// Path Configuration
		$this->sourcePath	= dirname( __FILE__ ) . '/resources';
	}
}

?>