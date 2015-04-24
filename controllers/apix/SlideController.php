<?php
namespace foxslider\controllers\apix;

// Yii Imports
use \Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\core\common\models\entities\CmgFile;

use cmsgears\core\admin\controllers\BaseController;

use cmsgears\core\common\utilities\AjaxUtil;

// FXS Imports
use foxslider\config\FxsCoreGlobal;

use foxslider\models\entities\Slide;

use foxslider\services\SlideService;

class SlideController extends BaseController {

	// Constructor and Initialisation ------------------------------

 	public function __construct( $id, $module, $config = [] ) {

        parent::__construct( $id, $module, $config );
	}

	// Instance Methods --------------------------------------------

	// yii\base\Component

    public function behaviors() {

        return [
            'rbac' => [
                'class' => Yii::$app->cmgCore->getRbacFilterClass(),
                'actions' => [
	                'create' => [ 'permission' => FxsCoreGlobal::PERM_SLIDER ],
	                'update' => [ 'permission' => FxsCoreGlobal::PERM_SLIDER ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
	                'create' => ['post'],
	                'update' => ['post']
                ]
            ]
        ];
    }

	// UserController

	public function actionCreate() {

		$slide = new Slide();

		if( $slide->load( Yii::$app->request->post( "Slide" ), "" ) && $slide->validate() ) {

			$slideImage 	= new CmgFile();			

			$slideImage->load( Yii::$app->request->post( "File" ), "" );

			// create slide

			SlideService::create( $slide, $slideImage );

			// send response

			$responseData	= $slide->getAttributes( [ 'id', 'sliderId', 'name', 'description' ] );

			// Trigger Ajax Success
			AjaxUtil::generateSuccess( Yii::$app->cmgCoreMessageSource->getMessage( CoreGlobal::MESSAGE_REQUEST ), $responseData );
		}

		// Generate Errors
		$errors = AjaxUtil::generateErrorMessage( $slide );

		// Trigger Ajax Success
        AjaxUtil::generateFailure( Yii::$app->cmgCoreMessageSource->getMessage( CoreGlobal::ERROR_REQUEST ), $errors );
	}
	
	public function actionUpdate( $id ) {

		// Find Model
		$slide			= SlideService::findById( $id );

		// Update/Render if exist
		if( isset( $slide ) ) {

			if( $slide->load( Yii::$app->request->post( "Slide" ), "" ) && $slide->validate() ) {
	
				$slideImage 	= new CmgFile();			

				$slideImage->load( Yii::$app->request->post( "File" ), "" );

				// update slide
				if( SlideService::update( $slide, $slideImage ) ) {

					// Trigger Ajax Success
					AjaxUtil::generateSuccess( Yii::$app->cmgCoreMessageSource->getMessage( CoreGlobal::MESSAGE_REQUEST ) );
				}	
			}
		}

		// Generate Errors
		$errors = AjaxUtil::generateErrorMessage( $slide );

		// Trigger Ajax Success
        AjaxUtil::generateFailure( Yii::$app->cmgCoreMessageSource->getMessage( CoreGlobal::ERROR_REQUEST ), $errors );
	}
}

?>