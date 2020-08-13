<?php
/**
 * This file is part of Foxslider Module for CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.foxslider.com/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace foxslider\admin;

// Yii Imports
use Yii;

/**
 * The Admin Module of Foxslider Module.
 *
 * @since 1.0.0
 */
class Module extends \cmsgears\core\common\base\Module {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	public $controllerNamespace = 'foxslider\admin\controllers';

	// Protected --------------

	// Private ----------------

	// Traits ------------------------------------------------------

	// Constructor and Initialisation ------------------------------

    public function init() {

        parent::init();

		// Set FoxSlider
		Yii::setAlias( 'foxslider', dirname( __DIR__ ) );

		// Views
        $this->setViewPath( '@foxslider/admin/views' );
    }

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// Module --------------------------------

	public function getSidebarHtml() {

		return Yii::getAlias( '@foxslider' ) . '/admin/views/sidebar.php';
	}

}
