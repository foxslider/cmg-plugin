<?php
namespace foxslider\admin\services\entities;

// Yii Imports
use \Yii;
use yii\data\Sort;

// CMG Imports

// FXS Imports
use foxslider\common\models\entities\Slider;

class SliderService extends \foxslider\common\services\entities\SliderService {

	// Static Methods ----------------------------------------------

	// Pagination -------

	public static function getPagination( $config = [] ) {

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

		if( !isset( $config[ 'search-col' ] ) ) {

			$config[ 'search-col' ] = 'name';
		}

		return self::getDataProvider( new Slider(), $config );
	}
}

?>