<?php
// Yii Imports
use \Yii;
use yii\helpers\Html;
use yii\widgets\LinkPager;

// CMG Imports
use cmsgears\core\common\utilities\CodeGenUtil;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= 'All Sliders | ' . $coreProperties->getSiteTitle();

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

<div class="header-content clearfix">
	<div class="header-actions col15x10">
		<span class="frm-icon-element element-small">
			<i class="cmti cmti-plus"></i>
			<?= Html::a( 'Add', [ 'create' ], [ 'class' => 'btn' ] ) ?>
		</span>
	</div>
	<div class="header-search col15x5">
		<input id="search-terms" class="element-large" type="text" name="search" value="<?= $searchTerms ?>">
		<span class="frm-icon-element element-medium">
			<i class="cmti cmti-search"></i>
			<button id="btn-search">Search</button>
		</span>
	</div>
</div>

<div class="data-grid">
	<div class="grid-header clearfix">
		<div class="col12x6 info">
			<?=CodeGenUtil::getPaginationDetail( $dataProvider ) ?>
		</div>
		<div class="col12x6 pagination">
			<?= LinkPager::widget( [ 'pagination' => $pagination, 'options' => [ 'class' => 'pagination-basic' ] ] ); ?>
		</div>
	</div>
	<div class="grid-content">
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
						<td class="actions">
							<span title="Slider Slides"><?= Html::a( "", [ "slides?id=$id" ], [ 'class' => 'cmti cmti-list-small' ] )  ?></span>
							<span title="Update Slider"><?= Html::a( "", [ "update?id=$id" ], [ 'class' => 'cmti cmti-edit' ] )  ?></span>
							<span title="Delete Slider"><?= Html::a( "", [ "delete?id=$id" ], [ 'class' => 'cmti cmti-close-c-o' ] )  ?></span>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
	<div class="grid-header clearfix">
		<div class="col12x6 info">
			<?=CodeGenUtil::getPaginationDetail( $dataProvider ) ?>
		</div>
		<div class="col12x6 pagination">
			<?= LinkPager::widget( [ 'pagination' => $pagination, 'options' => [ 'class' => 'pagination-basic' ] ] ); ?>
		</div>
	</div>
</div>