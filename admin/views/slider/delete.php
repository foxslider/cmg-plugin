<?php
// Yii Imports
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$modelClass		= $this->context->modelService->getModelClass();
$scrollTypeMap	= $modelClass::$scrollTypeMap;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= 'Delete Slider | ' . $coreProperties->getSiteTitle();
$returnUrl		= $this->context->returnUrl;
?>
<div class="box-crud-wrap row">
	<div class="box-crud-wrap-main colf colf3x2">
		<?php $form = ActiveForm::begin( [ 'id' => 'frm-block', 'options' => [ 'class' => 'form' ] ] ); ?>
		<div class="box box-crud">
			<div class="box-header">
				<div class="box-header-title">Basic Details</div>
			</div>
			<div class="box-content-wrap frm-split-40-60">
				<div class="box-content">
					<div class="row">
						<div class="col col2">
							<?= $form->field( $model, 'name' )->textInput( [ 'readonly' => 'true' ] ) ?>
						</div>
						<div class="col col2">
							<?= $form->field( $model, 'scrollType' )->dropDownList( $scrollTypeMap, [ 'class' => 'cmt-select', 'disabled' => 'true' ] ) ?>
						</div>
					</div>
					<div class="filler-height"> </div>
					<div class="row">
						<div class="col col2">
							<?= $form->field( $model, 'height' )->textInput( [ 'readonly' => 'true' ] ) ?>
						</div>
						<div class="col col2">
							<?= $form->field( $model, 'width' )->textInput( [ 'readonly' => 'true' ] ) ?>
						</div>
					</div>
					<div class="filler-height"> </div>
					<div class="row">
						<div class="col col2">

							<?= $form->field( $model, 'slideWidth' )->textInput( [ 'readonly' => 'true' ] ) ?>
						</div>
						<div class="col col2">
							<?= $form->field( $model, 'slideHeight' )->textInput( [ 'readonly' => 'true' ] ) ?>
						</div>
					</div>
					<div class="filler-height"> </div>
					<div class="row">
						<div class="col col2">
							<?= $form->field( $model, 'description' )->textarea( [ 'readonly' => 'true' ] ) ?>
						</div>
						<div class="col col2">
							<?= Yii::$app->formDesigner->getIconCheckbox( $form, $model, 'scrollAuto', [ 'disabled' => true ], 'cmti cmti-checkbox' ) ?>
						</div>
					</div>
					<div class="filler-height"> </div>
					<div class="row">
						<div class="col col2">
							<?= Yii::$app->formDesigner->getIconCheckbox( $form, $model, 'circular', [ 'disabled' => true ], 'cmti cmti-checkbox' ) ?>
						</div>
						<div class="col col2">
							<?= Yii::$app->formDesigner->getIconCheckbox( $form, $model, 'fullPage', [ 'disabled' => true ], 'cmti cmti-checkbox' ) ?>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="filler-height filler-height-medium"></div>

		<div class="align align-right">
			<?= Html::a( 'Cancel', $returnUrl, [ 'class' => 'btn btn-medium' ] ); ?>
			<input class="element-medium" type="submit" value="Delete" />
		</div>

		<div class="filler-height filler-height-medium"></div>
		<?php ActiveForm::end(); ?>
	</div>
	<div class="box-crud-wrap-sidebar colf colf3">

	</div>
</div>
