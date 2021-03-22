<?php
/**
 * This file is part of Foxslider Module for CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.foxslider.com/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace foxslider\common\components;

// Yii Imports
use Yii;

/**
 * Core component register the services provided by Core Module.
 *
 * @since 1.0.0
 */
class Core extends \yii\base\Component {

	// Global -----------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	/**
	 * Initialize the services.
	 */
	public function init() {

		parent::init();

		// Foxslider Alias
		Yii::setAlias( 'foxslider', dirname( dirname( dirname( __DIR__ ) ) ) );

		// Register components and objects
		$this->registerComponents();
	}

	// Instance methods --------------------------------------------

	// Yii parent classes --------------------

	// CMG parent classes --------------------

	// Core ----------------------------------

	// Properties ----------------

	// Components and Objects ----

	/**
	 * Register the services.
	 */
	public function registerComponents() {

		// Register services
		$this->registerResourceServices();
		$this->registerEntityServices();

		// Init services
		$this->initResourceServices();
		$this->initEntityServices();
	}

	/**
	 * Registers resource services.
	 */
	public function registerResourceServices() {

		$factory = Yii::$app->factory->getContainer();

		$factory->set( 'foxslider\common\services\interfaces\resources\ISlideService', 'foxslider\common\services\resources\SlideService' );
	}

	/**
	 * Registers entity services.
	 */
	public function registerEntityServices() {

		$factory = Yii::$app->factory->getContainer();

		$factory->set( 'foxslider\common\services\interfaces\entities\ISliderService', 'foxslider\common\services\entities\SliderService' );
	}

	/**
	 * Initialize resource services.
	 */
	public function initResourceServices() {

		$factory = Yii::$app->factory->getContainer();

		$factory->set( 'fxSlideService', 'foxslider\common\services\resources\SlideService' );
	}

	/**
	 * Initialize entity services.
	 */
	public function initEntityServices() {

		$factory = Yii::$app->factory->getContainer();

		$factory->set( 'fxSliderService', 'foxslider\common\services\entities\SliderService' );
	}

}
