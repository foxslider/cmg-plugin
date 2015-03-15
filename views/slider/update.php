<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= $coreProperties->getSiteTitle() . ' | Update Slider';
?>
<section class="wrap-content container clearfix">
	<div class="cud-box">
		<h2>Update Slider</h2>
		<?php $form = ActiveForm::begin( ['id' => 'frm-slider-update', 'options' => ['class' => 'frm-split' ] ] );?>

    	<?= $form->field( $model, 'slider_name' ) ?>
    	<?= $form->field( $model, 'slider_name' ) ?>
    	<?= $form->field( $model, 'slider_desc' )->textarea() ?>
    	<?= $form->field( $model, 'slider_full_page' )->checkbox() ?>
    	<?= $form->field( $model, 'slider_width' ) ?>
    	<?= $form->field( $model, 'slider_height' ) ?>
    	<?= $form->field( $model, 'slider_slide_width' ) ?>
    	<?= $form->field( $model, 'slider_slide_height' ) ?>
    	<?= $form->field( $model, 'slider_scroll_auto' )->checkbox() ?>
    	<?= $form->field( $model, 'slider_scroll_manual' )->checkbox() ?>
    	<?= $form->field( $model, 'slider_circular' )->checkbox() ?>
 
		<div class="box-filler"></div>

		<?=Html::a( "Back", [ '/foxslider/slider/all' ], ['class' => 'btn' ] );?>
		<input type="submit" value="Update" />

		<?php ActiveForm::end(); ?>
	</div>
</section>

<script type="text/javascript">
	initSidebar( "sidebar-slider", -1 );
</script>