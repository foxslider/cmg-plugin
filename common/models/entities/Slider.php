<?php
namespace foxslider\common\models\entities;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use foxslider\common\models\base\FxsTables;
use foxslider\common\models\resources\Slide;

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
class Slider extends \cmsgears\core\common\models\base\NamedCmgEntity {

	// Variables ---------------------------------------------------

	// Constants/Statics --

	const SCROLL_LEFT	=  0;
	const SCROLL_RIGHT	=  5;
	const SCROLL_UP		= 10;
	const SCROLL_DOWN	= 15;

	public static $scrollTypeMap = [
		self::SCROLL_LEFT => 'Left',
		self::SCROLL_RIGHT => 'Right',
		self::SCROLL_UP => 'Up',
		self::SCROLL_DOWN => 'Down'
	];

	// Public -------------

	// Private/Protected --

	// Traits ------------------------------------------------------

	// Constructor and Initialisation ------------------------------

	// Instance Methods --------------------------------------------

	// yii\base\Component ----------------

	// yii\base\Model --------------------

	public function rules() {

        return [
            [ [ 'name', 'fullPage', 'slideWidth', 'slideHeight', 'scrollAuto', 'scrollType', 'circular' ], 'required' ],
            [ [ 'name', 'description' ], 'string', 'min' => 1, 'max' => Yii::$app->cmgCore->extraLargeText ],
            [ 'name', 'alphanumpun' ],
            [ 'name', 'validateNameCreate', 'on' => [ 'create' ] ],
            [ 'name', 'validateNameUpdate', 'on' => [ 'update' ] ],
            [ [ 'width', 'height', 'slideWidth', 'slideHeight' ], 'number', 'integerOnly' => true, 'min' => 0 ],
            [ [ 'fullPage', 'scrollAuto', 'circular' ], 'boolean' ]
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

	// Slider ----------------------------

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

	// Static Methods ----------------------------------------------

	// yii\db\ActiveRecord ---------------

	public static function tableName() {

		return FxsTables::TABLE_SLIDER;
	}

	// Slider ----------------------------

	// Create -------------

	// Read ---------------

	// Update -------------

	// Delete -------------
}

?>