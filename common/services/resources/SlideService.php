<?php
namespace foxslider\common\services\resources;

// Yii Imports
use \Yii;
use yii\data\Sort;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\core\common\services\interfaces\resources\IFileService;

// FXS Imports
use foxslider\common\config\FxsCoreGlobal;

use foxslider\common\models\base\FxsTables;
use foxslider\common\models\resources\Slide;

use foxslider\common\services\interfaces\entities\ISliderService;
use foxslider\common\services\interfaces\resources\ISlideService;

class SlideService extends \cmsgears\core\common\services\base\EntityService implements ISlideService {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	public static $modelClass	= '\foxslider\common\models\resources\Slide';

	public static $modelTable	= FxsTables::TABLE_SLIDE;

	public static $parentType	= null;

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	// Protected --------------

	protected $sliderService;

	protected $fileService;

	// Private ----------------

	// Traits ------------------------------------------------------

	// Constructor and Initialisation ------------------------------

    public function __construct( ISliderService $sliderService, IFileService $fileService, $config = [] ) {

		$this->sliderService	= $sliderService;
		$this->fileService		= $fileService;

        parent::__construct( $config );
    }

	// Instance methods --------------------------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// SlideService --------------------------

	// Data Provider ------

	public function getPage( $config = [] ) {

	    $sort = new Sort([
	        'attributes' => [
	            'name' => [
	                'asc' => [ 'name' => SORT_ASC ],
	                'desc' => [ 'name' => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'name',
	            ]
	        ]
	    ]);

		if( !isset( $config[ 'sort' ] ) ) {

			$config[ 'sort' ] = $sort;
		}

		return parent::findPage( $config );
	}

	// Read ---------------

    // Read - Models ---

	public function getBySliderId( $sliderId ) {

		return Slide::findBySliderId( $sliderId );
	}

    // Read - Lists ----

    // Read - Maps -----

	// Read - Others ---

	// Create -------------

	public function create( $model, $config = [] ) {

		$image 	= isset( $config[ 'image' ] ) ? $config[ 'image' ] : null;

		$slider	= $this->sliderService->getById( $model->sliderId );

		$this->fileService->saveImage( $image, [ 'model' => $model, 'attribute' => 'imageId', 'width' => $slider->slideWidth, 'height' => $slider->slideHeight ] );

		return parent::create( $model, $config );
	}

	// Update -------------

	public function update( $model, $config = [] ) {

		$image 	= isset( $config[ 'image' ] ) ? $config[ 'image' ] : null;

		$slider	= $this->sliderService->getById( $model->sliderId );

		$this->fileService->saveImage( $image, [ 'model' => $model, 'attribute' => 'imageId', 'width' => $slider->slideWidth, 'height' => $slider->slideHeight ] );

		return parent::update( $model, [
			'attributes' => [ 'imageId', 'name', 'description', 'content', 'url' ]
		]);
	}

	// Delete -------------

	public function deleteBySliderId( $sliderId ) {

		Slide::deleteBySliderId( $sliderId );
	}

	// Static Methods ----------------------------------------------

	// CMG parent classes --------------------

	// SlideService --------------------------

	// Data Provider ------

	// Read ---------------

    // Read - Models ---

    // Read - Lists ----

    // Read - Maps -----

	// Read - Others ---

	// Create -------------

	// Update -------------

	// Delete -------------
}

?>