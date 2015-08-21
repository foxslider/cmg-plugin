<?php
// Yii Imports
use \Yii;
use yii\helpers\Html;
use yii\helpers\Url;

$core	= Yii::$app->cmgCore;
$user	= Yii::$app->user->getIdentity();
?>

<?php if( Yii::$app->cmgCore->hasModule( 'foxslider' ) && $user->isPermitted( 'foxslider' ) ) { ?>
	<div id="sidebar-slider" class="collapsible-tab has-children <?php if( strcmp( $parent, 'sidebar-slider' ) == 0 ) echo 'active';?>">
		<div class="collapsible-tab-header clearfix">
			<div class="colf colf4"><span class="icon-sidebar icon-slider"></span></div>
			<div class="colf colf4x3">Fox Slider</div>
		</div>
		<div class="collapsible-tab-content clear <?php if( strcmp( $parent, 'sidebar-slider' ) == 0 ) echo 'expanded visible';?>">
			<ul>
				<li class="slider <?php if( strcmp( $child, 'district' ) == 0 ) echo 'slider';?>"><?= Html::a( "Sliders", ['/foxslider/slider/all'] ) ?></li>
			</ul>
		</div>
	</div>
<?php } ?>