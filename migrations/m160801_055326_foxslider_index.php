<?php
/**
 * This file is part of FoxSlider Module for CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

/**
 * The foxslider index migration inserts the recommended indexes for better performance. It
 * also list down other possible index commented out. These indexes can be created using
 * project based migration script.
 *
 * @since 1.0.0
 */
class m160801_055326_foxslider_index extends \cmsgears\core\common\base\Migration {

	// Public Variables

	// Private Variables

	private $cmgPrefix;
	private $fxsPrefix;

	public function init() {

		// Fixed
		$this->cmgPrefix = Yii::$app->migration->cmgPrefix;
		$this->fxsPrefix = 'fxs_';
	}

	public function up() {

		$this->upPrimary();
	}

	private function upPrimary() {

		// Slider
		$this->createIndex( 'idx_' . $this->fxsPrefix . 'slider_name', $this->fxsPrefix . 'slider', 'name' );
		$this->createIndex( 'idx_' . $this->fxsPrefix . 'slider_slug', $this->fxsPrefix . 'slider', 'slug' );

		// Slide
		$this->createIndex( 'idx_' . $this->fxsPrefix . 'slide_name', $this->fxsPrefix . 'slide', 'name' );
	}

	public function down() {

		$this->downPrimary();
	}

	private function downPrimary() {

		// Slider
		$this->dropIndex( 'idx_' . $this->fxsPrefix . 'slider_name', $this->fxsPrefix . 'slider' );
		$this->dropIndex( 'idx_' . $this->fxsPrefix . 'slider_slug', $this->fxsPrefix . 'slider' );

		// Slide
		$this->dropIndex( 'idx_' . $this->fxsPrefix . 'slide_name', $this->fxsPrefix . 'slide' );
	}

}
