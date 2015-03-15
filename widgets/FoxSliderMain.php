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

	public $options 	= [];
	public $fxOptions	= [];
	public $includeScripts;
	public $uploadUrl;
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

		$slideImage		= $slide->slideImage;
		$slideTitle		= $slide->getName();
		$slideDesc		= $slide->getDesc();
		$slideUrl		= $slide->getUrl();
		$slideImageUrl	= $this->uploadUrl . $slideImage->getUrl();
		$slideImageAlt	= $slideImage->getAltText();

		if( isset( $slideUrl ) && strlen( $slideUrl ) > 0 ) {

			$slideHtml	= "<div><a href='$slideUrl'><img src='$slideImageUrl' alt='$slideImageAlt' /></a><span class='title'>$slideTitle</span><span class='description'>$slideDesc</span></div>";
		}
		else {

			$slideHtml	= "<div><img src='$slideImageUrl' alt='$slideImageAlt' /><span class='title'>$slideTitle</span><span class='description'>$slideDesc</span></div>";
		}

		return $slideHtml;
    }
}

?>