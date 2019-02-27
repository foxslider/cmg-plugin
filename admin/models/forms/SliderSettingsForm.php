<?php
/**
 * This file is part of Foxslider Module for CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.foxslider.com/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace foxslider\admin\models\forms;

// Yii Imports
use Yii;

// CMG Imports
use cmsgears\core\common\models\forms\DataModel;

/**
 * SliderSettingsForm provide slider settings data.
 *
 * @since 1.0.0
 */
class SliderSettingsForm extends DataModel {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	// Load assets
	public $loadAssets;

	// Controls
	public $bullets;
	public $bulletsIndexing;
	public $bulletClass;
	public $controls;
	public $lControlClass;
	public $rControlClass;
	public $lControlContent;
	public $rControlContent;

	// Scrolling
	//public $autoScroll; // Use scrollAuto from Slider Table
	//public $autoScrollType; // Use scrollType from Slider Table
	public $autoScrollDuration = 5000; // 5000 ms
	public $stopOnHover = true;

	// Full Page Background - Body Background
	//public $fullPage; // Use fullPage from Slider Table
	// Custom Dimensions
	public $sliderWidth = 0;
	public $sliderHeight = 0;
	public $slideDimMax = true;
	public $slideWidth = 0; // slideWidth from Slider Table is being used to crop the image
	public $slideHeight = 0; // slideWidth from Slider Table is being used to crop the image

	// Slide arrangement - filmstrip, stacked
	//public $circular; // Use circular from Slider Table
	public $slideArrangement = 'filmstrip';

	// Resize Background Image
	public $resizeBkgImage;
	public $bkgImageClass;

	// Auto Height
	public $autoHeight;

	// Animation Duration
	public $duration = 500; // 500 ms

	// Listener Callback for pre processing
	public $preSlideChange;
	// Listener Callback for post processing
	public $postSlideChange;
	// Listener Callback on slide click
	public $onSlideClick;

	public $slideTemplate;
	public $slideTemplateDir;

	public $slideTexture;

	public $genericContent;

	// Protected --------------

	// Private ----------------

	// Traits ------------------------------------------------------

	// Constructor and Initialisation ------------------------------

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Model ---------

	/**
	 * @inheritdoc
	 */
	public function rules() {

		return [
			[ [ 'genericContent' ], 'safe' ],
			[ [ 'loadAssets', 'bullets', 'controls', 'bulletsIndexing', 'stopOnHover', 'resizeBkgImage', 'slideDimMax', 'autoHeight' ], 'boolean' ],
			[ [ 'slideTemplate', 'slideTemplateDir' ], 'string', 'min' => 1, 'max' => Yii::$app->core->largeText ],
			[ [ 'bulletClass', 'lControlClass', 'rControlClass', 'bkgImageClass', 'slideTexture' ], 'string', 'min' => 1, 'max' => Yii::$app->core->xxxLargeText ],
			[ [ 'lControlContent', 'rControlContent', 'preSlideChange', 'postSlideChange', 'onSlideClick' ], 'string', 'min' => 1, 'max' => Yii::$app->core->xtraLargeText ],
			[ [ 'sliderWidth', 'sliderHeight', 'slideWidth', 'slideHeight', 'autoScrollDuration', 'duration' ], 'number', 'integerOnly' => true ],
			[ [ 'slideArrangement' ], 'string', 'min' => 1, 'max' => Yii::$app->core->mediumText ]
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {

		return [
			'lControlClass' => 'Left Control Class',
			'rControlClass' => 'Right Control Class',
			'lControlContent' => 'Left Control Content',
			'rControlContent' => 'Right Control Content',
			'slideDimMax' => 'Max Slide',
			'resizeBkgImage' => 'Resize Background',
			'duration' => 'Scroll Duration',
			'onSlideClick' => 'Slide Click Listener'
		];
	}

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// Validators ----------------------------

	// SliderSettingsForm --------------------

}
