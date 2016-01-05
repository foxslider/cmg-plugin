<?php
namespace foxslider\admin\controllers;

// Yii Imports
use \Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

// FXS Imports
use foxslider\common\config\FxsCoreGlobal;

use foxslider\common\models\entities\Slider;

use foxslider\admin\services\SliderService;
use foxslider\admin\services\SlideService;

class SliderController extends \cmsgears\core\admin\controllers\base\Controller {

	// Constructor and Initialisation ------------------------------

 	public function __construct( $id, $module, $config = [] ) {

        parent::__construct( $id, $module, $config );
		
		$this->sidebar 		= [ 'parent' => 'sidebar-fxslider', 'child' => 'fxslider' ];
	}

	// Instance Methods --------------------------------------------

	// yii\base\Component

    public function behaviors() {

        return [
            'rbac' => [
                'class' => Yii::$app->cmgCore->getRbacFilterClass(),
                'actions' => [
	                'index'  => [ 'permission' => FxsCoreGlobal::PERM_SLIDER ],
	                'all'    => [ 'permission' => FxsCoreGlobal::PERM_SLIDER ],
	                'create' => [ 'permission' => FxsCoreGlobal::PERM_SLIDER ],
	                'update' => [ 'permission' => FxsCoreGlobal::PERM_SLIDER ],
	                'delete' => [ 'permission' => FxsCoreGlobal::PERM_SLIDER ],
	                'slides' => [ 'permission' => FxsCoreGlobal::PERM_SLIDER ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
	                'index'  => [ 'get' ],
	                'all'    => [ 'get' ],
	                'create' => [ 'get', 'post' ],
	                'update' => [ 'get', 'post' ],
	                'delete' => [ 'get', 'post' ],
	                'slides' => [ 'get' ]
                ]
            ]
        ];
    }

	// SliderController

	public function actionIndex() {

		$this->redirect( [ 'all' ] );
	}

	public function actionAll() {

		$dataProvider = SliderService::getPagination();

	    return $this->render( 'all', [
	         'dataProvider' => $dataProvider
	    ]);
	}

	public function actionCreate() {

		$model	= new Slider();

		$model->setScenario( 'create' );

		if( $model->load( Yii::$app->request->post(), 'Slider' )  && $model->validate() ) {

			if( SliderService::create( $model ) ) {

				return $this->redirect([ 'all' ] );
			}
		}

    	return $this->render( 'create', [
    		'model' => $model,
    		'scrollTypeMap' => Slider::$scrollTypeMap
    	]);
	}

	public function actionUpdate( $id ) {
		
		// Find Model		
		$model	= SliderService::findById( $id );
		
		// Update/Render if exist
		if( isset( $model ) ) {

			$model->setScenario( 'update' );
	
			if( $model->load( Yii::$app->request->post(), 'Slider' )  && $model->validate() ) {
	
				if( SliderService::update( $model ) ) {

					return $this->redirect([ 'all' ] );
				}
			}

	    	return $this->render( 'update', [
	    		'model' => $model,
	    		'scrollTypeMap' => Slider::$scrollTypeMap
	    	]);			
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}

	public function actionDelete( $id ) {

		// Find Model
		$model			= SliderService::findById( $id );
		
		// Delete/Render if exist
		if( isset( $model ) ) {

			if( $model->load( Yii::$app->request->post(), 'Slider' ) ) {
	
				if( SliderService::delete( $model ) ) {
		
					return $this->redirect( [ 'all' ] );
				}
			}

	    	return $this->render( 'delete', [
	    		'model' => $model,
	    		'scrollTypeMap' => Slider::$scrollTypeMap
	    	]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );	
	}

	public function actionSlides( $id ) {

		// Find Model
		$slider			= SliderService::findById( $id );

		// Update/Render if exist
		if( isset( $slider ) ) {

			$slides 	= SlideService::findBySliderId( $slider->id );

	    	return $this->render( 'slides', [
	    		'slider' => $slider,
	    		'slides' => $slides
	    	]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}
}

?>