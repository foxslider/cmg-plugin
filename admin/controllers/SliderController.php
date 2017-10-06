<?php
namespace foxslider\admin\controllers;

// Yii Imports
use Yii;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

// FXS Imports
use foxslider\common\config\FxsCoreGlobal;

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

		// Permissions
		$this->crudPermission 	= FxsCoreGlobal::PERM_SLIDER;

		// Sidebar
		$this->sidebar 			= [ 'parent' => 'sidebar-fxslider', 'child' => 'slider' ];

		// Services
		$this->modelService		= Yii::$app->factory->get( 'sliderService' );
		$this->slideService		= Yii::$app->factory->get( 'slideService' );

		// Return Url
		$this->returnUrl		= Url::previous( 'fxsliders' );
		$this->returnUrl		= isset( $this->returnUrl ) ? $this->returnUrl : Url::toRoute( [ '/foxslider/slider/all' ], true );

		// Breadcrumbs
		$this->breadcrumbs		= [
			'all' => [ [ 'label' => 'Sliders' ] ],
			'create' => [ [ 'label' => 'Sliders', 'url' => $this->returnUrl ], [ 'label' => 'Add' ] ],
			'update' => [ [ 'label' => 'Sliders', 'url' => $this->returnUrl ], [ 'label' => 'Update' ] ],
			'delete' => [ [ 'label' => 'Sliders', 'url' => $this->returnUrl ], [ 'label' => 'Delete' ] ],
			'items' => [ [ 'label' => 'Sliders', 'url' => $this->returnUrl ], [ 'label' => 'Items' ] ]
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

	public function actionAll() {

		Url::remember( Yii::$app->request->getUrl(), 'fxsliders' );

		$dataProvider = $this->modelService->getPage();

		return $this->render( 'all', [
			 'dataProvider' => $dataProvider
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
}
