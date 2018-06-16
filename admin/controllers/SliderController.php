<?php
/**
 * This file is part of Foxslider Module for CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.foxslider.com/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace foxslider\admin\controllers;

// Yii Imports
use Yii;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

// FXS Imports
use foxslider\common\config\FxsCoreGlobal;

use foxslider\admin\models\forms\SliderSettingsForm;
use foxslider\common\models\entities\Slider;

use cmsgears\core\admin\controllers\base\CrudController;

/**
 * SliderController provides actions specific to slider model.
 *
 * @since 1.0.0
 */
class SliderController extends CrudController {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Protected --------------

	protected $slideService;

	// Private ----------------

	// Constructor and Initialisation ------------------------------

 	public function init() {

        parent::init();

		// Permissions
		$this->crudPermission = FxsCoreGlobal::PERM_SLIDER;

		// Sidebar
		$this->sidebar = [ 'parent' => 'sidebar-fxslider', 'child' => 'slider' ];

		// Services
		$this->modelService = Yii::$app->factory->get( 'fxSliderService' );
		$this->slideService = Yii::$app->factory->get( 'fxSlideService' );

		// Return Url
		$this->returnUrl = Url::previous( 'fxsliders' );
		$this->returnUrl = isset( $this->returnUrl ) ? $this->returnUrl : Url::toRoute( [ '/foxslider/slider/all' ], true );

		// Breadcrumbs
		$this->breadcrumbs = [
			'all' => [ [ 'label' => 'Sliders' ] ],
			'create' => [ [ 'label' => 'Sliders', 'url' => $this->returnUrl ], [ 'label' => 'Add' ] ],
			'update' => [ [ 'label' => 'Sliders', 'url' => $this->returnUrl ], [ 'label' => 'Update' ] ],
			'delete' => [ [ 'label' => 'Sliders', 'url' => $this->returnUrl ], [ 'label' => 'Delete' ] ],
			'slides' => [ [ 'label' => 'Sliders', 'url' => $this->returnUrl ], [ 'label' => 'Slides' ] ],
			'settings' => [ [ 'label' => 'Sliders', 'url' => $this->returnUrl ], [ 'label' => 'Settings' ] ]
		];
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

    public function behaviors() {

		$behaviors = parent::behaviors();

		$behaviors[ 'rbac' ][ 'actions' ][ 'slides' ] = [ 'permission' => $this->crudPermission ];

		$behaviors[ 'verbs' ][ 'actions' ][ 'slides' ] = [ 'get' ];

		return $behaviors;
    }

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// SliderController ----------------------

	public function actionAll( $config = [] ) {

		Url::remember( Yii::$app->request->getUrl(), 'fxsliders' );

		$dataProvider = $this->modelService->getPage();

		return $this->render( 'all', [
			'dataProvider' => $dataProvider,
			'statusMap' => Slider::$statusMap
		]);
	}

	public function actionSlides( $id ) {

		// Find Model
		$slider	= $this->modelService->getById( $id );

		// Update/Render if exist
		if( isset( $slider ) ) {

			$slides = $this->slideService->getBySliderId( $slider->id );

	    	return $this->render( 'slides', [
	    		'slider' => $slider,
	    		'slides' => $slides
	    	]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}

	public function actionSettings( $id ) {

		// Find Model
		$model = $this->modelService->getById( $id );

		// Update/Render if exist
		if( isset( $model ) ) {

			$settings = new SliderSettingsForm( $model->getDataMeta( 'settings' ) );

			if( $settings->load( Yii::$app->request->post(), $settings->getClassName() ) && $settings->validate() ) {

				$this->model = $this->modelService->updateDataMeta( $model, 'settings', $settings );

				return $this->redirect( $this->returnUrl );
			}

			return $this->render( 'settings', [
				'model' => $model,
				'settings' => $settings
			]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}

}
