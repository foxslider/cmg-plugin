<?php
/**
 * This file is part of Foxslider Module for CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.foxslider.com/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace foxslider\admin\controllers\apix;

// Yii Imports
use Yii;
use yii\filters\VerbFilter;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\core\common\models\resources\File;

use cmsgears\core\admin\controllers\base\Controller;

use cmsgears\core\common\utilities\AjaxUtil;

// FXS Imports
use foxslider\common\config\FxsCoreGlobal;

/**
 * SlideController provides actions specific to slide model.
 *
 * @since 1.0.0
 */
class SlideController extends Controller {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Constructor and Initialisation ------------------------------

 	public function init() {

        parent::init();

		// Permission
		$this->crudPermission = FxsCoreGlobal::PERM_SLIDER;

		// Services
		$this->modelService = Yii::$app->factory->get( 'fxSlideService' );
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

    public function behaviors() {

        return [
            'rbac' => [
                'class' => Yii::$app->core->getRbacFilterClass(),
                'actions' => [
					'create' => [ 'permission' => $this->crudPermission ],
					'update' => [ 'permission' => $this->crudPermission ],
					'delete' => [ 'permission' => $this->crudPermission ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
					'create' => [ 'post' ],
					'update' => [ 'post' ],
					'delete' => [ 'post' ]
                ]
            ]
        ];
    }

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// SlideController -----------------------

	public function actionCreate() {

		$model 	= $this->modelService->getModelObject();
		$image 	= File::loadFile( $model->image, 'File' );

		if( $model->load( Yii::$app->request->post(), 'Slide' ) && $model->validate() ) {

			$this->model = $this->modelService->create( $model, [ 'image' => $image ] );

			$data = $this->model->getAttributes( [ 'id', 'sliderId', 'name', 'description' ] );

			// Trigger Ajax Success
			return AjaxUtil::generateSuccess( Yii::$app->coreMessage->getMessage( CoreGlobal::MESSAGE_REQUEST ), $data );
		}

		// Generate Errors
		$errors = AjaxUtil::generateErrorMessage( $model );

		// Trigger Ajax Failure
        return AjaxUtil::generateFailure( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_REQUEST ), $errors );
	}

	public function actionUpdate( $id ) {

		// Find Model
		$model	= $this->modelService->getById( $id );
		$image 	= File::loadFile( $model->image, 'File' );

		// Update/Render if exist
		if( isset( $model ) ) {

			if( $model->load( Yii::$app->request->post(), 'Slide' ) && $model->validate() ) {

				$this->model = $this->modelService->update( $model, [ 'image' => $image ] );

				// Trigger Ajax Success
				return AjaxUtil::generateSuccess( Yii::$app->coreMessage->getMessage( CoreGlobal::MESSAGE_REQUEST ) );
			}
		}

		// Generate Errors
		$errors = AjaxUtil::generateErrorMessage( $model );

		// Trigger Ajax Failure
        return AjaxUtil::generateFailure( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_REQUEST ), $errors );
	}

	public function actionDelete( $id, $pid ) {

		// Find Model
		$model	= $this->modelService->getById( $id );

		// Delete if exist
		if( isset( $model ) ) {

			$slider	= Yii::$app->factory->get( 'fxSliderService' )->getById( $pid );

			if( $model->sliderId = $slider->id ) {

				$this->model = $model;

				$this->modelService->delete( $model );

				// Trigger Ajax Success
				return AjaxUtil::generateSuccess( Yii::$app->coreMessage->getMessage( CoreGlobal::MESSAGE_REQUEST ) );
			}
		}

		// Trigger Ajax Failure
        return AjaxUtil::generateFailure( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_REQUEST ), $errors );
	}

}
