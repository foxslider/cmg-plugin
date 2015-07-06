<?php
namespace foxslider\common\models\entities;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\core\common\models\entities\NamedCmgEntity;

/**
 * Slider Entity
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property boolean $fullPage
 * @property integer $width
 * @property integer $height
 * @property integer $slideWidth
 * @property integer $slideHeight
 * @property boolean $scrollAuto
 * @property integer $scrollType
 * @property boolean $circular
 */
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
		
		return Yii::$app->formatter->asBoolean( $this->fullPage );	
	}

	public function getScrollAutoStr() {

		return Yii::$app->formatter->asBoolean( $this->scrollAuto );	
	}

	public function getScrollTypeStr() {

		return self::$scrollTypeMap[ $this->scrollType ];	
	}

	public function getCircularStr() {

		return Yii::$app->formatter->asBoolean( $this->circular );	
	}

	public function getSlides() {

    	return $this->hasMany( Slide::className(), [ 'sliderId' => 'id' ] );
	}

	// yii\base\Model --------------------

	public function rules() {

        return [
            [ [ 'name', 'fullPage', 'slideWidth', 'slideHeight', 'scrollAuto', 'scrollType', 'circular' ], 'required' ],
            [ [ 'description' ], 'safe' ],
            [ [ 'width', 'height', 'slideWidth', 'slideHeight' ], 'number', 'integerOnly' => true, 'min' => 0 ],
            [ 'name', 'alphanumhyphenspace' ],
            [ 'name', 'validateNameCreate', 'on' => [ 'create' ] ],
            [ 'name', 'validateNameUpdate', 'on' => [ 'update' ] ]
        ];
    }

	public function attributeLabels() {

		return [
			'name' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_NAME ),
			'desc' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_DESCRIPTION ),
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

	// yii\db\ActiveRecord ---------------
	
	public static function tableName() {
		
		return FxsTables::TABLE_SLIDER;
	}

	// Slider ----------------------------

}

?>