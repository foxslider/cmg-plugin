<?php
// CMG Imports
use cmsgears\widgets\popup\Popup;

use cmsgears\widgets\grid\DataGrid;

$coreProperties = $this->context->getCoreProperties();
$this->title	= 'Slider | ' . $coreProperties->getSiteTitle();

// View Templates
$moduleTemplates	= '@foxslider/admin/views/templates';
$themeTemplates		= '@themes/admin/views/templates';
?>
<?= DataGrid::widget([
	'dataProvider' => $dataProvider, 'add' => true, 'addUrl' => 'create', 'data' => [ ],
	'title' => 'Blocks', 'options' => [ 'class' => 'grid-data grid-data-admin' ],
	'searchColumns' => [ 'name' => 'Name', 'title' => 'Title', 'desc' => 'Description' ],
	'sortColumns' => [
		'name' => 'Name', 'title' => 'Title', 'status' => 'Status',
		'fpage' => 'Full Page', 'circular' => 'Circular',
		'cdate' => 'Created At', 'udate' => 'Updated At'
	],
	'filters' => [
		'status' => [ 'new' => 'New', 'active' => 'Active', 'blocked' => 'Blocked' ],
		'model' => [ 'fpage' => 'Full Page', 'circular' => 'Circular' ]
	],
	'reportColumns' => [
		'name' => [ 'title' => 'Name', 'type' => 'text' ],
		'title' => [ 'title' => 'Title', 'type' => 'text' ],
		'desc' => [ 'title' => 'Description', 'type' => 'text' ],
		'status' => [ 'title' => 'Status', 'type' => 'select', 'options' => $statusMap ],
		'fpage' => [ 'title' => 'Full Page', 'type' => 'flag' ],
		'circular' => [ 'title' => 'Circular', 'type' => 'flag' ]
	],
	'bulkPopup' => 'popup-grid-bulk', 'bulkActions' => [
		'status' => [ 'confirmed' => 'Confirm', 'rejected' => 'Reject', 'active' => 'Activate', 'frozen' => 'Freeze', 'blocked' => 'Block' ],
		'model' => [ 'fpage' => 'Full Page', 'circular' => 'Circular', 'delete' => 'Delete' ]
	],
	'header' => false, 'footer' => true,
	'grid' => true, 'columns' => [ 'root' => 'colf colf15', 'factor' => [ null , 'x3', 'x3', null, null, null, null, null, null, null, null, null, null  ] ],
	'gridColumns' => [
		'bulk' => 'Action',
		'name' => 'Name',
		'title' => 'Title',
		'status' => [ 'title' => 'Status', 'generate' => function( $model ) { return $model->getStatusStr(); } ],
		'fullPage' => [ 'title' => 'Full Page', 'generate' => function( $model ) { return $model->getFullPageStr(); } ],
		'slideWidth' => 'Slide Width',
		'slideHeight' => 'Slide Height',
		'scrollAuto' => [ 'title' => 'Auto Scroll' ,'generate' => function( $model ) { return $model->getScrollAutoStr(); } ],
		'scrollType' => [ 'title' =>  'Scroll type' ,'generate' =>  function( $model ) { return $model->getScrollTypeStr(); } ],
		'circular' => [ 'title' => 'Circular' , 'generate' => function( $model ) { return $model->getCircularStr(); } ],
 		'actions' => 'Actions'
	],
	'gridCards' => [ 'root' => 'col col12', 'factor' => 'x3' ],
	'templateDir' => "$themeTemplates/widget/grid",
	//'dataView' => "$moduleTemplates/grid/data/gallery",
	//'cardView' => "$moduleTemplates/grid/cards/gallery",
	'actionView' => "$moduleTemplates/grid/actions/slider"
]) ?>

<?= Popup::widget([
	'title' => 'Bulk Sliders', 'size' => 'medium',
	'templateDir' => Yii::getAlias( "$themeTemplates/widget/popup/grid" ), 'template' => 'bulk',
	'data' => [ 'model' => 'Block', 'app' => 'grid', 'controller' => 'crud', 'action' => 'bulk', 'url' => "foxslider/slider/bulk" ]
]) ?>

<?= Popup::widget([
	'title' => 'Delete Slider', 'size' => 'medium',
	'templateDir' => Yii::getAlias( "$themeTemplates/widget/popup/grid" ), 'template' => 'delete',
	'data' => [ 'model' => 'Block', 'app' => 'grid', 'controller' => 'crud', 'action' => 'delete', 'url' => "foxslider/slider/delete?id=" ]
]) ?>
