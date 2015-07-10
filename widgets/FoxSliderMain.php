<?php
namespace foxslider\widgets;

// Yii Imports
use \Yii;
use yii\web\View;
use yii\base\Widget;
use yii\base\InvalidConfigException;
use yii\helpers\Html;

// FXS Imports
use foxslider\common\services\SliderService;

class FoxSliderMain extends \cmsgears\core\widgets\BaseWidget {

	// Variables ---------------------------------------------------

	// Public Variables --------------------

	// FoxSlider JQuery Plugin Options
	public $fxOptions	= [
		// Controls
		'bullets' => false,
		'bulletsIndexing' => true,
		'bulletClass' => null,
		'controls' => false,
		'lcontrolClass' => null,
		'rcontrolClass' => null,
		'lcontrolContent' => null,
		'rcontrolContent' => null,
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

	// This must be set for the first slider usage on the page.
	public $includeScripts;

	// Slider name is required if we need to load it from slider db tables. The slider can also be formed from the image urls by overriding renderSlider method.
    public $sliderName;

	// Constructor and Initialisation ------------------------------

	// yii\base\Object

    public function init() {

        parent::init();
    }

	// Instance Methods --------------------------------------------

	// yii\base\Widget

	/**
	 * @inheritdoc
	 */
    public function run() {

		// Output Javascript at the end of Page
		if( $this->includeScripts ) {

        	MainAssetBundle::register( $this->getView() );
		}

		// Additional Config
		if( isset( $this->slideTexture ) ) {

			$this->slideTexture	= "<div class='texture $this->slideTexture'></div>";
		}

		return $this->renderSlider();
    }

	// FoxSliderMain

    public function renderSlider() {

		if( !isset( $this->sliderName ) ) {

            throw new InvalidConfigException( "The 'label' option is required." );
        }

		$slider	= SliderService::findByName( $this->sliderName );
		$items 	= [];

		if( !isset( $slider ) ) {

            throw new InvalidConfigException( "Slider does not exist. Please create it via admin having name set to $this->sliderName." );
        }

		// Paths
		$slidePath		= $this->viewFile . "/slide";

		// Generate Slides Html

		$slides = $slider->slides;

        foreach( $slides as $slide ) {

            $items[] = $this->render( $slidePath, [ 'slide' => $slide ] );
        }

		// TODO: Configure from database settings

		// Register JS
		$sliderOptions	= json_encode( $this->fxOptions );
		$sliderJs		= "jQuery( '#" . $this->options['id'] . "' ).foxslider( $sliderOptions );";

		$this->getView()->registerJs( $sliderJs, View::POS_READY );

		// Return HTML
        return Html::tag( 'div', implode( "\n", $items ), $this->options );
    }
}

?>