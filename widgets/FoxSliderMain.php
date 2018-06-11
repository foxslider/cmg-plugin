<?php
/**
 * This file is part of FoxSlider Module for CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace foxslider\widgets;

// Yii Imports
use Yii;
use yii\web\View;
use yii\base\InvalidConfigException;
use yii\helpers\Html;

// CMG Imports
use cmsgears\core\common\base\Widget;

// FXS Imports
use foxslider\widgets\assets\FxsAssets;

class FoxSliderMain extends Widget {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	public $wrap = true;

	// FoxSlider JQuery Plugin Options
	public $fxOptions	= [
		// Controls
		'bullets' => false,
		'bulletsIndexing' => true,
		'bulletClass' => null,
		'controls' => false,
		'lControlClass' => null,
		'rControlClass' => null,
		'lControlContent' => null,
		'rControlContent' => null,
		// Scrolling
		'autoScroll' => true,
		'autoScrollType' => 'left',
		'autoScrollDuration' => 5000,
		'stopOnHover' => true,
		// Full Page Background - Body Background
		'fullPage' => false,
		// Custom Dimensions
		'sliderWidth' => 0,
		'sliderHeight' => 0,
		'slideWidth' => 0,
		'slideHeight' => 0,
		// Slide arrangement - filmstrip, stacked
		'circular' => true,
		'slideArrangement' => 'filmstrip',
		// Resize Background Image
		'resizeBkgImage' => false,
		'bkgImageClass' => null,
		// Listener Callback for pre processing
		'preSlideChange' => null,
		// Listener Callback for post processing
		'postSlideChange' => null
	];

	// Additional Configuration
	public $slideTexture	= null;

	// Slider name is required if we need to load it from slider db tables. The slider can also be formed from the image urls by overriding renderSlider method.
    public $slug;

	// Content array common for all the slides. The array elements can be included within slides.
	public $genericContent	= [];

	// Protected --------------

	protected $sliderService;

	// Private ----------------

	// Traits ------------------------------------------------------

	// Constructor and Initialisation ------------------------------

	public function init() {

		parent::init();

		$this->sliderService = Yii::$app->factory->get( 'fxSliderService' );
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Widget --------

	/**
	 * @inheritdoc
	 */
    public function run() {

		// Output Javascript at the end of Page
		if( $this->loadAssets ) {

        	FxsAssets::register( $this->getView() );
		}

		return $this->renderWidget();
    }

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

    public function renderWidget( $config = [] ) {

		if( !isset( $this->slug ) ) {

            throw new InvalidConfigException( "The slider slug option is required." );
        }

		$slider	= $this->sliderService->getBySlug( $this->slug );
		$items 	= [];

		if( !isset( $slider ) ) {

			return "<div>Slider having slug set to $this->slug does not exist. Please create it via admin.</div>";
        }

		// Views Path
		$slidePath = "$this->template/slide";

		// Generate Slides Html

		$slides = $slider->slides;

        foreach( $slides as $slide ) {

            $items[] = $this->render( $slidePath, [
            				'widget' => $this, 'fxOptions' => $this->fxOptions, 'slide' => $slide,
            				'genericContent' => $this->genericContent
            			]);
        }

		// TODO: Configure from database settings

		// Register JS
		$sliderOptions	= json_encode( $this->fxOptions );
		$sliderJs		= "jQuery( '#" . $this->options[ 'id' ] . "' ).foxslider( $sliderOptions );";

		$this->getView()->registerJs( $sliderJs, View::POS_READY );

		$htmlContent	= implode( "\n", $items );

		if( $this->wrap ) {

			return Html::tag( 'div', $htmlContent, $this->options );
		}

		return $htmlContent;
    }

	// FoxSliderMain -------------------------

}
