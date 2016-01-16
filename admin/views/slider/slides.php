<?php
// Yii Imports
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

// CMG Imports
use cmsgears\core\common\widgets\Editor;
use cmsgears\files\widgets\ImageUploader;

use cmsgears\core\common\utilities\CodeGenUtil;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= 'Slider Slides | ' . $coreProperties->getSiteTitle();
$id				= $slider->id;

Editor::widget( [ 'selector' => '.content-editor', 'loadAssets' => true ] );
?>
<div class="box box-cud">
	<div class="box-wrap-header">
		<div class="header">Slider Slides</div>
	</div>
	<div class="box-wrap-content clearfix">

		<div class="box-content">
			<div class="header">Slider Details</div>
			<div class="info">
				<table>
					<tr><td>Name</td><td><?=$slider->name?></td></tr>
				</table>
			</div>
		</div>

		<div class="box-content frm-split-40-60 clearfix">
			<div class="header">Create Slide</div>
			<form class="frm-split frm-slide fxs-form" id="frm-slide-create" cmt-controller="fxslider" cmt-action="updateSlide" action="<?= Url::toRoute( [ '/apix/foxslider/slide/create' ], true ) ?>" method="post">
				<!-- name -->
				<label>Title</label>
				<input type="text" name="Slide[name]" placeholder="Title">
				<div class="clear"><span class="error" cmt-error="name"></span></div>
				<!-- desc -->
				<label>Description</label>
				<textarea name="Slide[description]" placeholder="Description"></textarea>
				<div class="clear"><span class="error" cmt-error="description"></span></div>
				<!-- content -->
				<div class="clear"></div>
				<div class="box-content clearfix">
					<div class="header">Slide Content</div>
					<textarea class="editor-slide content-editor" name="Slide[content]" placeholder="Content"></textarea>
					<div class="clear"><span class="error" cmt-error="content"></span></div>
				</div>
				<!-- url -->
				<label>Slide Url</label>
				<input type="text" name="Slide[url]" placeholder="Url">
				<div class="clear"><span class="error" cmt-error="url"></span></div>
				<input type="hidden" name="Slide[sliderId]" value="<?=$slider->id?>" />
				<?= ImageUploader::widget([ 
						'options' => [ 'id' => 'slider-slide', 'class' => 'file-uploader' ],
						'directory' => 'gallery', 'info' => true, 'seoInfoOnly' => true
				]); ?>
				<!-- submit, spinner, success -->
				<div class="spinner"></div>
				<div class="message"></div>
	            <input type="submit" class="" value="Create">
			</form>
		</div>

		<div class="box-content frm-split-40-60 clearfix">
			<div class="header">All Slides</div>
			<ul class="slider-slides clearfix">
		<?php
			foreach ( $slides as $slide ) {

				$slideId	= $slide->id;
				$slideImage	= $slide->image;
		?>
				<li>
					<form class="fxs-form frm-split" id="frm-slide-update-<?=$slideId?>" cmt-controller="fxslider" cmt-action="updateSlide" action="<?= Url::toRoute( [ "/apix/foxslider/slide/update?id=$slideId" ], true ) ?>" method="post" cmt-clear="false" >
						<!-- name -->
						<label>Title</label>
						<input type="text" name="Slide[name]" value="<?=$slide->name?>" placeholder="Title">
						<div class="clear"><span class="error" cmt-error="name"></span></div>
						<!-- desc -->
						<label>Description</label>
						<textarea name="Slide[description]" value="<?=$slide->description?>" placeholder="Description"></textarea>
						<div class="clear"><span class="error" cmt-error="description"></span></div>
						<!-- content -->
						<div class="box-content clearfix">
							<div class="header">Slide Content</div>
							<textarea class="editor-slide content-editor" name="Slide[content]" placeholder="Content"><?=$slide->content?></textarea>
							<div class="clear"><span class="error" cmt-error="content"></span></div>
						</div>
						<!-- url -->
						<label>Slide Url</label>
						<input type="text" name="Slide[url]" value="<?=$slide->url?>" placeholder="Url">
						<div class="clear"><span class="error" cmt-error="url"></span></div>
						<input type="hidden" name="Slide[sliderId]" value="<?=$slider->id?>" />
						<?= ImageUploader::widget([ 
								'options' => [ 'id' => 'slider-slide-$slideId', 'class' => 'file-uploader' ],
								'model' => $slide->image, 'directory' => 'gallery', 'info' => true, 'seoInfoOnly' => true
						]); ?>
						<!-- submit, spinner, success -->
						<div class="spinner"></div>
						<div class="message"></div>
			            <input type="submit" class="" value="Update">
					</form>
				</li>
		<?php } ?>
			</ul>
		</div>
	</div>
</div>

<?= CodeGenUtil::registerJsFromFile( $this, View::POS_END, dirname( __DIR__ ) . "/scripts/main.js" ); ?> 