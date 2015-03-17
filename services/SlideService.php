<?php
namespace foxslider\services;

// Yii Imports
use \Yii;
use yii\data\Sort;

// CMG Imports
use cmsgears\core\common\services\Service;
use cmsgears\core\admin\services\FileService;

use cmsgears\core\common\utilities\DateUtil;

// FXS Imports
use foxslider\models\entities\Slider;
use foxslider\models\entities\Slide;

class SlideService extends Service {

	// Static Methods ----------------------------------------------

	// Read ----------------

	public static function findById( $id ) {

		return Slide::findOne( $id );
	}

	public static function findBySliderId( $sliderId ) {

		return Slide::findBySliderId( $sliderId );
	}

	// Pagination -------

	public static function getPagination( $conditions = [] ) {

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

		return self::getPaginationDetails( new Slide(), [ 'sort' => $sort, 'search-col' => 'name' ] );
	}

	// Create -----------

	public static function create( $slide, $slideImage ) {

		// Find User and Slider
		$date 		= DateUtil::getMysqlDate();
		$user		= Yii::$app->user->getIdentity();
		$slider		= SliderService::findById( $slide->sliderId );

		// Save Slide Image to Slide Dimensions
		FileService::saveImage( $slideImage, $user, $slide, "imageId", Yii::$app->fileManager, $slider->slideWidth, $slider->slideHeight );

		// commit slide
		$slide->save();

		return true;
	}

	// Update -----------

	public static function update( $slide, $slideImage ) {

		// Find User and Slider
		$date 			= DateUtil::getMysqlDate();
		$user			= Yii::$app->user->getIdentity();
		$slider			= SliderService::findById( $slide->sliderId );
		
		// Find existing Slide
		$slideToUpdate	= self::findById( $slide->id );
		
		// Copy Attributes		
		$slideToUpdate->copyForUpdateFrom( $slide, [ 'name', 'description', 'content', 'url', 'imageId' ] );

		// Save Slide Image
		FileService::saveImage( $slideImage, $user, $slideToUpdate, "imageId", Yii::$app->fileManager, $slider->slideWidth, $slider->slideHeight );

		$slideToUpdate->update();

		return true;
	}

	// Delete -----------

	public static function delete( $slide ) {
		
		// Find existing Slide
		$existingSlide	= self::findById( $slide->id );

		// Delete Slider
		$existingSlide->delete();

		return true;
	}
}

?>