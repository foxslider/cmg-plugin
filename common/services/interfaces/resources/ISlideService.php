<?php
/**
 * This file is part of Foxslider Module for CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.foxslider.com/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace foxslider\common\services\interfaces\resources;

// CMG Imports
use cmsgears\core\common\services\interfaces\base\IResourceService;

/**
 * ISlideService declares methods specific to slide model.
 *
 * @since 1.0.0
 */
interface ISlideService extends IResourceService {

	// Data Provider ------

	// Read ---------------

    // Read - Models ---

	public function getBySliderId( $sliderId );

    // Read - Lists ----

    // Read - Maps -----

	// Read - Others ---

	// Create -------------

	// Update -------------

	// Delete -------------

	public function deleteBySliderId( $sliderId );

	// Bulk ---------------

	// Notifications ------

	// Cache --------------

	// Additional ---------

}
