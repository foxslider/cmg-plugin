<?php
namespace foxslider\widgets\assets;

// Yii Imports
use yii\web\View;

class FxsAssets extends \yii\web\AssetBundle {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

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

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Traits ------------------------------------------------------

	// Constructor and Initialisation ------------------------------

	public function init()  {

		// Path Configuration
		$this->sourcePath	= dirname( __DIR__ ) . '/resources';

		parent::init();
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// FxsAssets -----------------------------

	// Static Methods ----------------------------------------------

	// Yii parent classes --------------------

	// CMG parent classes --------------------

	// FxsAssets -----------------------------

}
