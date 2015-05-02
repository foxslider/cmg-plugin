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

    	<?= $form->field( $model, 'name' )->textInput( [ 'readonly'=>'true' ] ) ?>
    	<?= $form->field( $model, 'description' )->textarea( [ 'readonly'=>'true' ] ) ?>
    	<?= $form->field( $model, 'fullPage' )->checkbox( [ 'disabled'=>'true' ] ) ?>
    	<?= $form->field( $model, 'width' )->textInput( [ 'readonly'=>'true' ] ) ?>
    	<?= $form->field( $model, 'height' )->textInput( [ 'readonly'=>'true' ] ) ?>
    	<?= $form->field( $model, 'slideWidth' )->textInput( [ 'readonly'=>'true' ] ) ?>
    	<?= $form->field( $model, 'slideHeight' )->textInput( [ 'readonly'=>'true' ] ) ?>
    	<?= $form->field( $model, 'scrollAuto' )->checkbox( [ 'disabled'=>'true' ] ) ?>
    	<?= $form->field( $model, 'scrollType' )->dropDownList( $scrollTypeMap, [ 'disabled'=>'true' ] ) ?>
    	<?= $form->field( $model, 'circular' )->checkbox( [ 'disabled'=>'true' ] ) ?>

		<div class="box-filler"></div>

		<?=Html::a( "Cancel", [ '/foxslider/slider/all' ], ['class' => 'btn' ] );?>
		<input type="submit" value="Delete" />

		<?php ActiveForm::end(); ?>
	</div>
</section>

<script type="text/javascript">
	initSidebar( "sidebar-slider", 0 );
</script>