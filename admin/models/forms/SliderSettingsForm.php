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
	public $autoScrollDuration;
	public $stopOnHover;

	// Full Page Background - Body Background
	//public $fullPage; // Use fullPage from Slider Table
	// Custom Dimensions
	public $sliderWidth;
	public $sliderHeight;
	public $slideDimMax;
	public $slideWidth; // slideWidth from Slider Table is being used to crop the image
	public $slideHeight; // slideWidth from Slider Table is being used to crop the image

	// Slide arrangement - filmstrip, stacked
	//public $circular; // Use circular from Slider Table
	public $slideArrangement;
	// Resize Background Image
	public $resizeBkgImage;
	public $bkgImageClass;
	// Listener Callback for pre processing
	public $preSlideChange;
	// Listener Callback for post processing
	public $postSlideChange;

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
			[ [ 'bullets', 'controls', 'bulletsIndexing', 'stopOnHover', 'resizeBkgImage', 'slideDimMax' ], 'boolean' ],
			[ [ 'slideTemplate', 'slideTemplateDir' ], 'string', 'min' => 1, 'max' => Yii::$app->core->largeText ],
			[ [ 'bulletClass', 'lControlClass', 'rControlClass', 'bkgImageClass', 'slideTexture' ], 'string', 'min' => 1, 'max' => Yii::$app->core->xxxLargeText ],
			[ [ 'lControlContent', 'rControlContent', 'preSlideChange', 'postSlideChange' ], 'string', 'min' => 1, 'max' => Yii::$app->core->xtraLargeText ],
			[ [ 'sliderWidth', 'sliderHeight', 'slideWidth', 'slideHeight', 'autoScrollDuration' ], 'number', 'integerOnly' => true ],
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
			'resizeBkgImage' => 'Resize Background'
		];
	}

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// Validators ----------------------------

	// SliderSettingsForm --------------------

}
