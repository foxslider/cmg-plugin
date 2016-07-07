<?php
namespace foxslider\common\services\entities;

// Yii Imports
use \Yii;
use yii\data\Sort;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\core\common\services\traits\NameTrait;
use cmsgears\core\common\services\traits\SlugTrait;

// FXS Imports
use foxslider\common\config\FxsCoreGlobal;

use foxslider\common\models\base\FxsTables;
use foxslider\common\models\entities\Slider;
use foxslider\common\models\resources\Slide;

use foxslider\common\services\interfaces\entities\ISliderService;
use foxslider\common\services\interfaces\resources\ISlideService;

class SliderService extends \cmsgears\core\common\services\base\EntityService implements ISliderService {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	public static $modelClass	= '\foxslider\common\models\entities\Slider';

	public static $modelTable	= FxsTables::TABLE_SLIDER;

	public static $parentType	= null;

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	// Protected --------------

	protected $slideService;

	// Private ----------------

	// Traits ------------------------------------------------------

	use NameTrait;
	use SlugTrait;

	// Constructor and Initialisation ------------------------------

    public function __construct( $config = [] ) {

        parent::__construct( $config );
    }

	// Instance methods --------------------------------------------

	public function setSlideService( ISlideService $slideService ) {

		$this->slideService	= $slideService;
	}

	// Yii parent classes --------------------

	// yii\base\Component -----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// SliderService -------------------------

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

    // Read - Lists ----

    // Read - Maps -----

	// Read - Others ---

	// Create -------------

	// Update -------------

	public function update( $model, $config = [] ) {

		return parent::update( $model, [
			'attributes' => [ 'name', 'description', 'width', 'height', 'slideWidth', 'slideHeight', 'fullPage', 'scrollAuto', 'scrollType', 'circular' ]
		]);
 	}

	// Delete -------------

	public function delete( $model, $config = [] ) {

		// Clear all related slides
		$this->slideService->deleteBySliderId( $model->id );

		// Delete Slider
		return parent::delete( $model, $config );
	}

	// Static Methods ----------------------------------------------

	// CMG parent classes --------------------

	// SliderService -------------------------

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