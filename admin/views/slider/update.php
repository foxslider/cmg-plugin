<?php
// Yii Imports
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= 'Update Slider | ' . $coreProperties->getSiteTitle();

$modelClass		= $this->context->modelService->getModelClass();
$scrollTypeMap	= $modelClass::$scrollTypeMap;
?>
<div class="box box-cud">
	<div class="box-wrap-header">
		<div class="header">Update Slider</div>
	</div>
	<div class="box-wrap-content frm-split-40-60">
		<?php $form = ActiveForm::begin( [ 'id' => 'frm-slider' ] );?>

    	<?= $form->field( $model, 'name' ) ?>
    	<?= $form->field( $model, 'description' )->textarea() ?>
    	<?= $form->field( $model, 'fullPage' )->checkbox() ?>
    	<?= $form->field( $model, 'width' ) ?>
    	<?= $form->field( $model, 'height' ) ?>
    	<?= $form->field( $model, 'slideWidth' ) ?>
    	<?= $form->field( $model, 'slideHeight' ) ?>
    	<?= $form->field( $model, 'scrollAuto' )->checkbox() ?>
    	<?= $form->field( $model, 'scrollType' )->dropDownList( $scrollTypeMap ) ?>
    	<?= $form->field( $model, 'circular' )->checkbox() ?>

		<div class="clear filler-height"></div>

		<div class="align align-center">
			<?=Html::a( 'Cancel', [ 'all' ], [ 'class' => 'btn btn-medium' ] );?>
			<input class="element-medium" type="submit" value="Update" />
		</div>

		<?php ActiveForm::end(); ?>
	</div>
</div>