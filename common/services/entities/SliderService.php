<?php
/**
 * This file is part of Foxslider Module for CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.foxslider.com/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace foxslider\common\services\entities;

// Yii Imports
use Yii;
use yii\data\Sort;

// CMG Imports
use cmsgears\core\common\services\base\EntityService;

use cmsgears\core\common\services\traits\base\ApprovalTrait;
use cmsgears\core\common\services\traits\base\NameTrait;
use cmsgears\core\common\services\traits\base\SlugTrait;

// FXS Imports
use foxslider\common\services\interfaces\entities\ISliderService;
use foxslider\common\services\interfaces\resources\ISlideService;

class SliderService extends EntityService implements ISliderService {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	public static $modelClass = '\foxslider\common\models\entities\Slider';

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	// Protected --------------

	protected $slideService;

	// Private ----------------

	// Traits ------------------------------------------------------

	use ApprovalTrait;
	use NameTrait;
	use SlugTrait;

	// Constructor and Initialisation ------------------------------

    public function __construct( ISlideService $slideService, $config = [] ) {

		$this->slideService = $slideService;

        parent::__construct( $config );
    }

	// Instance methods --------------------------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// SliderService -------------------------

	// Data Provider ------

	public function getPage( $config = [] ) {

		$modelClass	= static::$modelClass;
		$modelTable	= $this->getModelTable();

		// Sorting ----------

		$sort = new Sort([
	        'attributes' => [
				'id' => [
					'asc' => [ "$modelTable.id" => SORT_ASC ],
					'desc' => [ "$modelTable.id" => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'Id'
				],
				'name' => [
					'asc' => [ "$modelTable.name" => SORT_ASC ],
					'desc' => [ "$modelTable.name" => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'Name'
				],
				'slug' => [
					'asc' => [ "$modelTable.slug" => SORT_ASC ],
					'desc' => [ "$modelTable.slug" => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'Slug'
				],
				'title' => [
					'asc' => [ "$modelTable.title" => SORT_ASC ],
					'desc' => [ "$modelTable.title" => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'Title'
				],
	            'status' => [
	                'asc' => [ "$modelTable.status" => SORT_ASC ],
	                'desc' => [ "$modelTable.status" => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'Status'
	            ],
	            'fpage' => [
	                'asc' => [ "$modelTable.fullPage" => SORT_ASC ],
	                'desc' => [ "$modelTable.fullPage" => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'Full Page'
	            ],
	            'circular' => [
	                'asc' => [ "$modelTable.circular" => SORT_ASC ],
	                'desc' => [ "$modelTable.circular" => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'Circular'
	            ],
				'cdate' => [
					'asc' => [ "$modelTable.createdAt" => SORT_ASC ],
					'desc' => [ "$modelTable.createdAt" => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'Created At'
				],
				'udate' => [
					'asc' => [ "$modelTable.modifiedAt" => SORT_ASC ],
					'desc' => [ "$modelTable.modifiedAt" => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'Updated At'
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

		// Params
		$status	= Yii::$app->request->getQueryParam( 'status' );
		$filter	= Yii::$app->request->getQueryParam( 'model' );

		// Filter - Status
		if( isset( $status ) && isset( $modelClass::$urlRevStatusMap[ $status ] ) ) {

			$config[ 'conditions' ][ "$modelTable.status" ]	= $modelClass::$urlRevStatusMap[ $status ];
		}

		// Filter - Model
		if( isset( $filter ) ) {

			switch( $filter ) {

				case 'fpage': {

					$config[ 'conditions' ][ "$modelTable.fullPage" ] = true;

					break;
				}
				case 'circular': {

					$config[ 'conditions' ][ "$modelTable.circular" ] = true;

					break;
				}
			}
		}

		// Searching --------

		$searchCol	= Yii::$app->request->getQueryParam( 'search' );

		if( isset( $searchCol ) ) {

			$search = [
				'name' => "$modelTable.name",
				'title' =>  "$modelTable.title",
				'desc' => "$modelTable.description"
			];

			$config[ 'search-col' ] = $search[ $searchCol ];
		}

		// Reporting --------

		$config[ 'report-col' ]	= [
			'name' => "$modelTable.name",
			'title' =>  "$modelTable.title",
			'desc' => "$modelTable.description",
			'status' => "$modelTable.status",
			'fpage' => "$modelTable.fullPage",
			'circular' => "$modelTable.circular"
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

		$admin		= isset( $config[ 'admin' ] ) ? $config[ 'admin' ] : false;
		$attributes	= isset( $config[ 'attributes' ] ) ? $config[ 'attributes' ] : [ 'name', 'slug', 'title', 'description', 'width', 'height', 'slideWidth', 'slideHeight', 'fullPage', 'scrollAuto', 'scrollType', 'circular' ];

		if( $admin ) {

			$attributes[] = 'status';
		}

		return parent::update( $model, [
			'attributes' => $attributes
		]);
 	}

	// Delete -------------

	public function delete( $model, $config = [] ) {

		// Clear all related slides
		$this->slideService->deleteBySliderId( $model->id );

		// Delete Slider
		return parent::delete( $model, $config );
	}

	// Bulk ---------------

	protected function applyBulk( $model, $column, $action, $target, $config = [] ) {

		switch( $column ) {

			case 'status': {

				switch( $action ) {

					case 'confirmed': {

						$this->confirm( $model );

						break;
					}
					case 'rejected': {

						$this->reject( $model );

						break;
					}
					case 'active': {

						$this->approve( $model );

						break;
					}
					case 'frozen': {

						$this->freeze( $model );

						break;
					}
					case 'blocked': {

						$this->block( $model );

						break;
					}
				}

				break;
			}
			case 'model': {

				switch( $action ) {

					case 'fpage': {

						$model->fullPage = true;

						$model->update();

						break;
					}
					case 'circular': {

						$model->circular = true;

						$model->update();

						break;
					}
					case 'delete': {

						$this->delete( $model );

						break;
					}
				}

				break;
			}
		}
	}

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
