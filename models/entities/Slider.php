<?php
namespace foxslider\models\entities;

// CMG Imports
use cmsgears\core\common\models\entities\NamedActiveRecord;

class Slider extends NamedActiveRecord {

	// Instance Methods --------------------------------------------

	// db columns

	public function getId() {

		return $this->slider_id;
	}

	public function getName() {

		return $this->slider_name;	
	}

	public function setName( $name ) {

		$this->slider_name = $name;	
	}

	public function getDesc() {

		return $this->slider_desc;	
	}

	public function setDesc( $desc ) {

		$this->slider_desc = $desc;	
	}

	public function getWidth() {

		return $this->slider_width;	
	}

	public function setWidth( $width ) {

		$this->slider_width = $width;	
	}

	public function getHeight() {

		return $this->slider_height;	
	}

	public function setHeight( $height ) {

		$this->slider_height = $height;	
	}

	public function getSlideWidth() {

		return $this->slider_slide_width;	
	}

	public function setSlideWidth( $width ) {

		$this->slider_slide_width = $width;	
	}

	public function getSlideHeight() {

		return $this->slider_slide_height;	
	}

	public function setSlideHeight( $height ) {

		$this->slider_slide_height = $height;	
	}

	public function isFullPage() {

		return $this->slider_full_page;	
	}

	public function getFullPageStr() {

		return $this->slider_full_page ? "yes" : "no";	
	}

	public function setFullPage( $fullPage ) {

		$this->slider_full_page = $fullPage;	
	}

	public function isScrollAuto() {

		return $this->slider_scroll_auto;	
	}

	public function getScrollAutoStr() {

		return $this->slider_scroll_auto ? "yes" : "no";	
	}

	public function setScrollAuto( $auto ) {

		$this->slider_scroll_auto = $auto;	
	}

	public function isScrollManual() {

		return $this->slider_scroll_manual;	
	}

	public function getScrollManualStr() {

		return $this->slider_scroll_manual ? "yes" : "no";	
	}

	public function setScrollManual( $manual ) {

		$this->slider_scroll_manual = $manual;	
	}

	public function isCircular() {

		return $this->slider_circular;	
	}

	public function getCircularStr() {

		return $this->slider_circular ? "yes" : "no";	
	}

	public function setCircular( $circular ) {

		$this->slider_circular = $circular;	
	}

	public function getSlides() {

    	return $this->hasMany( Slide::className(), [ 'slide_slider' => 'slider_id' ] );
	}

	// yii\base\Model

	public function rules() {

        return [
            [ [ 'slider_name', 'slider_full_page', 'slider_slide_width', 'slider_slide_height', 'slider_scroll_auto', 'slider_scroll_manual', 'slider_circular' ], 'required' ],
            [ [ 'slider_width', 'slider_height','slider_slide_width', 'slider_slide_height' ], 'number', 'integerOnly'=>true ],
            [ 'slider_name', 'alphanumspace' ],
            [ 'slider_name', 'validateNameCreate', 'on' => [ 'create' ] ],
            [ 'slider_name', 'validateNameUpdate', 'on' => [ 'update' ] ],
            [ [ 'slider_desc' ], 'safe' ]
        ];
    }

	public function attributeLabels() {

		return [
			'slider_name' => 'Name',
			'slider_desc' => 'Description',
			'slider_full_page' => 'Full Page',
			'slider_width' => 'Width',
			'slider_height' => 'Height',
			'slider_slide_width' => 'Slide Width',
			'slider_slide_height' => 'Slide Height',
			'slider_scroll_auto' => 'Auto Scroll',
			'slider_scroll_manual' => 'Manual Scroll',
			'slider_circular' => 'Circular'
		];
	}

	// Static Methods ----------------------------------------------

	// yii\db\ActiveRecord
	
	public static function tableName() {
		
		return FXSTables::TABLE_SLIDER;
	}

	// Slider

	public static function findById( $id ) {

		return Slider::find()->where( 'slider_id=:id', [ ':id' => $id ] )->one();
	}

	public static function findByName( $name ) {

		return Slider::find()->where( 'slider_name=:name', [ ':name' => $name ] )->one();
	}
}

?>