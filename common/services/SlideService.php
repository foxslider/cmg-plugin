<?php
namespace foxslider\common\services;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\core\admin\services\FileService;

// FXS Imports
use foxslider\common\models\entities\Slide;

class SlideService extends \cmsgears\core\common\services\Service {

	// Static Methods ----------------------------------------------

	// Read ----------------

	public static function findById( $id ) {

		return Slide::findOne( $id );
	}

	public static function findBySliderId( $sliderId ) {

		return Slide::findBySliderId( $sliderId );
	}

	// Data Provider -------

	/**
	 * @param array $config to generate query
	 * @return ActiveDataProvider
	 */
	public static function getPagination( $config = [] ) {

		return self::getDataProvider( new Slide(), $config );
	}

	// Create -----------

	public static function create( $slide, $slideImage = null ) {

		$slider	= SliderService::findById( $slide->sliderId );

		// Save Slide Image to Slide Dimensions
		if( isset( $slideImage ) ) {

			FileService::saveImage( $slideImage, [ 'model' => $slide, 'attribute' => 'imageId', 'width' => $slider->slideWidth, 'height' => $slider->slideHeight ] );
		}

		// commit slide
		$slide->save();

		return $slide;
	}

	// Update -----------

	public static function update( $slide, $slideImage = null ) {

		// Find User and Slider
		$slider			= SliderService::findById( $slide->sliderId );

		// Find existing Slide
		$slideToUpdate	= self::findById( $slide->id );

		// Copy Attributes
		$slideToUpdate->copyForUpdateFrom( $slide, [ 'imageId', 'name', 'description', 'content', 'url' ] );

		// Save Slide Image to Slide Dimensions
		if( isset( $slideImage ) ) {

			FileService::saveImage( $slideImage, [ 'model' => $slideToUpdate, 'attribute' => 'imageId', 'width' => $slider->slideWidth, 'height' => $slider->slideHeight ] );
		}

		$slideToUpdate->update();

		return $slideToUpdate;
	}

	// Delete -----------

	public static function delete( $slide ) {

		// Find existing Slide
		$existingSlide	= self::findById( $slide->id );

		// Delete Slide
		$existingSlide->delete();

		return true;
	}
}

?>