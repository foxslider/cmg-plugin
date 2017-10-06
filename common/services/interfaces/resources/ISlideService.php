<?php
namespace foxslider\common\services\interfaces\resources;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

interface ISlideService extends \cmsgears\core\common\services\interfaces\base\IEntityService {

	// Data Provider ------

	// Read ---------------

    // Read - Models ---

	public function getBySliderId( $sliderId );

    // Read - Lists ----

    // Read - Maps -----

	// Create -------------

	// Update -------------

	// Delete -------------

	public function deleteBySliderId( $sliderId );
}
