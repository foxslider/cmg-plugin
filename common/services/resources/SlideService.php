<?php
/**
 * This file is part of Foxslider Module for CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.foxslider.com/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace foxslider\common\services\resources;

// Yii Imports
use Yii;
use yii\data\Sort;

// CMG Imports
use cmsgears\core\common\services\interfaces\resources\IFileService;

use cmsgears\core\common\services\base\ResourceService;

// FXS Imports
use foxslider\common\services\interfaces\resources\ISlideService;

class SlideService extends ResourceService implements ISlideService {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	public static $modelClass = '\foxslider\common\models\resources\Slide';

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	// Protected --------------

	protected $fileService;

	// Private ----------------

	// Traits ------------------------------------------------------

	// Constructor and Initialisation ------------------------------

    public function __construct( IFileService $fileService, $config = [] ) {

		$this->fileService = $fileService;

        parent::__construct( $config );
    }

	// Instance methods --------------------------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// SlideService --------------------------

	// Data Provider ------

	public function getPage( $config = [] ) {

		$modelClass	= static::$modelClass;
		$modelTable	= $this->getModelTable();

		$sliderTable = Yii::$app->factory->get( 'fxSliderService' )->getModelTable();

		// Sorting ----------

	    $sort = new Sort([
	        'attributes' => [
				'id' => [
					'asc' => [ "$modelTable.id" => SORT_ASC ],
					'desc' => [ "$modelTable.id" => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'Id'
				],
				'slider' => [
					'asc' => [ "$sliderTable.name" => SORT_ASC ],
					'desc' => [ "$sliderTable.name" => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'Slider'
				],
				'name' => [
					'asc' => [ "$modelTable.name" => SORT_ASC ],
					'desc' => [ "$modelTable.name" => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'Name'
				],
				'title' => [
					'asc' => [ "$modelTable.title" => SORT_ASC ],
					'desc' => [ "$modelTable.title" => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'Title'
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
			'order' => "$modelTable.order"
		];

		// Result -----------

		return parent::findPage( $config );
	}

	// Read ---------------

    // Read - Models ---

	public function getBySliderId( $sliderId ) {

		$modelClass	= static::$modelClass;

		return $modelClass::findBySliderId( $sliderId );
	}

    // Read - Lists ----

    // Read - Maps -----

	// Read - Others ---

	// Create -------------

	public function create( $model, $config = [] ) {

		$image 	= isset( $config[ 'image' ] ) ? $config[ 'image' ] : null;

		$slider	= Yii::$app->factory->get( 'fxSliderService' )->getById( $model->sliderId );

		$this->fileService->saveImage( $image, [ 'model' => $model, 'attribute' => 'imageId', 'width' => $slider->slideWidth, 'height' => $slider->slideHeight ] );

		return parent::create( $model, $config );
	}

	// Update -------------

	public function update( $model, $config = [] ) {

		$image = isset( $config[ 'image' ] ) ? $config[ 'image' ] : null;

		$slider = Yii::$app->factory->get( 'fxSliderService' )->getById( $model->sliderId );

		$this->fileService->saveImage( $image, [ 'model' => $model, 'attribute' => 'imageId', 'width' => $slider->slideWidth, 'height' => $slider->slideHeight ] );

		return parent::update( $model, [
			'attributes' => [ 'imageId', 'name', 'title', 'description', 'content', 'url' ]
		]);
	}

	// Delete -------------

	public function delete( $model, $config = [] ) {

		Yii::$app->factory->get( 'fileService' )->delete( $model->image );

		return parent::delete( $model, $config );
	}

	public function deleteBySliderId( $sliderId ) {

		$modelClass = static::$modelClass;

		return $modelClass::deleteBySliderId( $sliderId );
	}

	// Bulk ---------------

	// Notifications ------

	// Cache --------------

	// Additional ---------

	// Static Methods ----------------------------------------------

	// CMG parent classes --------------------

	// SlideService --------------------------

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
