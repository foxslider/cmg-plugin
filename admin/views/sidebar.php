<?php
// Yii Imports
use yii\helpers\Html;
use yii\helpers\Url;

$core	= Yii::$app->core;
$user	= Yii::$app->user->getIdentity();
?>

<?php if( $core->hasModule( 'foxslider' ) && $user->isPermitted( 'foxslider' ) ) { ?>
	<div id="sidebar-fxslider" class="collapsible-tab has-children <?php if( strcmp( $parent, 'sidebar-fxslider' ) == 0 ) echo 'active'; ?>">
		<div class="collapsible-tab-header clearfix">
			<div class="colf colf5 wrap-icon"><span class="cmti cmti-vc-foxslider"></span></div>
			<div class="colf colf5x4">Fox Slider</div>
		</div>
		<div class="collapsible-tab-content clear <?php if( strcmp( $parent, 'sidebar-fxslider' ) == 0 ) echo 'expanded visible'; ?>">
			<ul>
				<li class="slider <?php if( strcmp( $child, 'slider' ) == 0 ) echo 'slider'; ?>"><?= Html::a( 'Sliders', [ '/foxslider/slider/all' ] ) ?></li>
			</ul>
		</div>
	</div>
<?php } ?>