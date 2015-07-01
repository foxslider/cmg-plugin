<?php
namespace foxslider;

// Yii Imports
use \Yii;

class Module extends \yii\base\Module {

    public $controllerNamespace = 'foxslider\controllers';

    public function init() {

        parent::init();

		// Set FoxSlider
		Yii::setAlias( 'foxslider', __DIR__ );

		// Views
        $this->setViewPath( '@foxslider/views' );
    }

	public function getSidebarHtml() {

		$path	= Yii::getAlias( '@foxslider' ) . '/views/sidebar.php';

		return $path;
	}
}

?>