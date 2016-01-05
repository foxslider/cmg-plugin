<?php
// Yii Imports
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= 'Delete Slider | ' . $coreProperties->getSiteTitle();
?>
<div class="box box-cud">
	<div class="box-wrap-header">
		<div class="header">Delete Slider</div>
	</div>
	<div class="box-wrap-content frm-split-40-60">
		<?php $form = ActiveForm::begin( [ 'id' => 'frm-slider' ] );?>

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

		<div class="clear filler-height"></div>

		<div class="align align-middle">
			<?=Html::a( 'Cancel', [ 'all' ], [ 'class' => 'btn btn-medium' ] );?>
			<input class="btn btn-medium" type="submit" value="Delete" />
		</div>

		<?php ActiveForm::end(); ?>
	</div>
</div>