<?php
/**
 * This file is part of Foxslider Module for CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.foxslider.com/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace foxslider\common\models\resources;

// Yii Imports
use Yii;
use yii\helpers\ArrayHelper;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\core\common\models\resources\File;

// FXS Imports
use foxslider\common\models\base\FxsTables;
use foxslider\common\models\entities\Slider;

/**
 * Slide represents the slide of slider.
 *
 * @property integer $id
 * @property integer $sliderId
 * @property integer $imageId
 * @property string $name
 * @property string $title
 * @property string $texture
 * @property string $description
 * @property string $content
 * @property string $url
 * @property integer $order
 *
 * @since 1.0.0
 */
class Slide extends \cmsgears\core\common\models\base\Resource {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Traits ------------------------------------------------------

	// Constructor and Initialisation ------------------------------

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Model ---------

	/**
	 * @inheritdoc
	 */
	public function rules() {

		// Model Rules
		$rules = [
        	// Required, Safe
            [ [ 'sliderId', 'name' ], 'required' ],
            [ [ 'id', 'content' ], 'safe' ],
            // Unique
			[ [ 'sliderId', 'name' ], 'unique', 'targetAttribute' => [ 'sliderId', 'name' ] ],
            // Text Limit
			[ 'texture', 'string', 'min' => 1, 'max' => Yii::$app->core->largeText ],
            [ 'name', 'string', 'min' => 1, 'max' => Yii::$app->core->xLargeText ],
			[ [ 'title', 'url' ], 'string', 'min' => 1, 'max' => Yii::$app->core->xxxLargeText ],
            [ 'description', 'string', 'min' => 1, 'max' => Yii::$app->core->xtraLargeText ],
            // Other
            [ [ 'sliderId', 'imageId' ], 'number', 'integerOnly' => true, 'min' => 1 ]
        ];

		// Trim Text
		if( Yii::$app->core->trimFieldValue ) {

			$trim[] = [ [ 'name', 'title', 'description' ], 'filter', 'filter' => 'trim', 'skipOnArray' => true ];

			return ArrayHelper::merge( $trim, $rules );
		}

		return $rules;
    }

	public function attributeLabels() {

		return [
			'name' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_NAME ),
			'title' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_TITLE ),
			'texture' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_TEXTURE ),
			'description' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_DESCRIPTION ),
			'url' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_LINK )
		];
	}

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// Validators ----------------------------

	// Slide ---------------------------------

	/**
	 * Returns the slider associated with the slide.
	 *
	 * @return \foxslider\common\models\entities\Slider
	 */
	public function getSlider() {

		return $this->hasOne( Slider::class, [ 'id' => 'sliderId' ] );
	}

	/**
	 * Returns the image associated with the slide.
	 *
	 * @return \cmsgears\core\common\models\resources\File
	 */
	public function getImage() {

		return $this->hasOne( File::class, [ 'id' => 'imageId' ] );
	}

	// Static Methods ----------------------------------------------

	// Yii parent classes --------------------

	// yii\db\ActiveRecord ----

	/**
	 * @inheritdoc
	 */
	public static function tableName() {

		return FxsTables::getTableName( FxsTables::TABLE_SLIDE );
	}

	// CMG parent classes --------------------

	// Slide ---------------------------------

	// Read - Query -----------

	/**
	 * @inheritdoc
	 */
	public static function queryWithHasOne( $config = [] ) {

		$relations = isset( $config[ 'relations' ] ) ? $config[ 'relations' ] : [ 'slider', 'image' ];

		$config[ 'relations' ] = $relations;

		return parent::queryWithAll( $config );
	}

	/**
	 * Return query to find the slide with image.
	 *
	 * @param array $config
	 * @return \yii\db\ActiveQuery to query with image.
	 */
	public static function queryWithImage( $config = [] ) {

		$config[ 'relations' ] = [ 'image' ];

		return parent::queryWithAll( $config );
	}

	// Read - Find ------------

	/**
	 * Find and return the slides associated with given slider id.
	 *
	 * @param integer $sliderId
	 * @return Slide[]
	 */
	public static function findBySliderId( $sliderId ) {

		return Slide::find()->where( 'sliderId=:id', [ ':id' => $sliderId ] )->all();
	}

	/**
	 * Find and return the slide associated with given name and slider id.
	 *
	 * @param string $name
	 * @param integer $sliderId
	 * @return Slide[]
	 */
	public static function findByNameSliderId( $name, $sliderId ) {

		return Slide::find()->where( 'sliderId=:id', [ ':id' => $sliderId ] )->andwhere( 'name=:name', [ ':name' => $name ] )->one();
	}

	/**
	 * Check whether slide exist by name and slider id.
	 *
	 * @param string $name
	 * @param integer $sliderId
	 * @return boolean
	 */
	public static function isExistByNameSliderId( $name, $sliderId ) {

		$slide = self::findByNameSliderId( $name, $sliderId );

		return isset( $slide );
	}

	// Create -----------------

	// Update -----------------

	// Delete -----------------

	public static function deleteBySliderId( $sliderId ) {

		return self::deleteAll( 'sliderId=:id', [ ':id' => $sliderId ] );
	}

}
