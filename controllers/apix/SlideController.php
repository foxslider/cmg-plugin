<?php
namespace foxslider\controllers\apix;

// Yii Imports
use \Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\core\common\config\CoreProperties;

use cmsgears\core\common\models\entities\CmgFile;
use cmsgears\cms\common\models\entities\CMSPermission;

use cmsgears\core\admin\controllers\BaseController;

use cmsgears\core\common\utilities\MessageUtil;
use cmsgears\core\common\utilities\AjaxUtil;

// FXS Imports
use foxslider\models\entities\Slide;

use foxslider\services\SlideService;

class SlideController extends BaseController {

	protected $coreProperties;

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
                'permissions' => [
	                'create' => CMSPermission::PERM_CMS_SLIDER,
	                'update' => CMSPermission::PERM_CMS_SLIDER
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

			$responseData				= array();

			$responseData['id']			= $slide->getId();
			$responseData['slider']		= $slide->getSliderId();
			$responseData['name']		= $slide->getName();
			$responseData['desc']		= $slide->getDesc();

			// Trigger Ajax Success
			AjaxUtil::generateSuccess( MessageUtil::getMessage( CoreGlobal::MESSAGE_REQUEST ), $responseData );
		}

		// Generate Errors
		$errors = AjaxUtil::generateErrorMessage( $slide );

		// Trigger Ajax Success
        AjaxUtil::generateFailure( MessageUtil::getMessage( CoreGlobal::ERROR_REQUEST ), $errors );
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
					AjaxUtil::generateSuccess( MessageUtil::getMessage( CoreGlobal::MESSAGE_REQUEST ) );
				}	
			}
		}

		// Generate Errors
		$errors = AjaxUtil::generateErrorMessage( $slide );

		// Trigger Ajax Success
        AjaxUtil::generateFailure( MessageUtil::getMessage( CoreGlobal::ERROR_REQUEST ), $errors );
	}
}

?>