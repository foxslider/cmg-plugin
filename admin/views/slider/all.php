<?php
use \Yii;
use yii\helpers\Html; 
use yii\widgets\LinkPager;

use cmsgears\core\common\utilities\CodeGenUtil;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= $coreProperties->getSiteTitle() . ' | All Sliders';

// Sidebar
$this->params['sidebar-parent'] = 'sidebar-slider';
$this->params['sidebar-child'] 	= 'slider';

// Data
$pagination		= $dataProvider->getPagination();
$models			= $dataProvider->getModels();

// Searching
$searchTerms	= Yii::$app->request->getQueryParam( 'search' );

// Sorting
$sortOrder		= Yii::$app->request->getQueryParam( 'sort' );

if( !isset( $sortOrder ) ) {

	$sortOrder	= '';
}
?>
<div class="content-header clearfix">
	<div class="header-actions"> 
		<?= Html::a( "Add Slider", ["/foxslider/slider/create"], ['class'=>'btn'] )  ?>				
	</div>
	<div class="header-search">
		<input type="text" name="search" id="search-terms" value="<?php if( isset($searchTerms) ) echo $searchTerms;?>">
		<input type="submit" name="submit-search" value="Search" onclick="return searchTable();" />
	</div>
</div>
<div class="data-grid">
	<div class="grid-header">
		<?= LinkPager::widget( [ 'pagination' => $pagination ] ); ?>
	</div>
	<div class="wrap-grid">
		<table>
			<thead>
				<tr>
					<th>Name
						<span class='box-icon-sort'>
							<span sort-order='name' class="icon-sort <?php if( strcmp( $sortOrder, 'name') == 0 ) echo 'icon-up-active'; else echo 'icon-up';?>"></span>
							<span sort-order='-name' class="icon-sort <?php if( strcmp( $sortOrder, '-name') == 0 ) echo 'icon-down-active'; else echo 'icon-down';?>"></span>
						</span>
					</th>				
					<th>Description</th>
					<th>Full Page</th>
					<th>Width</th>
					<th>Height</th>
					<th>Slide Width</th>
					<th>Slide Height</th>
					<th>Auto Scroll</th>
					<th>Scroll Type</th>
					<th>Circular</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php

					foreach( $models as $slider ) {

						$id = $slider->id;
				?>
					<tr>
						<td><?= $slider->name ?></td>					
						<td><?= $slider->description ?></td>
						<td><?= $slider->getFullPageStr() ?></td>
						<td><?= $slider->width ?></td>
						<td><?= $slider->height ?></td>
						<td><?= $slider->slideWidth ?></td>
						<td><?= $slider->slideHeight ?></td>
						<td><?= $slider->getScrollAutoStr() ?></td>
						<td><?= $slider->getScrollTypeStr() ?></td>
						<td><?= $slider->getCircularStr() ?></td>
						<td>
							<span class="wrap-icon-action" title="All Slides"><?= Html::a( "", ["/foxslider/slider/slides?id=$id"], ['class'=>'icon-action icon-action-edit'] )  ?></span>
							<span class="wrap-icon-action" title="Update Slider"><?= Html::a( "", ["/foxslider/slider/update?id=$id"], ['class'=>'icon-action icon-action-edit'] )  ?></span>
							<span class="wrap-icon-action" title="Delete Slider"><?= Html::a( "", ["/foxslider/slider/delete?id=$id"], ['class'=>'icon-action icon-action-delete'] )  ?></span>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
	<div class="grid-footer">
		<div class="text"> <?=CodeGenUtil::getPaginationDetail( $dataProvider ) ?> </div>
		<?= LinkPager::widget( [ 'pagination' => $pagination ] ); ?>
	</div>
</div>