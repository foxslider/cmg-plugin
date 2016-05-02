<?php
namespace foxslider\common\models\resources;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\core\common\models\resources\CmgFile;
use foxslider\common\models\base\FxsTables;
use foxslider\common\models\entities\Slider;

/**
 * Slide Entity
 *
 * @property integer $id
 * @property integer $sliderId
 * @property integer $imageId
 * @property string $name
 * @property string $description
 * @property string $content
 * @property string $url
 * @property integer $order
 */
class Slide extends \cmsgears\core\common\models\base\CmgEntity {

	// Variables ---------------------------------------------------

	// Constants/Statics --

	// Public -------------

	// Private/Protected --

	// Traits ------------------------------------------------------

	// Constructor and Initialisation ------------------------------

	// Instance Methods --------------------------------------------

	// yii\base\Component ----------------

	// yii\base\Model --------------------

	public function rules() {

        return [
            [ [ 'sliderId' ], 'required' ],
            [ [ 'name', 'id', 'description', 'content' ], 'safe' ],
            [ [ 'name', 'url' ], 'string', 'min' => 1, 'max' => Yii::$app->cmgCore->extraLargeText ],
            [ 'name', 'alphanumpun' ],
            [ 'name', 'validateNameCreate', 'on' => [ 'create' ] ],
            [ 'name', 'validateNameUpdate', 'on' => [ 'update' ] ],
            [ [ 'sliderId', 'imageId' ], 'number', 'integerOnly' => true, 'min' => 1 ]
        ];
    }

	public function attributeLabels() {

		return [
			'name' => 'Name',
			'description' => 'Description',
			'url' => 'Url'
		];
	}

	// Slide

    public function validateNameCreate( $attribute, $params ) {

        if( !$this->hasErrors() ) {

            if( self::isExistByNameSliderId( $this->name, $this->sliderId ) ) {

				$this->addError( $attribute, Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_EXIST ) );
            }
        }
    }

    public function validateNameUpdate( $attribute, $params ) {

        if( !$this->hasErrors() ) {

			$existingSlide = self::findByNameSliderName( $this->name, $this->sliderId );

			if( isset( $existingSlide ) && $existingSlide->id != $this->id &&
				 strcmp( $existingSlide->name, $this->name ) == 0 && $existingSlide->sliderId == $this->sliderId ) {

				$this->addError( $attribute, Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_EXIST ) );
			}
        }
    }

	// Slide -----------------------------

	public function getImage() {

		return $this->hasOne( CmgFile::className(), [ 'id' => 'imageId' ] );
	}

	public function getSlider() {

		return $this->hasOne( Slider::className(), [ 'id' => 'sliderId' ] );
	}

	// Static Methods ----------------------------------------------

	// yii\db\ActiveRecord ---------------

	public static function tableName() {

		return FxsTables::TABLE_SLIDE;
	}

	// Slide -----------------------------

	// Create -------------

	// Read ---------------

	public static function findById( $id ) {

		return Slide::find()->where( 'id=:id', [ ':id' => $id ] )->one();
	}

	public static function findBySliderId( $sliderId ) {

		return Slide::find()->where( 'sliderId=:id', [ ':id' => $sliderId ] )->all();
	}

	public static function findByNameSliderId( $name, $sliderId ) {

		return Slide::find()->where( 'sliderId=:id', [ ':id' => $sliderId ] )->andwhere( 'name=:name', [ ':name' => $name ] )->one();
	}

	/**
	 * @return boolean - check whether slide exist by name and slider id
	 */
	public static function isExistByNameSliderId( $name, $sliderId ) {

		$slide = self::findByNameSliderId( $name, $sliderId );

		return isset( $slide );
	}

	// Update -------------

	// Delete -------------

	public static function deleteBySliderId( $sliderId ) {

		self::deleteAll( "sliderId=$sliderId" );
	}
}

?>