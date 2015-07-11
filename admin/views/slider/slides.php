<?php
// Yii Imports
use yii\widgets\ActiveForm;
use yii\helpers\Html;

// CMG Imports
use cmsgears\core\common\widgets\Editor;

use cmsgears\files\widgets\FileUploader;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= $coreProperties->getSiteTitle() . ' | Slider Slides';
$id				= $slider->id;

// Sidebar
$this->params['sidebar-parent'] = 'sidebar-slider';
$this->params['sidebar-child'] 	= 'slider';

Editor::widget( [ 'selector' => '.content-editor' ] );
?>
<section class="wrap-content container clearfix">
	<div class="cud-box">
		<h2>Slider Slides</h2>
		<form action="#" class="frm-split">
			<label>Name</label>
			<label><?=$slider->name?></label>
		</form>

		<h4>Create Slide</h4>
		<form class="frm-split frm-slide frm-ajax" id="frm-slide-create" cmt-controller="slider" cmt-action="updateSlide" action="<?php echo Yii::$app->urlManager->createAbsoluteUrl( 'apix/foxslider/slide/create' ); ?>" method="post">
			<!-- name -->
			<label>Title</label>
			<input type="text" name="Slide[name]" placeholder="Title">
			<div class="clear"><span class="error" cmt-error="name"></span></div>
			<!-- desc -->
			<label>Description</label>
			<input type="text" name="Slide[description]" placeholder="Description">
			<div class="clear"><span class="error" cmt-error="description"></span></div>
			<!-- content -->
			<label>Content</label>
			<textarea class="editor-slide content-editor" name="Slide[content]" placeholder="Content"></textarea>
			<div class="clear"><span class="error" cmt-error="content"></span></div>
			<!-- url -->
			<label>Slide Url</label>
			<input type="text" name="Slide[url]" placeholder="Url">
			<div class="clear"><span class="error" cmt-error="url"></span></div>
			<input type="hidden" name="Slide[sliderId]" value="<?=$slider->id?>" />
			<?=FileUploader::widget( [ 'options' => 
					[ 'id' => 'slider-slide', 'class' => 'file-uploader' ], 
					'directory' => 'gallery', 'infoFields' => true,
					'btnChooserIcon' => 'icon-action icon-action-edit' ] );?>
			<!-- submit, spinner, success -->
			<div class="spinner"></div>
			<div class="message"></div>
            <input type="submit" class="" value="Create">
		</form>

		<h4>All Slides</h4>
		
		<ul class="slider-slides clearfix">
		<?php
			foreach ( $slides as $slide ) {

				$slideId	= $slide->id;
				$slideImage	= $slide->image;
		?>
			<li>
				<form class="frm-ajax" id="frm-slide-update-<?=$slideId?>" cmt-controller="slider" cmt-action="updateSlide" action="<?php echo Yii::$app->urlManager->createAbsoluteUrl("apix/foxslider/slide/update?id=$slideId"); ?>" method="post" cmt-keep-data="true" >
					<!-- name -->
					<label>Title</label>
					<input type="text" name="Slide[name]" value="<?=$slide->name?>" placeholder="Title">
					<div class="clear"><span class="error" cmt-error="name"></span></div>
					<!-- desc -->
					<label>Description</label>
					<input type="text" name="Slide[description]" value="<?=$slide->description?>" placeholder="Description">
					<div class="clear"><span class="error" cmt-error="description"></span></div>
					<!-- content -->
					<label>Content</label>
					<textarea class="editor-slide content-editor" name="Slide[content]" placeholder="Content"><?=$slide->content?></textarea>
					<div class="clear"><span class="error" cmt-error="content"></span></div>
					<!-- url -->
					<label>Slide Url</label>
					<input type="text" name="Slide[url]" value="<?=$slide->url?>" placeholder="Url">
					<div class="clear"><span class="error" cmt-error="url"></span></div>
					<input type="hidden" name="Slide[sliderId]" value="<?=$slider->id?>" />	
					<?=FileUploader::widget( [ 'options' => 
							[ 'id' => "slider-slide-$slideId", 'class' => 'file-uploader' ], 
							'model' => $slide->image, 'directory' => 'gallery', 'infoFields' => true,
							'btnChooserIcon' => 'icon-action icon-action-edit' ] );?>				
					<!-- submit, spinner, success -->
					<div class="spinner"></div>
					<div class="message"></div>
		            <input type="submit" class="" value="Update">
				</form>
			</li>
		<?php
			}
		?>
		</ul>
	</div>
</section>

<script type="text/javascript">

/* FoxSlider Controller */
var CONTROLLER_SLIDER			= 'slider';
var ACTION_SLIDE_UPDATE			= 'updateSlide';

jQuery( document ).ready( function() {

	postAjaxProcessor.addSuccessListener( postFxsProcessorSuccess );
});

// Forms --------------------------------------------------------------------------

function postFxsProcessorSuccess( formId, controllerId, actionId, data ) {

	switch( controllerId ) {
		
		case CONTROLLER_SLIDER:
		{
			switch( actionId ) {

				case ACTION_SLIDE_UPDATE:
				{
					location.reload();

					break;
				}
			}
			
			break;
		}
	}
}

</script>