<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace foxslider\common\services\entities;

// Yii Imports
use Yii;
use yii\data\Sort;

// CMG Imports
use cmsgears\core\common\services\base\EntityService;

use cmsgears\core\common\services\traits\base\NameTrait;
use cmsgears\core\common\services\traits\base\SlugTrait;

// FXS Imports
use foxslider\common\models\base\FxsTables;

use foxslider\common\services\interfaces\entities\ISliderService;
use foxslider\common\services\interfaces\resources\ISlideService;

class SliderService extends EntityService implements ISliderService {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	public static $modelClass	= '\foxslider\common\models\entities\Slider';

	public static $modelTable	= FxsTables::TABLE_SLIDER;

	public static $parentType	= null;

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	// Protected --------------

	protected $slideService;

	// Private ----------------

	// Traits ------------------------------------------------------

	use NameTrait;
	use SlugTrait;

	// Constructor and Initialisation ------------------------------

    public function __construct( $config = [] ) {

        parent::__construct( $config );
    }

	// Instance methods --------------------------------------------

	public function setSlideService( ISlideService $slideService ) {

		$this->slideService	= $slideService;
	}

	// Yii parent classes --------------------

	// yii\base\Component -----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// SliderService -------------------------

	// Data Provider ------

	public function getPage( $config = [] ) {

		$modelClass		= static::$modelClass;
		$modelTable		= static::$modelTable;

		// Sorting ----------

		$sort = new Sort([
	        'attributes' => [
	            'name' => [
	                'asc' => [ 'name' => SORT_ASC ],
	                'desc' => [ 'name' => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'name',
	            ]
	        ]
	    ]);

		if( !isset( $config[ 'sort' ] ) ) {

			$config[ 'sort' ] = $sort;
		}

		// Query ------------

		if( !isset( $config[ 'query' ] ) ) {

			$config[ 'hasOne' ] = true;
		}

		// Filters ----------

		// Searching --------

		$searchCol	= Yii::$app->request->getQueryParam( 'search' );

		if( isset( $searchCol ) ) {

			$search = [ 'name' => "$modelTable.name",  'title' =>  "$modelTable.title", 'slug' => "$modelTable.slug", 'template' => "$modelTable.template" ];

			$config[ 'search-col' ] = $search[ $searchCol ];
		}

		// Reporting --------

		$config[ 'report-col' ]	= [
			'name' => "$modelTable.name", 'slug' => "$modelTable.slug", 'template' => "$modelTable.template",  'active' => "$modelTable.active"
		];

		// Result -----------

		return parent::findPage( $config );
	}
	// Read ---------------

    // Read - Models ---

    // Read - Lists ----

    // Read - Maps -----

	// Read - Others ---

	// Create -------------

	// Update -------------

	public function update( $model, $config = [] ) {

		return parent::update( $model, [
			'attributes' => [ 'name', 'description', 'width', 'height', 'slideWidth', 'slideHeight', 'fullPage', 'scrollAuto', 'scrollType', 'circular' ]
		]);
 	}

	// Delete -------------

	public function delete( $model, $config = [] ) {

		// Clear all related slides
		$this->slideService->deleteBySliderId( $model->id );

		// Delete Slider
		return parent::delete( $model, $config );
	}

	protected function applyBulk( $model, $column, $action, $target, $config = [] ) {

		switch( $column ) {

			case 'model': {

				switch( $action ) {

					case 'delete': {

						$this->delete( $model );

						break;
					}
				}

				break;
			}
		}
	}

	// Bulk ---------------

	// Notifications ------

	// Cache --------------

	// Additional ---------

	// Static Methods ----------------------------------------------

	// CMG parent classes --------------------

	// SliderService -------------------------

	// Data Provider ------

	// Read ---------------

    // Read - Models ---

    // Read - Lists ----

    // Read - Maps -----

	// Read - Others ---

	// Create -------------

	// Update -------------

	// Delete -------------

}
