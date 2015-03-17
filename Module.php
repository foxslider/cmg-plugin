<?php
namespace foxslider;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\core\common\validators\CoreValidator;

class Module extends \yii\base\Module {

    public $controllerNamespace = 'foxslider\controllers';

    public function init() {

        parent::init();

		// Set FoxSlider
		Yii::setAlias( "foxslider", __DIR__ );

        $this->setViewPath( '@foxslider/views' );
    }
}

?>