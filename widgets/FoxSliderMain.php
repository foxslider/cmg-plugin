<?php
namespace foxslider\widgets;

use \Yii;
use yii\base\Application;
use yii\web\View;
use yii\base\Widget;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

use foxslider\services\SliderService;

class FoxSliderMain extends Widget {

	// Variables ---------------------------------------------------

	// Public Variables --------------------

	// html options for Yii Widget
	public $options 	= [];

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

	public $includeScripts;
    public $sliderName;

	// Constructor and Initialisation ------------------------------

	// yii\base\Object

    public function init() {

        parent::init();
    }

	// Instance Methods --------------------------------------------

	// yii\base\Widget

    public function run() {

        echo $this->renderSlides();
		
		$app = Yii::$app;

		// Output Javascript at the end of Page
		if( $this->includeScripts ) {

        	FoxSliderAsset::register( $this->getView() );
		}
    }

    public function renderSlides() {

		$slider	= SliderService::findByName( $this->sliderName );
		$items 	= [];

		if( isset( $slider ) ) {

			// Additional Config
			if( isset( $this->slideTexture ) ) {
				
				$this->slideTexture	= "<div class='texture $this->slideTexture'></div>";
			}

			// Generate Slides Html
		
			$slides = $slider->slides;	
	
	        foreach( $slides as $slide ) {
	
	            $items[] = $this->renderItem( $slide );
	        }

			$sliderOptions	= json_encode( $this->fxOptions );
			$sliderJs		= "jQuery( '#" . $this->options['id'] . "' ).foxslider( $sliderOptions );";

			$this->getView()->registerJs( $sliderJs, View::POS_READY );
		}
		else {

			echo "<p>Slider does not exist. Please create it via admin having name set to $this->sliderName.</p>";
		}

        return Html::tag( 'div', implode("\n", $items), $this->options );
    }

    public function renderItem( $slide ) {

		$slideImage		= $slide->image;
		$slideTitle		= $slide->name;
		$slideDesc		= $slide->description;
		$slideContent	= $slide->content;
		$slideUrl		= $slide->url;
		$slideImageUrl	= '';
		$slideImageAlt	= '';
		$bkgImage		= "<div class='slide-content'>";

		if( isset( $slideImage ) ) {

			$slideImageUrl	= $slideImage->getFileUrl();
			$slideImageAlt	= $slideImage->altText;
			$bkgImage		= "<div class='slide-content' style='background-image:url($slideImageUrl)'>";

			if( isset( $this->fxOptions[ 'resizeBkgImage' ] ) && isset( $this->fxOptions[ 'bkgImageClass' ] ) && $this->fxOptions[ 'resizeBkgImage' ] ) {

				$imgClass	= $this->fxOptions[ 'bkgImageClass' ];
				$bkgImage	= "<img src='$slideImageUrl' class='$imgClass' alt='$slideImageAlt' />
								<div class='slide-content'>";
			}
		}

		if( isset( $slideUrl ) && strlen( $slideUrl ) > 0 ) {

			$slideHtml	= "<div>
								<a href='$slideUrl'>
									$bkgImage
										$this->slideTexture
										<div class='info'>
											<h2>$slideTitle</h2>
											<p>$slideDesc</p>
										</div>
										<div class='content'>
											$slideContent
										</div>
									</div>
								</a>
							</div>";
		}
		else {

			$slideHtml	= "<div>
								$bkgImage
									$this->slideTexture
									<div class='info'>
										<h2>$slideTitle</h2>
										<p>$slideDesc</p>
									</div>
									<div class='content'>
										$slideContent
									</div>
								</div>
							</div>";
		}

		return $slideHtml;
    }
}

?>