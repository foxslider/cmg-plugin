<?php
namespace foxslider\services;

// Yii Imports
use \Yii;
use yii\data\Sort;

// CMG Imports
use cmsgears\core\common\services\Service;

// FXS Imports
use foxslider\models\entities\Slider;
use foxslider\models\entities\Slide;

class SliderService extends Service {

	// Static Methods ----------------------------------------------

	// Read ----------------

	public static function findById( $id ) {

		return Slider::findOne( $id );
	}

	public static function findByName( $name ) {

		return Slider::findByName( $name );
	}

	public static function getIdList() {

		$slidersList	= array();

		// Execute the command
		$sliders 		= Slider::find()->all();

		foreach ( $sliders as $slider ) {
			
			array_push( $slidersList, $slider->getId() );
		}

		return $slidersList;
	}

	public static function getIdNameMap() {

		$slidersMap 	= array();

		// Execute the command
		$sliders 		= Slider::find()->all();

		foreach ( $sliders as $slider ) {

			$slidersMap[] = [ "id" => $slider->getId(), "name" => $slider->getName() ];
		}

		return $slidersMap;
	}

	// Pagination -------

	public static function getPagination() {

	    $sort = new Sort([
	        'attributes' => [
	            'name' => [
	                'asc' => [ 'slider_name' => SORT_ASC ],
	                'desc' => ['slider_name' => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'name',
	            ]
	        ]
	    ]);

		return self::getPaginationDetails( new Slider(), [ 'sort' => $sort, 'search-col' => 'slider_name' ] );
	}

	// Create -----------

	public static function create( $slider ) {

		$slider->save();

		return true;
	}

	// Update -----------

	public static function update( $slider ) {

		$sliderToUpdate	= self::findById( $slider->getId() );

		$sliderToUpdate->setName( $slider->getName() );
		$sliderToUpdate->setDesc( $slider->getDesc() );
		$sliderToUpdate->setWidth( $slider->getWidth() );
		$sliderToUpdate->setHeight( $slider->getHeight() );
		$sliderToUpdate->setSlideWidth( $slider->getSlideWidth() );
		$sliderToUpdate->setSlideHeight( $slider->getSlideHeight() );
		$sliderToUpdate->setFullPage( $slider->isFullPage() );
		$sliderToUpdate->setScrollAuto( $slider->isScrollAuto() );
		$sliderToUpdate->setScrollManual( $slider->isScrollManual() );
		$sliderToUpdate->setCircular( $slider->isCircular() );

		$sliderToUpdate->update();

		return true;
	}

	// Delete -----------

	public static function delete( $slider ) {

		$sliderId		= $slider->getId();
		$existingSlider	= self::findById( $sliderId );

		// Clear all related slides
		Slide::deleteBySlider( $sliderId );

		// Delete Slider
		$existingSlider->delete();

		return true;
	}
}

?>