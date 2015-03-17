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

    	<?= $form->field( $model, 'name' ) ?>
    	<?= $form->field( $model, 'description' )->textarea() ?>
    	<?= $form->field( $model, 'fullPage' )->checkbox() ?>
    	<?= $form->field( $model, 'width' ) ?>
    	<?= $form->field( $model, 'height' ) ?>
    	<?= $form->field( $model, 'slideWidth' ) ?>
    	<?= $form->field( $model, 'slideHeight' ) ?>
    	<?= $form->field( $model, 'scrollAuto' )->checkbox() ?>
    	<?= $form->field( $model, 'scrollManual' )->checkbox() ?>
    	<?= $form->field( $model, 'circular' )->checkbox() ?>
 
		<div class="box-filler"></div>

		<?=Html::a( "Back", [ '/foxslider/slider/all' ], ['class' => 'btn' ] );?>
		<input type="submit" value="Update" />

		<?php ActiveForm::end(); ?>
	</div>
</section>

<script type="text/javascript">
	initSidebar( "sidebar-slider", -1 );
</script>