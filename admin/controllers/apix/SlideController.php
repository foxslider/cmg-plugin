<?php
namespace foxslider\admin\controllers\apix;

// Yii Imports
use \Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\core\common\models\resources\File;

use cmsgears\core\common\utilities\AjaxUtil;

// FXS Imports
use foxslider\common\config\FxsCoreGlobal;

use foxslider\common\models\resources\Slide;

class SlideController extends \cmsgears\core\admin\controllers\base\Controller {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Constructor and Initialisation ------------------------------

 	public function init() {

        parent::init();

		// Permissions
		$this->crudPermission 	= FxsCoreGlobal::PERM_SLIDER;
		
		// Services
		$this->modelService		= Yii::$app->factory->get( 'slideService' );
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
	                'update' => [ 'permission' => $this->crudPermission ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
	                'create' => [ 'post' ],
	                'update' => [ 'post' ]
                ]
            ]
        ];
    }

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// SlideController -----------------------

	public function actionCreate() {

		$slide 	= new Slide();
		$image 	= File::loadFile( $slide->image, 'File' );

		if( $slide->load( Yii::$app->request->post(), 'Slide' ) && $slide->validate() ) {

			$this->modelService->create( $slide, [ 'image' => $image ] );

			$data	= $slide->getAttributes( [ 'id', 'sliderId', 'name', 'description' ] );

			// Trigger Ajax Success
			return AjaxUtil::generateSuccess( Yii::$app->coreMessage->getMessage( CoreGlobal::MESSAGE_REQUEST ), $data );
		}

		// Generate Errors
		$errors = AjaxUtil::generateErrorMessage( $slide );

		// Trigger Ajax Success
        return AjaxUtil::generateFailure( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_REQUEST ), $errors );
	}

	public function actionUpdate( $id ) {

		// Find Model
		$slide	= $this->modelService->getById( $id );
		$image 	= File::loadFile( $slide->image, 'File' );

		// Update/Render if exist
		if( isset( $slide ) ) {

			if( $slide->load( Yii::$app->request->post(), 'Slide' ) && $slide->validate() ) {

				$this->modelService->update( $slide, [ 'image' => $image ] );

				// Trigger Ajax Success
				return AjaxUtil::generateSuccess( Yii::$app->coreMessage->getMessage( CoreGlobal::MESSAGE_REQUEST ) );
			}
		}

		// Generate Errors
		$errors = AjaxUtil::generateErrorMessage( $slide );

		// Trigger Ajax Success
        return AjaxUtil::generateFailure( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_REQUEST ), $errors );
	}
}
