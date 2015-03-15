<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= $coreProperties->getSiteTitle() . ' | Delete Slider';
?>
<section class="wrap-content container clearfix">
	<div class="cud-box">
		<h2>Delete Slider</h2>
		<?php $form = ActiveForm::begin( ['id' => 'frm-slider-delete', 'options' => ['class' => 'frm-split' ] ] );?>

    	<?= $form->field( $model, 'slider_name' )->textInput( [ 'disabled'=>'true' ] ) ?>
    	<?= $form->field( $model, 'slider_desc' )->textarea( [ 'disabled'=>'true' ] ) ?>

    	<?= $form->field( $model, 'slider_name' )->textInput( [ 'disabled'=>'true' ] ) ?>
    	<?= $form->field( $model, 'slider_desc' )->textarea( [ 'disabled'=>'true' ] ) ?>
    	<?= $form->field( $model, 'slider_full_page' )->checkbox( [ 'disabled'=>'true' ] ) ?>
    	<?= $form->field( $model, 'slider_width' )->textInput( [ 'disabled'=>'true' ] ) ?>
    	<?= $form->field( $model, 'slider_height' )->textInput( [ 'disabled'=>'true' ] ) ?>
    	<?= $form->field( $model, 'slider_slide_width' )->textInput( [ 'disabled'=>'true' ] ) ?>
    	<?= $form->field( $model, 'slider_slide_height' )->textInput( [ 'disabled'=>'true' ] ) ?>
    	<?= $form->field( $model, 'slider_scroll_auto' )->checkbox( [ 'disabled'=>'true' ] ) ?>
    	<?= $form->field( $model, 'slider_scroll_manual' )->checkbox( [ 'disabled'=>'true' ] ) ?>
    	<?= $form->field( $model, 'slider_circular' )->checkbox( [ 'disabled'=>'true' ] ) ?>

		<div class="box-filler"></div>

		<?=Html::a( "Cancel", [ '/foxslider/slider/all' ], ['class' => 'btn' ] );?>
		<input type="submit" value="Delete" />

		<?php ActiveForm::end(); ?>
	</div>
</section>

<script type="text/javascript">
	initSidebar( "sidebar-slider", -1 );
</script>