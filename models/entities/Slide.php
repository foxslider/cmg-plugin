<?php
namespace foxslider\models\entities;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\core\common\models\entities\CmgEntity;
use cmsgears\core\common\models\entities\CmgFile;

use cmsgears\core\common\utilities\MessageUtil;

class Slide extends CmgEntity {

	// Instance Methods --------------------------------------------

	public function getImage() {

		return $this->hasOne( CmgFile::className(), [ 'id' => 'imageId' ] );
	}

	public function getSlider() {

		return $this->hasOne( Slider::className(), [ 'id' => 'sliderId' ] );
	}

	// yii\base\Model

	public function rules() {

        return [
            [ [ 'sliderId', 'name' ], 'required' ],
            [ 'name', 'alphanumhyphenspace' ],
            [ 'name', 'validateNameCreate', 'on' => [ 'create' ] ],
            [ 'name', 'validateNameUpdate', 'on' => [ 'update' ] ],
			[ [ 'url', 'description', 'content' ], 'safe' ]
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
			
			$slide = self::findByNameSliderName( $this->name, $this->sliderId );

            if( $slide ) {

				$this->addError( $attribute, MessageUtil::getMessage( CoreGlobal::ERROR_ENTRY_EXIST_NAME ) );
            }
        }
    }

    public function validateNameUpdate( $attribute, $params ) {

        if( !$this->hasErrors() ) {

			$existingSlide = self::findByNameSliderName( $this->name, $this->sliderId );

			if( isset( $existingSlide ) && $existingSlide->id != $this->id && 
				 strcmp( $existingSlide->name, $this->name ) == 0 && $existingSlide->sliderId == $this->sliderId ) {

				$this->addError( $attribute, MessageUtil::getMessage( CoreGlobal::ERROR_ENTRY_EXIST_NAME ) );
			}
        }
    }

	// Static Methods ----------------------------------------------

	// yii\db\ActiveRecord

	public static function tableName() {

		return FxsTables::TABLE_SLIDE;
	}

	// Slide -----------
	
	// Read

	public static function findById( $id ) {

		return Slide::find()->where( 'id=:id', [ ':id' => $id ] )->one();
	}

	public static function findBySliderId( $sliderId ) {

		return Slide::find()->where( 'sliderId=:id', [ ':id' => $sliderId ] )->all();
	}

	public static function findByNameSliderId( $name, $sliderId ) {

		return Slide::find()->where( 'sliderId=:id', [ ':id' => $sliderId ] )->andwhere( 'name=:name', [ ':name' => $name ] )->one();
	}

	// Delete

	public static function deleteBySliderId( $sliderId ) {
		
		self::deleteAll( "sliderId=$sliderId" );
	}
}

?>