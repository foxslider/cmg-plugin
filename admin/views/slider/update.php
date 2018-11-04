<?php
// Yii Imports
use yii\widgets\ActiveForm;
use yii\helpers\Html;

// FX Imports
use foxslider\common\models\entities\Slider;

$modelClass		= $this->context->modelService->getModelClass();
$scrollTypeMap	= $modelClass::$scrollTypeMap;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= 'Update Slider | ' . $coreProperties->getSiteTitle();
$returnUrl		= $this->context->returnUrl;

$statusMap = Slider::$statusMap;
?>
<div class="box-crud-wrap row">
	<div class="box-crud-wrap-main colf colf3x2">
		<?php $form = ActiveForm::begin( [ 'id' => 'frm-slider', 'options' => [ 'class' => 'form' ] ] ); ?>
		<div class="box box-crud">
			<div class="box-header">
				<div class="box-header-title">Basic Details</div>
			</div>
			<div class="box-content-wrap frm-split-40-60">
				<div class="box-content">
					<div class="row">
						<div class="col col3">
							<?= $form->field( $model, 'name' ) ?>
						</div>
						<div class="col col3">
							<?= $form->field( $model, 'slug' ) ?>
						</div>
						<div class="col col3">
							<?= $form->field( $model, 'scrollType' )->dropDownList( $scrollTypeMap, [ 'class' => 'cmt-select' ] ) ?>
						</div>
					</div>
					<div class="row">
						<div class="col col2">
							<?= $form->field( $model, 'slideWidth' ) ?>
						</div>
						<div class="col col2">
							<?= $form->field( $model, 'slideHeight' ) ?>
						</div>
					</div>
					<div class="row">
						<div class="col col2">
							<?= $form->field( $model, 'description' )->textarea() ?>
						</div>
						<div class="col col2">
							<?= Yii::$app->formDesigner->getIconCheckbox( $form, $model, 'scrollAuto', null, 'cmti cmti-checkbox' ) ?>
						</div>
					</div>
					<div class="row">
						<div class="col col2">
							<?= Yii::$app->formDesigner->getIconCheckbox( $form, $model, 'circular', null, 'cmti cmti-checkbox' ) ?>
						</div>
						<div class="col col2">
							<?= Yii::$app->formDesigner->getIconCheckbox( $form, $model, 'fullPage', null, 'cmti cmti-checkbox' ) ?>
						</div>
					</div>
					<div class="row">
						<div class="col col2">
							<?= $form->field( $model, 'status' )->dropDownList( $statusMap, [ 'class' => 'cmt-select' ] ) ?>
						</div>
						<div class="col col2">
							<?= $form->field( $model, 'htmlOptions' )->textarea() ?>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="filler-height filler-height-medium"></div>

		<div class="align align-right">
			<?= Html::a( 'View All', $returnUrl, [ 'class' => 'btn btn-medium' ] ); ?>
			<input class="frm-element-medium" type="submit" value="Update" />
		</div>

		<div class="filler-height filler-height-medium"></div>
		<?php ActiveForm::end(); ?>
	</div>
	<div class="box-crud-wrap-sidebar colf colf3">

	</div>
</div>
