<?php
namespace foxslider\common\services;

// Yii Imports
use \Yii;

// CMG Imports

// FXS Imports
use foxslider\common\models\entities\FXSTables;

use foxslider\common\models\entities\Slider;
use foxslider\common\models\entities\Slide;

class SliderService extends \cmsgears\core\common\services\Service {

	// Static Methods ----------------------------------------------

	// Read ----------------

	public static function findById( $id ) {

		return Slider::findById( $id );
	}

	public static function findByName( $name ) {

		return Slider::findByName( $name );
	}

	public static function getIdList() {

		return self::findList( 'id', FxsTables::TABLE_SLIDER );
	}

	public static function getIdNameMap() {

		return self::findMap( 'id', 'name', FxsTables::TABLE_SLIDER );
	}

	// Data Provider -------

	/**
	 * @param array $config to generate query
	 * @return ActiveDataProvider
	 */
	public static function getPagination( $config = [] ) {

		return self::getDataProvider( new Slider(), $config );
	}

	// Create -----------

	public static function create( $slider ) {

		// Create Slider
		$slider->save();

		// Return Slider
		return $slider;
	}

	// Update -----------

	public static function update( $slider ) {

		// Find existing slider
		$sliderToUpdate	= self::findById( $slider->id );

		// Copy Attributes
		$sliderToUpdate->copyForUpdateFrom( $slider, [ 'name', 'description', 'width', 'height', 'slideWidth', 'slideHeight', 'fullPage', 'scrollAuto', 'scrollType', 'circular' ] );

		// Update Slider
		$sliderToUpdate->update();

		// Return updated Slider
		return $sliderToUpdate;
	}

	// Delete -----------

	public static function delete( $slider ) {

		// Find existing slider
		$existingSlider	= self::findById( $slider->id );

		// Clear all related slides
		Slide::deleteBySliderId( $sliderId );

		// Delete Slider
		$existingSlider->delete();

		return true;
	}
}

?>