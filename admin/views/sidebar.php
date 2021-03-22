<?php
// Yii Imports
use yii\helpers\Html;

$core	= Yii::$app->core;
$user	= $core->getUser();
?>
<?php if( $core->hasModule( 'foxslider' ) && $user->isPermitted( 'foxslider' ) ) { ?>
	<div id="sidebar-fxslider" class="collapsible-tab has-children <?= $parent == 'sidebar-fxslider' ? 'active' : null ?>">
		<div class="row tab-header">
			<div class="tab-icon"><span class="cmti cmti-brand cmti-brand-foxslider"></span></div>
			<div class="tab-title">Fox Slider</div>
		</div>
		<div class="tab-content clear <?= $parent == 'sidebar-fxslider' ? 'expanded visible' : null ?>">
			<ul>
				<li class="slider <?= $child == 'slider' ? 'active' : null ?>"><?= Html::a( 'Sliders', [ '/foxslider/slider/all' ] ) ?></li>
			</ul>
		</div>
	</div>
<?php } ?>
