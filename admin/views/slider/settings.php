<?php
// Yii Imports
use yii\widgets\ActiveForm;
use yii\helpers\Html;

// CMG Imports
use cmsgears\core\common\widgets\Editor;
use cmsgears\icons\widgets\TextureChooser;

// SF Imports
$coreProperties = $this->context->getCoreProperties();
$this->title 	= 'Block Settings | ' . $coreProperties->getSiteTitle();
$returnUrl		= $this->context->returnUrl;

$slideArrangement = [ 'filmstrip' => 'Filmstrip', 'stacked' => 'Stacked' ];

Editor::widget( [ 'selector' => '.content-editor', 'loadAssets' => true, 'fonts' => 'site', 'config' => [ 'controls' => 'mini' ] ] );
?>
<div class="box-crud-wrap row">
	<div class="box-crud-wrap-main row">
		<?php $form = ActiveForm::begin( [ 'id' => 'frm-settings', 'options' => [ 'class' => 'form' ] ] ); ?>
		<div class="row max-cols-100">
			<div class="col col3x2">
				<div class="box box-crud">
					<div class="box-header">
						<div class="box-header-title">Bullets</div>
					</div>
					<div class="box-content-wrap frm-split-40-60">
						<div class="box-content">
							<div class="row">
								<div class="col col4">
									<?= Yii::$app->formDesigner->getIconCheckbox( $form, $settings, 'bullets', null, 'cmti cmti-checkbox' ) ?>
								</div>
								<div class="col col4">
									<?= Yii::$app->formDesigner->getIconCheckbox( $form, $settings, 'bulletsIndexing', null, 'cmti cmti-checkbox' ) ?>
								</div>
								<div class="col col2">
									<?= $form->field( $settings, 'bulletClass' ) ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="filler-height"></div>
				<div class="box box-crud">
					<div class="box-header">
						<div class="box-header-title">Scrolling</div>
					</div>
					<div class="box-content-wrap frm-split-40-60">
						<div class="box-content">
							<div class="row">
								<div class="col col2">
									<?= $form->field( $settings, 'lControlClass' ) ?>
								</div>
								<div class="col col2">
									<?= $form->field( $settings, 'rControlClass' ) ?>
								</div>
							</div>
							<div class="row">
								<div class="col col2">
									<?= $form->field( $settings, 'lControlContent' )->textarea() ?>
								</div>
								<div class="col col2">
									<?= $form->field( $settings, 'rControlContent' )->textarea() ?>
								</div>
							</div>
							<div class="row">
								<div class="col col4">
									<?= Yii::$app->formDesigner->getIconCheckbox( $form, $settings, 'controls', null, 'cmti cmti-checkbox' ) ?>
								</div>
								<div class="col col4">
									<?= Yii::$app->formDesigner->getIconCheckbox( $form, $settings, 'stopOnHover', null, 'cmti cmti-checkbox' ) ?>
								</div>
							</div>
							<div class="row">
								<div class="col col2">
									<?= $form->field( $settings, 'autoScrollDuration' ) ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="filler-height"></div>
				<div class="box box-crud">
					<div class="box-header">
						<div class="box-header-title">Dimensions</div>
					</div>
					<div class="box-content-wrap frm-split-40-60">
						<div class="box-content">
							<div class="row">
								<div class="col col2">
									<?= $form->field( $settings, 'sliderWidth' ) ?>
								</div>
								<div class="col col2">
									<?= $form->field( $settings, 'sliderHeight' ) ?>
								</div>
							</div>
							<div class="row">
								<div class="col col2">
									<?= $form->field( $settings, 'slideWidth' ) ?>
								</div>
								<div class="col col2">
									<?= $form->field( $settings, 'slideHeight' ) ?>
								</div>
							</div>
							<div class="row">
								<div class="col col4">
									<?= Yii::$app->formDesigner->getIconCheckbox( $form, $settings, 'slideDimMax', null, 'cmti cmti-checkbox' ) ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="filler-height"></div>
				<div class="box box-crud">
					<div class="box-header">
						<div class="box-header-title">Slides</div>
					</div>
					<div class="box-content-wrap frm-split-40-60">
						<div class="box-content">
							<div class="row">
								<div class="col col4">
									<?= Yii::$app->formDesigner->getIconCheckbox( $form, $settings, 'resizeBkgImage', null, 'cmti cmti-checkbox' ) ?>
								</div>
								<div class="col col2">
									<?= TextureChooser::widget( [ 'model' => $settings, 'attribute' => 'slideTexture', 'options' => [ 'class' => 'icon-picker-wrap' ] ] ) ?>
								</div>
							</div>
							<div class="row">
								<div class="col col2">
									<?= $form->field( $settings, 'slideTemplate' ) ?>
								</div>
								<div class="col col2">
									<?= $form->field( $settings, 'slideTemplateDir' ) ?>
								</div>
							</div>
							<div class="row">
								<div class="col col2">
									<?= $form->field( $settings, 'slideArrangement' )->dropDownList( $slideArrangement, [ 'class' => 'cmt-select' ] ) ?>
								</div>
								<div class="col col2">
									<?= $form->field( $settings, 'bkgImageClass' ) ?>
								</div>
							</div>
							<div class="row">
								<div class="col col2">
									<?= $form->field( $settings, 'preSlideChange' )->textarea() ?>
								</div>
								<div class="col col2">
									<?= $form->field( $settings, 'postSlideChange' )->textarea() ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col col3">
				<div class="box-content-wysiwyg">
					<div class="box-content">
						<label>Footer Content Data</label>
						<?= $form->field( $settings, 'genericContent' )->textarea( [ 'class' => 'content-editor' ] )->label( false ) ?>
					</div>
				</div>
			</div>
		</div>
		<div class="filler-height filler-height-medium"></div>
		<div class="align align-right">
			<?= Html::a( 'View All', $returnUrl, [ 'class' => 'btn btn-medium' ] ); ?>
			<input class="frm-element-medium" type="submit" value="Submit" />
		</div>
		<div class="filler-height filler-height-medium"></div>
		<?php ActiveForm::end(); ?>
	</div>
</div>