<?php
namespace foxslider\services;

// Yii Imports
use \Yii;
use yii\data\Sort;

// CMG Imports
use cmsgears\core\common\services\Service;

// FXS Imports
use foxslider\models\entities\FXSTables;
use foxslider\models\entities\Slider;
use foxslider\models\entities\Slide;

class SliderService extends Service {

	// Static Methods ----------------------------------------------

	// Read ----------------

	public static function findById( $id ) {

		return Slider::findById( $id );
	}

	public static function findByName( $name ) {

		return Slider::findByName( $name );
	}

	public static function getIdList() {

		return self::findKeyList( 'id', FXSTables::TABLE_SLIDER );
	}

	public static function getIdNameMap() {

		return self::findKeyValueMap( 'id', 'name', FXSTables::TABLE_SLIDER );
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

		return self::getPaginationDetails( new Slider(), [ 'sort' => $sort, 'search-col' => 'name' ] );
	}

	// Create -----------

	public static function create( $slider ) {
		
		// Create Slider
		$slider->save();
		
		// Return Slider
		return true;
	}

	// Update -----------

	public static function update( $slider ) {
		
		// Find existing slider
		$sliderToUpdate	= self::findById( $slider->id );
		
		// Copy Attributes
		$sliderToUpdate->copyForUpdateFrom( $slider, [ 'name', 'description', 'width', 'height', 'slideWidth', 'slideHeight', 'fullPage', 'scrollAuto', 'scrollManual', 'circular'] );
		
		// Update Slider
		$sliderToUpdate->update();
		
		// Return updated Slider
		return $sliderToUpdate;
	}

	// Delete -----------

	public static function delete( $slider ) {
		
		// Find existing slider
		$sliderId		= $slider->id;
		$existingSlider	= self::findById( $sliderId );

		// Clear all related slides
		Slide::deleteBySliderId( $sliderId );

		// Delete Slider
		$existingSlider->delete();

		return true;
	}
}

?>