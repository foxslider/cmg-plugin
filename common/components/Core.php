<?php
namespace foxslider\common\components;

// Yii Imports
use \Yii;
use yii\di\Container;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

class Core extends \yii\base\Component {

	// Global -----------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Constructor and Initialisation ------------------------------

    /**
     * Initialise the CMG Core Component.
     */
    public function init() {

        parent::init();

		// Foxslider Alias
		Yii::setAlias( 'foxslider', dirname( dirname( dirname( __DIR__ ) ) ) );

		// Register application components and objects i.e. CMG and Project
		$this->registerComponents();
    }

	// Instance methods --------------------------------------------

	// Yii parent classes --------------------

	// CMG parent classes --------------------

	// Core ----------------------------------

	// Properties

	// Components and Objects

	public function registerComponents() {

		// Register services
		$this->registerResourceServices();
		$this->registerEntityServices();

		// Init services
		$this->initResourceServices();
		$this->initEntityServices();
	}

	public function registerResourceServices() {

		$factory = Yii::$app->factory->getContainer();

		$factory->set( 'foxslider\common\services\interfaces\resources\ISlideService', 'foxslider\common\services\resources\SlideService' );
	}

	public function registerEntityServices() {

		$factory = Yii::$app->factory->getContainer();

		$factory->set( 'foxslider\common\services\interfaces\entities\ISliderService', 'foxslider\common\services\entities\SliderService' );
	}

	public function initResourceServices() {

		$factory = Yii::$app->factory->getContainer();

		$factory->set( 'slideService', 'foxslider\common\services\resources\SlideService' );
	}

	public function initEntityServices() {

		$factory = Yii::$app->factory->getContainer();

		$factory->set( 'sliderService', [ 'class' => 'foxslider\common\services\entities\SliderService', 'slideService' =>  $factory->get( 'slideService' ) ] );
	}
}
