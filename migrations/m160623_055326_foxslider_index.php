<?php

class m160623_055326_foxslider_index extends \yii\db\Migration {

	// Public Variables

	// Private Variables

	private $cmgPrefix;
	private $fxsPrefix;

	public function init() {

		// Fixed
		$this->cmgPrefix	= Yii::$app->migration->cmgPrefix;
		$this->fxsPrefix	= 'fxs_';
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
