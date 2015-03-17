<?php
namespace foxslider\controllers;

// Yii Imports
use \Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\core\common\models\entities\Permission;

use cmsgears\core\admin\controllers\BaseController;

use cmsgears\core\common\utilities\MessageUtil;

// FXS Imports
use foxslider\models\entities\Slider;

use foxslider\services\SliderService;
use foxslider\services\SlideService;

class SliderController extends BaseController {

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
	                'index'  => Permission::PERM_SLIDER,
	                'all'    => Permission::PERM_SLIDER,
	                'create' => Permission::PERM_SLIDER,
	                'update' => Permission::PERM_SLIDER,
	                'delete' => Permission::PERM_SLIDER,
	                'slides' => Permission::PERM_SLIDER
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
	                'index'  => ['get'],
	                'all'    => ['get'],
	                'create' => ['get', 'post'],
	                'update' => ['get', 'post'],
	                'delete' => ['get', 'post'],
	                'slides' => ['get']
                ]
            ]
        ];
    }

	// SliderController

	public function actionIndex() {

		$this->redirect( "all" );
	}

	public function actionAll() {

		$pagination = SliderService::getPagination();

	    return $this->render('all', [
	         'page' => $pagination['page'],
	         'pages' => $pagination['pages'],
	         'total' => $pagination['total']
	    ]);
	}

	public function actionCreate() {

		$model	= new Slider();

		$model->setScenario( "create" );

		if( $model->load( Yii::$app->request->post( "Slider" ), "" )  && $model->validate() ) {

			if( SliderService::create( $model ) ) {

				return $this->redirect( "all" );
			}
		}

    	return $this->render('create', [
    		'model' => $model
    	]);
	}

	public function actionUpdate( $id ) {
		
		// Find Model		
		$model	= SliderService::findById( $id );
		
		// Update/Render if exist
		if( isset( $model ) ) {

			$model->setScenario( "update" );
	
			if( $model->load( Yii::$app->request->post( "Slider" ), "" )  && $model->validate() ) {
	
				if( SliderService::update( $model ) ) {

					$this->refresh();
				}
			}

	    	return $this->render('update', [
	    		'model' => $model
	    	]);			
		}

		// Model not found
		throw new NotFoundHttpException( MessageUtil::getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}

	public function actionDelete( $id ) {

		// Find Model
		$model			= SliderService::findById( $id );
		
		// Delete/Render if exist
		if( isset( $model ) ) {

			if( isset( $_POST ) && count( $_POST ) > 0 ) {
	
				if( SliderService::delete( $model ) ) {
		
					return $this->redirect( "all" );
				}
			}

	    	return $this->render('delete', [
	    		'model' => $model
	    	]);
		}

		// Model not found
		throw new NotFoundHttpException( MessageUtil::getMessage( CoreGlobal::ERROR_NOT_FOUND ) );	
	}
	
	public function actionSlides( $id ) {
		
		// Find Model		
		$slider			= SliderService::findById( $id );
		
		// Update/Render if exist
		if( isset( $slider ) ) {
				
			$slides 	= SlideService::findBySliderId( $slider->id );

	    	return $this->render('slides', [
	    		'slider' => $slider,
	    		'slides' => $slides
	    	]);
		}

		// Model not found
		throw new NotFoundHttpException( MessageUtil::getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}
}

?>