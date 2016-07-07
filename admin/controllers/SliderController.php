<?php
namespace foxslider\admin\controllers;

// Yii Imports
use \Yii;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

// FXS Imports
use foxslider\common\config\FxsCoreGlobal;

use foxslider\common\models\entities\Slider;

class SliderController extends \cmsgears\core\admin\controllers\base\CrudController {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Protected --------------

	protected $slideService;

	// Private ----------------

	// Constructor and Initialisation ------------------------------

 	public function init() {

        parent::init();

		$this->crudPermission 	= FxsCoreGlobal::PERM_SLIDER;
		$this->modelService		= Yii::$app->factory->get( 'sliderService' );
		$this->sidebar 			= [ 'parent' => 'sidebar-fxslider', 'child' => 'slider' ];

		$this->slideService		= Yii::$app->factory->get( 'slideService' );

		$this->returnUrl		= Url::previous( 'fxsliders' );
		$this->returnUrl		= isset( $this->returnUrl ) ? $this->returnUrl : Url::toRoute( [ '/foxslider/slider/all' ], true );
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

    public function behaviors() {

		$behaviors = parent::behaviors();

		$behaviors[ 'rbac' ][ 'actions' ][ 'slides' ] = [ 'permission' => FxsCoreGlobal::PERM_SLIDER ];

		$behaviors[ 'verbs' ][ 'actions' ][ 'slides' ] = [ 'get' ];

		return $behaviors;
    }

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// SliderController ----------------------

	public function actionAll() {

		Url::remember( [ 'slider/all' ], 'fxsliders' );

		$dataProvider = $this->modelService->getPage();

	    return $this->render( 'all', [
	         'dataProvider' => $dataProvider
	    ]);
	}

	public function actionSlides( $id ) {

		// Find Model
		$slider			= $this->modelService->getById( $id );

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
}

?>