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
use yii\helpers\ArrayHelper;

// FXS Imports
use foxslider\common\models\entities\Slider;

use foxslider\widgets\assets\FxsAssets;

class FoxSliderMain extends \cmsgears\core\common\base\Widget {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	public $wrap = true;

	// FoxSlider JQuery Plugin Options
	public $fxOptions = [
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
		'slideDimMax' => true,
		'slideWidth' => 0,
		'slideHeight' => 0,
		// Slide arrangement - filmstrip, stacked
		'circular' => true,
		'slideArrangement' => 'filmstrip',
		// Resize Background Image - A good option to use img tag within the slide element
		'resizeBkgImage' => false, // Flag to check whether image need resize maintaining aspect ratio
		'bkgImageClass' => null, // The class to identity background image for maintaining aspect ratio
		// Auto Height - Take height from the img tag having bkgImageClass class within the slide element
		'autoHeight' => false,
		// Listener Callback for pre processing
		'preSlideChange' => null,
		// Listener Callback for post processing
		'postSlideChange' => null,
		'lazyLoad' => false
	];

	// Additional Configuration
	public $slideTexture = null;

	// Slider name is required if we need to load it from slider db tables. The slider can also be formed from the image urls by overriding renderSlider method.
    public $slug;

	// Content array common for all the slides. The array elements can be included within slides.
	public $genericContent = [];

	/**
	 *
	 * @var \foxslider\common\models\entities\Slider
	 */
	public $model;

	/**
	 * The JSON data stored in model.
	 *
	 * @var Object
	 */
	public $modelData;

	/**
	 * Check whether responsive images required.
	 *
	 * @var string
	 */
	public $responsiveImage = false;

	/**
	 * Check whether lazy loading is required.
	 *
	 * @var string
	 */
	public $lazyLoad = false;

	/**
	 * Check to lazy load small image.
	 *
	 * @var string
	 */
	public $lazySmall = false;

	/**
	 * The default URL used for lazy loading.
	 *
	 * @var string
	 */
	public $lazyImageUrl;

	// Protected --------------

	protected $modelService;

	// Private ----------------

	// Traits ------------------------------------------------------

	// Constructor and Initialisation ------------------------------

	public function init() {

		parent::init();

		$this->modelService = Yii::$app->factory->get( 'fxSliderService' );
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

		$this->model = $this->modelService->getBySlug( $this->slug );

		$model	= $this->model;
		$items 	= [];

		if( !isset( $model ) ) {

			return "<div>Slider having slug set to $this->slug does not exist. Please create it via admin.</div>";
        }

		// Configure
		$this->configureSlider();

		// Views Path
		$slidePath = "$this->template/slide";

		// Generate Slides Html

		$slides = $model->slides;

        foreach( $slides as $slide ) {

            $items[] = $this->render( $slidePath, [
				'widget' => $this, 'fxOptions' => $this->fxOptions, 'slide' => $slide,
				'genericContent' => $this->genericContent
			]);
        }

		// Register JS
		$modelOptions = json_encode( $this->fxOptions );

		$modelJs = "jQuery( '.fx-" . $model->slug . "' ).foxslider( $modelOptions );";

		$this->getView()->registerJs( $modelJs, View::POS_READY );

		$htmlContent = implode( "\n", $items );

		if( $this->wrap ) {

			// Apply model options - Overrides widget and template options
			$htmlOptions = json_decode( $model->htmlOptions, true );

			$options = !empty( $htmlOptions ) ? ArrayHelper::merge( $this->options, $htmlOptions ) : $this->options;

			//$options[ 'id' ] = "fxs-{$model->slug}";

			$classOption = isset( $options[ 'class' ] ) ? $options[ 'class' ] : null;
			$classOption = !empty( $classOption ) ? "fx $classOption fx-{$model->slug}" : "fx fx-{$model->slug}";

			$options[ 'class' ] = $classOption;

			return Html::tag( 'div', $htmlContent, $options );
		}

		return $htmlContent;
    }

	// FoxSliderMain -------------------------

	public function configureSlider() {

		$model = $this->model;

		$this->fxOptions[ 'autoScroll' ] = boolval( $model->scrollAuto );
		$this->fxOptions[ 'autoScrollType' ] = strtolower( Slider::$scrollTypeMap[ $model->scrollType ] );
		$this->fxOptions[ 'fullPage' ] = boolval( $model->fullPage );
		$this->fxOptions[ 'circular' ] = boolval( $model->circular );

		$data = json_decode( $model->data );

		$settings = $data->settings ?? null;

		if( !empty( $settings ) ) {

			$this->loadAssets = boolval( $settings->loadAssets );

			$this->fxOptions[ 'sliderWidth' ] = !empty( $settings->sliderWidth ) ? intval( $settings->sliderWidth ) : 0;
			$this->fxOptions[ 'sliderHeight' ] = !empty( $settings->sliderHeight ) ? intval( $settings->sliderHeight ) : 0;
			$this->fxOptions[ 'slideDimMax' ] = boolval( $settings->slideDimMax );
			$this->fxOptions[ 'slideWidth' ] = !empty( $settings->slideWidth ) ? intval( $settings->slideWidth ) : 0;
			$this->fxOptions[ 'slideHeight' ] = !empty( $settings->slideHeight ) ? intval( $settings->slideHeight ) : 0;

			$this->fxOptions[ 'bullets' ] = boolval( $settings->bullets );
			$this->fxOptions[ 'bulletsIndexing' ] = boolval( $settings->bulletsIndexing );
			$this->fxOptions[ 'bulletClass' ] = !empty( $settings->bulletClass ) ? $settings->bulletClass : null;

			$this->fxOptions[ 'controls' ] = boolval( $settings->controls );
			$this->fxOptions[ 'lControlClass' ] = !empty( $settings->lControlClass ) ? $settings->lControlClass : null;
			$this->fxOptions[ 'rControlClass' ] = !empty( $settings->rControlClass ) ? $settings->rControlClass : null;
			$this->fxOptions[ 'lControlContent' ] = !empty( $settings->lControlContent ) ? $settings->lControlContent : null;
			$this->fxOptions[ 'rControlContent' ] = !empty( $settings->rControlContent ) ? $settings->rControlContent : null;

			$this->fxOptions[ 'autoScrollDuration' ] = !empty( $settings->autoScrollDuration ) ? intval( $settings->autoScrollDuration ) : 5000;
			$this->fxOptions[ 'stopOnHover' ] = boolval( $settings->stopOnHover );

			$this->fxOptions[ 'slideArrangement' ] = $settings->slideArrangement;

			$this->fxOptions[ 'resizeBkgImage' ] = boolval( $settings->resizeBkgImage );
			$this->fxOptions[ 'bkgImageClass' ] = !empty( $settings->bkgImageClass ) ? $settings->bkgImageClass : 'fxs-bkg-img';

			$this->fxOptions[ 'autoHeight' ] = boolval( $settings->autoHeight );

			$this->fxOptions[ 'preSlideChange' ] = !empty( $settings->preSlideChange ) ? $settings->preSlideChange : null;
			$this->fxOptions[ 'postSlideChange' ] = !empty( $settings->postSlideChange ) ? $settings->postSlideChange : null;

			$this->fxOptions[ 'lazyLoad' ] = boolval( $settings->lazyLoad );

			if( !empty( $settings->slideTemplate ) ) {

				$this->template = $settings->slideTemplate;
			}

			if( !empty( $settings->slideTemplateDir ) ) {

				$this->templateDir = $settings->slideTemplateDir;
			}

			$this->slideTexture = $settings->slideTexture;

			$this->genericContent = !empty( $settings->genericContent ) ? $settings->genericContent : [];

			$this->responsiveImage = boolval( $settings->responsiveImage );
			$this->lazyLoad		= boolval( $settings->lazyLoad );
			$this->lazySmall	= boolval( $settings->lazySmall );
			$this->lazyImageUrl	= !empty( $settings->lazyImageUrl ) ? Yii::getAlias( '@images' ) . '/' . $settings->lazyImageUrl : null;
		}
	}

}
