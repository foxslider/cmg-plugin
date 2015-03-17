<?php
namespace foxslider\models\entities;

// CMG Imports
use cmsgears\core\common\models\entities\NamedActiveRecord;

class Slider extends NamedActiveRecord {

	// Instance Methods --------------------------------------------

	public function getFullPageStr() {

		return $this->fullPage ? "yes" : "no";	
	}

	public function getScrollAutoStr() {

		return $this->scrollAuto ? "yes" : "no";	
	}

	public function getScrollManualStr() {

		return $this->scrollManual ? "yes" : "no";	
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
            [ [ 'name', 'fullPage', 'slideWidth', 'slideHeight', 'scrollAuto', 'scrollManual', 'circular' ], 'required' ],
            [ [ 'width', 'height','slideWidth', 'slideHeight' ], 'number', 'integerOnly'=>true ],
            [ 'name', 'alphanumspace' ],
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
			'scrollManual' => 'Manual Scroll',
			'circular' => 'Circular'
		];
	}

	// Static Methods ----------------------------------------------

	// yii\db\ActiveRecord
	
	public static function tableName() {
		
		return FXSTables::TABLE_SLIDER;
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