<?php
namespace foxslider\services;

// Yii Imports
use \Yii;

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

	public static function getPagination() {

		return Service::getPaginationDetails( new Slide() );
	}

	// Create -----------

	public static function create( $slide, $slideImage ) {

		$date 		= DateUtil::getMysqlDate();
		$user		= Yii::$app->user->getIdentity();
		$slider		= SliderService::findById( $slide->getSliderId() );

		// Save Slide Image
		FileService::saveImage( $slideImage, $user, Yii::$app->fileManager, $slider->getSlideWidth(), $slider->getSlideHeight() );

		// New Slide Image
		$imageId 	= $slideImage->getId();

		if( isset( $imageId ) && intval( $imageId ) > 0 ) {

			$slide->setSlideImageId( $imageId );
		}

		// commit slide
		$slide->save();

		return true;
	}

	// Update -----------

	public static function update( $slide, $slideImage ) {

		$date 			= DateUtil::getMysqlDate();
		$user			= Yii::$app->user->getIdentity();
		$slider			= SliderService::findById( $slide->getSliderId() );
		$slideToUpdate	= self::findById( $slide->getId() );

		$slideToUpdate->setName( $slide->getName() );
		$slideToUpdate->setDesc( $slide->getDesc() );
		$slideToUpdate->setContent( $slide->getContent() );
		$slideToUpdate->setUrl( $slide->getUrl() );
		$slideToUpdate->setSlideImageId( $slide->getSlideImageId() );

		// Save Slide Image
		FileService::saveImage( $slideImage, $user, Yii::$app->fileManager, $slider->getSlideWidth(), $slider->getSlideHeight() );

		// New Slide Image
		$imageId 	= $slideImage->getId();

		if( isset( $imageId ) && intval( $imageId ) > 0 ) {

			$slideToUpdate->setSlideImageId( $imageId );
		}

		$slideToUpdate->update();

		return true;
	}

	// Delete -----------

	public static function delete( $slide ) {

		$slideId		= $slide->getId();
		$existingSlide	= self::findById( $slideId );

		// Delete Slider
		$existingSlide->delete();

		return true;
	}
}

?>