<?php
namespace foxslider\models\entities;

// CMG Imports
use cmsgears\core\common\models\entities\NamedCmgEntity;

class Slider extends NamedCmgEntity {
	
	const SCROLL_LEFT	=  0;
	const SCROLL_RIGHT	=  5;
	const SCROLL_UP		= 10;
	const SCROLL_DOWN	= 15;

	public static $scrollTypeMap = [
		self::SCROLL_LEFT => "Left",
		self::SCROLL_RIGHT => "Right",
		self::SCROLL_UP => "Up",
		self::SCROLL_DOWN => "Down"
	];

	// Instance Methods --------------------------------------------

	public function getFullPageStr() {

		return $this->fullPage ? "yes" : "no";	
	}

	public function getScrollAutoStr() {

		return $this->scrollAuto ? "yes" : "no";	
	}

	public function getScrollTypeStr() {

		return self::$scrollTypeMap[ $this->scrollType ];	
	}

	public function getCircularStr() {

		return $this->circular ? "yes" : "no";	
	}

	public function getSlides() {

    	return $this->hasMany( Slide::className(), [ 'sliderId' => 'id' ] );
	}

	// yii\base\Model

	public function rules() {

        return [
            [ [ 'name', 'fullPage', 'slideWidth', 'slideHeight', 'scrollAuto', 'scrollType', 'circular' ], 'required' ],
            [ [ 'width', 'height','slideWidth', 'slideHeight' ], 'number', 'integerOnly'=>true ],
            [ 'name', 'alphanumhyphenspace' ],
            [ 'name', 'validateNameCreate', 'on' => [ 'create' ] ],
            [ 'name', 'validateNameUpdate', 'on' => [ 'update' ] ],
            [ [ 'description' ], 'safe' ]
        ];
    }

	public function attributeLabels() {

		return [
			'name' => 'Name',
			'desc' => 'Description',
			'full_page' => 'Full Page',
			'width' => 'Width',
			'height' => 'Height',
			'slideWidth' => 'Slide Width',
			'slideHeight' => 'Slide Height',
			'scrollAuto' => 'Auto Scroll',
			'scrollType' => 'Scroll Type',
			'circular' => 'Circular'
		];
	}

	// Static Methods ----------------------------------------------

	// yii\db\ActiveRecord
	
	public static function tableName() {
		
		return FxsTables::TABLE_SLIDER;
	}

	// Slider

	public static function findById( $id ) {

		return Slider::find()->where( 'id=:id', [ ':id' => $id ] )->one();
	}

	public static function findByName( $name ) {

		return Slider::find()->where( 'name=:name', [ ':name' => $name ] )->one();
	}
}

?>