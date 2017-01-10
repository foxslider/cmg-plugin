<?php
namespace foxslider\common\models\resources;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\core\common\models\resources\File;
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
class Slide extends \cmsgears\core\common\models\base\Entity {

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

	public function rules() {

        return [
        	// Required, Safe
            [ [ 'sliderId' ], 'required' ],
            [ [ 'id', 'content' ], 'safe' ],
            // Unique
			[ [ 'sliderId', 'name' ], 'unique', 'targetAttribute' => [ 'sliderId', 'name' ] ],
			// Text Limit
			[ 'name', 'string', 'min' => 1, 'max' => Yii::$app->core->xLargeText ],
            [ [ 'description', 'url' ], 'string', 'min' => 1, 'max' => Yii::$app->core->xxLargeText ],
            // Other
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

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// Validators ----------------------------

	// Slide ---------------------------------

	public function getSlider() {

		return $this->hasOne( Slider::className(), [ 'id' => 'sliderId' ] );
	}

	public function getImage() {

		return $this->hasOne( File::className(), [ 'id' => 'imageId' ] );
	}

	// Static Methods ----------------------------------------------

	// Yii parent classes --------------------

	// yii\db\ActiveRecord ----

	public static function tableName() {

		return FxsTables::TABLE_SLIDE;
	}

	// CMG parent classes --------------------

	// Slide ---------------------------------

	// Read - Query -----------

	public static function queryWithAll( $config = [] ) {

		$relations				= isset( $config[ 'relations' ] ) ? $config[ 'relations' ] : [ 'slider', 'image' ];
		$config[ 'relations' ]	= $relations;

		return parent::queryWithAll( $config );
	}

	public static function queryWithImage( $config = [] ) {

		$config[ 'relations' ]	= [ 'image' ];

		return parent::queryWithAll( $config );
	}

	// Read - Find ------------

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

	// Create -----------------

	// Update -----------------

	// Delete -----------------

	public static function deleteBySliderId( $sliderId ) {

		self::deleteAll( "sliderId=$sliderId" );
	}
}
