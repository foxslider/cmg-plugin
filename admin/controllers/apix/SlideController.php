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

use cmsgears\core\common\utilities\AjaxUtil;

// FXS Imports
use foxslider\common\config\FxsCoreGlobal;

/**
 * SlideController provides actions specific to slide model.
 *
 * @since 1.0.0
 */
class SlideController extends \cmsgears\core\admin\controllers\apix\base\Controller {

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
					'get' => [ 'permission' => $this->crudPermission ],
					'create' => [ 'permission' => $this->crudPermission ],
					'update' => [ 'permission' => $this->crudPermission ],
					'delete' => [ 'permission' => $this->crudPermission ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
					'get' => [ 'post' ],
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

	public function actionGet( $id, $cid, $fid ) {

		// Find Model
		$model	= $this->modelService->getById( $cid );

		// Update/Render if exist
		if( isset( $model ) ) {

			$file = $model->image;

			$data = [
				'mid' => $model->id, 'fid' => $file->id,
				'name' => $file->name, 'extension' => $file->extension, 'order' => $model->order,
				'title' => $model->name, 'stitle' => $model->title, 'ititle' => $file->title, 'caption' => $file->caption,
				'altText' => $file->altText, 'link' => $file->link, 'url' => $file->getFileUrl(),
				'texture' => $model->texture, 'description' => $model->description, 'idescription' => $file->description,
				'content' => $model->content, 'icontent' => $file->content
			];

			if( $file->type == 'image' ) {

				$data[ 'mediumUrl' ]	= $file->getMediumUrl();
				$data[ 'thumbUrl' ]		= $file->getThumbUrl();
			}

			// Trigger Ajax Success
			return AjaxUtil::generateSuccess( Yii::$app->coreMessage->getMessage( CoreGlobal::MESSAGE_REQUEST ), $data );
		}

		// Trigger Ajax Failure
        return AjaxUtil::generateFailure( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ), $errors );
	}

	public function actionCreate( $id ) {

		$model 	= $this->modelService->getModelObject();
		$image 	= new File();

		$image->siteId = Yii::$app->core->siteId;

		if( $model->load( Yii::$app->request->post(), 'Slide' ) && $image->load( Yii::$app->request->post(), 'File' ) &&
			$model->validate() && $image->validate() ) {

			$this->model = $this->modelService->create( $model, [ 'image' => $image ] );

			$file = $this->model->image;

			$data = [
				'mid' => $this->model->id, 'fid' => $file->id,
				'name' => $file->name, 'extension' => $file->extension, 'order' => $model->order,
				'title' => $model->name, 'stitle' => $model->title, 'ititle' => $file->title, 'caption' => $file->caption,
				'altText' => $file->altText, 'link' => $file->link, 'url' => $file->getFileUrl(),
				'texture' => $model->texture, 'description' => $model->description, 'idescription' => $file->description,
				'content' => $model->content, 'icontent' => $file->content
			];

			if( $file->type == 'image' ) {

				$data[ 'mediumUrl' ]	= $file->getMediumUrl();
				$data[ 'thumbUrl' ]		= $file->getThumbUrl();
			}

			// Trigger Ajax Success
			return AjaxUtil::generateSuccess( Yii::$app->coreMessage->getMessage( CoreGlobal::MESSAGE_REQUEST ), $data );
		}

		// Generate Errors
		$errors = AjaxUtil::generateErrorMessage( $model );

		// Trigger Ajax Failure
        return AjaxUtil::generateFailure( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_REQUEST ), $errors );
	}

	public function actionUpdate( $id, $cid, $fid ) {

		// Find Model
		$model = $this->modelService->getById( $cid );

		// Update/Render if exist
		if( isset( $model ) ) {

			$image = File::loadFile( $model->image, 'File' );

			if( $model->load( Yii::$app->request->post(), 'Slide' ) && $image->load( Yii::$app->request->post(), 'File' ) &&
				$model->validate() && $image->validate() ) {

				$this->model = $this->modelService->update( $model, [ 'image' => $image ] );

				$file = $this->model->image;

				$data = [
					'mid' => $this->model->id, 'fid' => $file->id,
					'name' => $file->name, 'extension' => $file->extension, 'order' => $model->order,
					'title' => $model->name, 'stitle' => $model->title, 'ititle' => $file->title, 'caption' => $file->caption,
					'altText' => $file->altText, 'link' => $file->link, 'url' => $file->getFileUrl(),
					'texture' => $model->texture, 'description' => $model->description, 'idescription' => $file->description,
					'content' => $model->content, 'icontent' => $file->content
				];

				if( $file->type == 'image' ) {

					$data[ 'mediumUrl' ]	= $file->getMediumUrl();
					$data[ 'thumbUrl' ]		= $file->getThumbUrl();
				}

				// Trigger Ajax Success
				return AjaxUtil::generateSuccess( Yii::$app->coreMessage->getMessage( CoreGlobal::MESSAGE_REQUEST ), $data );
			}

			// Generate Errors
			$errors = AjaxUtil::generateErrorMessage( $model );

			// Trigger Ajax Failure
			return AjaxUtil::generateFailure( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_REQUEST ), $errors );
		}

		// Trigger Ajax Failure
        return AjaxUtil::generateFailure( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ), $errors );
	}

	public function actionDelete( $id, $cid, $fid ) {

		// Find Model
		$model = $this->modelService->getById( $cid );

		// Delete if exist
		if( isset( $model ) ) {

			$slider	= Yii::$app->factory->get( 'fxSliderService' )->getById( $id );

			if( $model->sliderId = $slider->id ) {

				$this->model = $model;

				$data = [ 'mid' => $model->id ];

				$this->modelService->delete( $model );

				// Trigger Ajax Success
				return AjaxUtil::generateSuccess( Yii::$app->coreMessage->getMessage( CoreGlobal::MESSAGE_REQUEST ), $data );
			}
		}

		// Trigger Ajax Failure
        return AjaxUtil::generateFailure( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}

}
