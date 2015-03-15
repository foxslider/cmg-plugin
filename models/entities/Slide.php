<?php
namespace foxslider\models\entities;

// Yii Imports
use yii\db\ActiveRecord;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\core\common\models\entities\CmgFile;

use cmsgears\core\common\utilities\MessageUtil;

class Slide extends ActiveRecord {

	// Instance Methods --------------------------------------------
	
	// db columns

	public function getId() {

		return $this->slide_id;
	}

	public function getSlideImageId() {

		return $this->slide_image;
	}

	public function setSlideImageId( $imageId ) {

		$this->slide_image = $imageId;
	}

	public function getSlideImage() {

		return $this->hasOne( CmgFile::className(), [ 'file_id' => 'slide_image' ] );
	}

	public function getSliderId() {

		return $this->slide_slider;
	}

	public function setSliderId( $sliderId ) {

		$this->slide_slider = $sliderId;
	}

	public function getSlider() {

		return $this->hasOne( Slider::className(), [ 'slider_id' => 'slide_slider' ] );
	}

	public function getName() {

		return $this->slide_name;
	}

	public function setName( $name ) {

		$this->slide_name = $name;
	}

	public function getDesc() {

		return $this->slide_desc;
	}

	public function setDesc( $desc ) {

		$this->slide_desc = $desc;
	}

	public function getContent() {

		return $this->slide_content;
	}

	public function setContent( $content ) {

		$this->slide_content = $content;
	}

	public function getUrl() {

		return $this->slide_url;
	}

	public function setUrl( $url ) {

		$this->slide_url = $url;
	}

	// yii\base\Model

	public function rules() {

        return [
            [ [ 'slide_slider', 'slide_name' ], 'required' ],
            [ 'slide_name', 'alphanumspace' ],
            [ 'slide_name', 'validateNameCreate', 'on' => [ 'create' ] ],
            [ 'slide_name', 'validateNameUpdate', 'on' => [ 'update' ] ],
			[ [ 'slide_url', 'slide_desc', 'slide_content' ], 'safe' ]
        ];
    }

	public function attributeLabels() {

		return [
			'slide_name' => 'Name',
			'slide_desc' => 'Description',
			'slide_url' => 'Url'
		];
	}

	// Slide

    public function validateNameCreate( $attribute, $params ) {

        if( !$this->hasErrors() ) {
			
			$slide = self::findByNameSliderName( $this->slide_name, $this->slide_slider );

            if( $slide ) {

				$this->addError( $attribute, MessageUtil::getMessage( CoreGlobal::ERROR_ENTRY_EXIST_NAME ) );
            }
        }
    }

    public function validateNameUpdate( $attribute, $params ) {

        if( !$this->hasErrors() ) {

			$existingSlide = self::findByNameSliderName( $this->slide_name, $this->slide_slider );

			if( isset( $existingSlide ) && $existingSlide->getId() != $this->getId() && 
				 strcmp( $existingSlide->slide_name, $this->slide_name ) == 0 && $existingSlide->slide_slider == $this->slide_slider ) {

				$this->addError( $attribute, MessageUtil::getMessage( CoreGlobal::ERROR_ENTRY_EXIST_NAME ) );
			}
        }
    }

	// Static Methods ----------------------------------------------

	// yii\db\ActiveRecord

	public static function tableName() {

		return FXSTables::TABLE_SLIDE;
	}

	// Slide -----------
	
	// Read

	public static function findById( $id ) {

		return Slide::find()->where( 'slide_id=:id', [ ':id' => $id ] )->one();
	}

	public static function findBySliderId( $sliderId ) {

		return Slide::find()->where( 'slide_slider=:id', [ ':id' => $sliderId ] )->all();
	}

	public static function findByNameSliderId( $name, $sliderId ) {

		return Slide::find()->where( 'slide_slider=:id', [ ':id' => $sliderId ] )->andwhere( 'slide_name=:name', [ ':name' => $name ] )->one();
	}

	// Delete

	public static function deleteBySliderId( $sliderId ) {
		
		self::deleteAll( "slide_slider=$sliderId" );
	}
}

?>