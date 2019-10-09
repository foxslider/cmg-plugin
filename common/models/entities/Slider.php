<?php
/**
 * This file is part of Foxslider Module for CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.foxslider.com/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace foxslider\common\models\entities;

// Yii Imports
use Yii;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\core\common\models\interfaces\base\IApproval;
use cmsgears\core\common\models\interfaces\base\IAuthor;
use cmsgears\core\common\models\interfaces\base\IMultiSite;
use cmsgears\core\common\models\interfaces\base\IName;
use cmsgears\core\common\models\interfaces\base\ISlug;
use cmsgears\core\common\models\interfaces\resources\IData;
use cmsgears\core\common\models\interfaces\resources\IGridCache;

use cmsgears\core\common\models\base\Entity;

use cmsgears\core\common\models\traits\base\ApprovalTrait;
use cmsgears\core\common\models\traits\base\AuthorTrait;
use cmsgears\core\common\models\traits\base\MultiSiteTrait;
use cmsgears\core\common\models\traits\base\NameTrait;
use cmsgears\core\common\models\traits\base\SlugTrait;
use cmsgears\core\common\models\traits\resources\DataTrait;
use cmsgears\core\common\models\traits\resources\GridCacheTrait;

use cmsgears\core\common\behaviors\AuthorBehavior;

// FXS Imports
use foxslider\common\models\base\FxsTables;
use foxslider\common\models\resources\Slide;

/**
 * Slider stores the sliders and slider properties.
 *
 * @property integer $id
 * @property integer $siteId
 * @property integer $createdBy
 * @property integer $modifiedBy
 * @property string $name
 * @property string $slug
 * @property string $title
 * @property string $description
 * @property integer $status
 * @property boolean $fullPage
 * @property integer $slideWidth
 * @property integer $slideHeight
 * @property boolean $scrollAuto
 * @property integer $scrollType
 * @property boolean $circular
 * @property datetime $createdAt
 * @property datetime $modifiedAt
 * @property string $htmlOptions;
 * @property string $content
 * @property string $data
 * @property string $gridCache
 * @property boolean $gridCacheValid
 * @property datetime $gridCachedAt
 *
 * @since 1.0.0
 */
class Slider extends Entity implements IApproval, IAuthor, IData, IGridCache, IMultiSite, IName, ISlug {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	const SCROLL_LEFT	=  0;
	const SCROLL_RIGHT	=  5;
	const SCROLL_UP		= 10;
	const SCROLL_DOWN	= 15;

	// Public -----------------

	public static $scrollTypeMap = [
		self::SCROLL_LEFT => 'Left',
		self::SCROLL_RIGHT => 'Right',
		self::SCROLL_UP => 'Up',
		self::SCROLL_DOWN => 'Down'
	];

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Traits ------------------------------------------------------

	use ApprovalTrait;
	use AuthorTrait;
	use DataTrait;
	use GridCacheTrait;
	use MultiSiteTrait;
	use NameTrait;
	use SlugTrait;

	// Constructor and Initialisation ------------------------------

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	/**
	 * @inheritdoc
	 */
	public function behaviors() {

		return [
			'authorBehavior' => [
				'class' => AuthorBehavior::class
			],
			'timestampBehavior' => [
				'class' => TimestampBehavior::class,
				'createdAtAttribute' => 'createdAt',
				'updatedAtAttribute' => 'modifiedAt',
				'value' => new Expression('NOW()')
			],
			'sluggableBehavior' => [
				'class' => SluggableBehavior::class,
				'attribute' => 'name',
				'slugAttribute' => 'slug', // Unique for Site Id
				'ensureUnique' => true,
				'uniqueValidator' => [ 'targetAttribute' => 'siteId' ]
			]
		];
	}

	// yii\base\Model ---------

	/**
	 * @inheritdoc
	 */
	public function rules() {

		// Model Rules
		$rules = [
            // Required, Safe
            [ [ 'name', 'fullPage', 'slideWidth', 'slideHeight', 'scrollAuto', 'scrollType', 'circular' ], 'required' ],
            [ [ 'id', 'htmlOptions', 'content', 'data', 'gridCache' ], 'safe' ],
            // Text Limit
            [ 'name', 'string', 'min' => 1, 'max' => Yii::$app->core->xLargeText ],
            [ 'slug', 'string', 'min' => 1, 'max' => Yii::$app->core->xxLargeText ],
			[ 'title', 'string', 'min' => 1, 'max' => Yii::$app->core->xxxLargeText ],
            [ 'description', 'string', 'min' => 1, 'max' => Yii::$app->core->xtraLargeText ],
            // Other
            [ [ 'status', 'slideWidth', 'slideHeight', 'scrollType' ], 'number', 'integerOnly' => true, 'min' => 0 ],
            [ [ 'fullPage', 'scrollAuto', 'circular' ], 'boolean' ],
            [ [ 'siteId', 'createdBy', 'modifiedBy' ], 'number', 'integerOnly' => true, 'min' => 1 ],
            [ [ 'createdAt', 'modifiedAt', 'gridCachedAt' ], 'date', 'format' => Yii::$app->formatter->datetimeFormat ]
        ];

		// Trim Text
		if( Yii::$app->core->trimFieldValue ) {

			$trim[] = [ [ 'name', 'title', 'description' ], 'filter', 'filter' => 'trim', 'skipOnArray' => true ];

			return ArrayHelper::merge( $trim, $rules );
		}

		return $rules;
    }

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {

		return [
			'siteId' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_SITE ),
			'name' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_NAME ),
			'slug' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_SLUG ),
			'title' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_TITLE ),
			'description' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_DESCRIPTION ),
			'full_page' => 'Full Page',
			'slideWidth' => 'Slide Width',
			'slideHeight' => 'Slide Height',
			'scrollAuto' => 'Auto Scroll',
			'scrollType' => 'Scroll Type',
			'circular' => 'Circular',
			'htmlOptions' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_HTML_OPTIONS ),
			'content' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_CONTENT ),
			'data' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_DATA ),
			'gridCache' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_GRID_CACHE )
		];
	}

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// Validators ----------------------------

	// Slider --------------------------------

	/**
	 * Returns the slides associated with the slider.
	 *
	 * @return \foxslider\common\models\resources\Slide[]
	 */
	public function getSlides() {

    	return $this->hasMany( Slide::className(), [ 'sliderId' => 'id' ] )
				->orderBy( 'order DESC' );
	}

	/**
	 * Returns string representation of full page flag.
	 *
	 * @return string
	 */
	public function getFullPageStr() {

		return Yii::$app->formatter->asBoolean( $this->fullPage );
	}

	/**
	 * Returns string representation of auto scroll flag.
	 *
	 * @return string
	 */
	public function getScrollAutoStr() {

		return Yii::$app->formatter->asBoolean( $this->scrollAuto );
	}

	/**
	 * Returns string representation of scroll type.
	 *
	 * @return string
	 */
	public function getScrollTypeStr() {

		return self::$scrollTypeMap[ $this->scrollType ];
	}

	/**
	 * Returns string representation of circular flag.
	 *
	 * @return string
	 */
	public function getCircularStr() {

		return Yii::$app->formatter->asBoolean( $this->circular );
	}

	// Static Methods ----------------------------------------------

	// Yii parent classes --------------------

	// yii\db\ActiveRecord ----

	/**
	 * @inheritdoc
	 */
	public static function tableName() {

		return FxsTables::getTableName( FxsTables::TABLE_SLIDER );
	}

	// CMG parent classes --------------------

	// Slider --------------------------------

	// Read - Query -----------

	/**
	 * @inheritdoc
	 */
	public static function queryWithHasOne( $config = [] ) {

		$relations				= isset( $config[ 'relations' ] ) ? $config[ 'relations' ] : [ 'creator' ];
		$config[ 'relations' ]	= $relations;

		return parent::queryWithAll( $config );
	}

	/**
	 * Return query to find the slider with slides.
	 *
	 * @param array $config
	 * @return \yii\db\ActiveQuery to query with slides.
	 */
	public static function queryWithSlides( $config = [] ) {

		$config[ 'relations' ]	= [ 'slides' ];

		return parent::queryWithAll( $config );
	}

	// Read - Find ------------

	// Create -----------------

	// Update -----------------

	// Delete -----------------
}
