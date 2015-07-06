<?php
namespace foxslider\admin;

// Yii Imports
use \Yii;

class Module extends \yii\base\Module {

    public $controllerNamespace = 'foxslider\admin\controllers';

    public function init() {

        parent::init();

		// Set FoxSlider
		Yii::setAlias( 'foxslider', dirname( __DIR__ ) );

		// Views
        $this->setViewPath( '@foxslider/admin/views' );
    }

	public function getSidebarHtml() {

		$path	= Yii::getAlias( '@foxslider' ) . '/admin/views/sidebar.php';

		return $path;
	}
}

?>