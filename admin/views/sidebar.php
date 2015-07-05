<?php
// Yii Imports
use \Yii;
use yii\helpers\Html;
use yii\helpers\Url;

$core	= Yii::$app->cmgCore;
$user	= Yii::$app->user->getIdentity();
?>

<?php if( Yii::$app->cmgCore->hasModule( 'foxslider' ) && $user->isPermitted( 'foxslider' ) ) { ?>
	<div class="collapsible-tab has-children" id="sidebar-slider">
		<div class="collapsible-tab-header clearfix">
			<div class="colf colf4"><span class="icon-sidebar icon-slider"></span></div>
			<div class="colf colf4x3">Fox Slider</div>
		</div>
		<div class="collapsible-tab-content clear">
			<ul>
				<li class='slider'><?= Html::a( "Sliders", ['/foxslider/slider/all'] ) ?></li>
			</ul>
		</div>
	</div>
<?php } ?>