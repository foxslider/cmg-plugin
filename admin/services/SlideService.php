<?php
namespace foxslider\admin\services;

// Yii Imports
use \Yii;
use yii\data\Sort;

// CMG Imports

// FXS Imports
use foxslider\common\models\entities\Slide;

class SlideService extends \foxslider\common\services\SlideService {

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

		return self::getDataProvider( new Slide(), $config );
	}
}

?>