<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use cmsgears\widgets\other\Editor;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= $coreProperties->getSiteTitle() . ' | Slider Slides';

Editor::widget( [ 'selector' => '.content-editor' ] );
?>
<section class="wrap-content container clearfix">
	<div class="cud-box">
		<h2>Slider Slides</h2>
		<form action="#" class="frm-split">
			<label>Name</label>
			<label><?=$model->getName()?></label>
			<label>Description</label>
			<label><?=$model->getDesc()?></label>
		</form>

		<h4>Create Slide</h4>
		<form class="frm-split frm-ajax" id="frm-slide-create" group="1001" key="1001" action="<?php echo Yii::$app->urlManager->createAbsoluteUrl("apix/foxslider/slide/create"); ?>" method="post">
			<!-- name -->
			<label>Title</label>
			<input type="text" name="Slide[slide_name]" placeholder="Title">
			<span class="form-error" formError="slide_name"></span>
			<!-- desc -->
			<label>Description</label>
			<input type="text" name="Slide[slide_desc]" placeholder="Description">
			<span class="form-error" formError="slide_desc"></span>
			<!-- content -->
			<label>Content</label>
			<textarea class="editor-slide content-editor" name="Slide[slide_content]" placeholder="Content"></textarea>
			<span class="form-error" formError="slide_content"></span>
			<!-- url -->
			<label>Slide Url</label>
			<input type="text" name="Slide[slide_url]" placeholder="Url">
			<span class="form-error" formError="slide_url"></span>
			<input type="hidden" name="Slide[slide_slider]" value="<?=$model->getId()?>" />
			<div id="file-slide" class="file-container" legend="Slide Image" selector="slide" utype="image" btn-class="btn file-input-wrap" btn-text="Choose Image">
				<div class="file-fields">
					<input type="hidden" name="File[file_name]" class= "file-name" />
					<input type="hidden" name="File[file_extension]" class= "file-extension" />
					<input type="hidden" name="File[file_directory]" value="slide" />
					<input type="hidden" name="File[changed]" class="file-change" />
					<label>Image Description</label> <input type="text" name="File[file_desc]" />
					<label>Image Alternate Text</label> <input type="text" name="File[file_alt_text]" />
				</div>
			</div>
			<!-- submit -->
            <input type="submit" class="" value="Create">
			<!-- spinner and success -->
			<div class="spinner"></div>
			<div class="frm-message"></div>
		</form>

		<h4>All Slides</h4>
		
		<ul class="slider-slides clearfix">
		<?php
			foreach ( $slides as $slide ) {

				$slideId	= $slide->getId();
				$slideImage	= $slide->slideImage;
		?>
			<li>
				<form class="frm-ajax" group="1001" key="1001" id="frm-slide-update-<?=$slideId?>" group="0" key="0" action="<?php echo Yii::$app->urlManager->createAbsoluteUrl("apix/foxslider/slide/update?id=$slideId"); ?>" method="post" keepData="true" >
					<!-- name -->
					<label>Title</label>
					<input type="text" name="Slide[slide_name]" value="<?=$slide->getName()?>" placeholder="Title">
					<span class="form-error" formError="slide_name"></span>
					<!-- desc -->
					<label>Description</label>
					<input type="text" name="Slide[slide_desc]" value="<?=$slide->getDesc()?>" placeholder="Description">
					<span class="form-error" formError="slide_desc"></span>
					<!-- content -->
					<label>Content</label>
					<textarea class="editor-slide content-editor" name="Slide[slide_content]" placeholder="Content"><?=$slide->getContent()?></textarea>
					<span class="form-error" formError="slide_content"></span>
					<!-- url -->
					<label>Slide Url</label>
					<input type="text" name="Slide[slide_url]" value="<?=$slide->getUrl()?>" placeholder="Url">
					<span class="form-error" formError="slide_url"></span>

					<div id="file-slide-<?=$slideId?>" class="file-container" legend="Slide Image" selector="slide" utype="image" btn-class="btn file-input-wrap" btn-text="Change Image">
						<div class="file-fields">
							<input type="hidden" name="File[file_id]" value="<?php if( isset( $slideImage ) ) echo $slideImage->getId(); ?>" />
							<input type="hidden" name="File[file_name]" class= "file-name" />
							<input type="hidden" name="File[file_extension]" class= "file-extension" />
							<input type="hidden" name="File[file_directory]" value="slide" />
							<input type="hidden" name="File[changed]" class="file-change" />
							<label>Slide Description</label> <input type="text" name="File[file_desc]" value="<?php if( isset( $slideImage ) ) echo $slideImage->getDesc(); ?>" />
							<label>Slide Alternate Text</label> <input type="text" name="File[file_alt_text]" value="<?php if( isset( $slideImage ) ) echo $slideImage->getAltText(); ?>" />
						</div>
					</div>

					<input type="hidden" name="Slide[slide_slider]" value="<?=$model->getId()?>" />					
					<!-- submit -->
		            <input type="submit" class="" value="Update">
					<!-- spinner and success -->
					<div class="spinner"></div>
					<div class="frm-message"></div>
				</form>
			</li>
		<?php
			}
		?>
		</ul>
	</div>
</section>

<script type="text/javascript">
	initSidebar( "sidebar-slider", -1 );
	initFileUploader();

<?php 
	foreach ( $slides as $slide ) {

		$slideId		= $slide->getId();
		$slideImage		= $slide->slideImage;

		if( isset( $slideImage ) ) {

			$slideImageUrl	= Yii::$app->fileManager->uploadUrl . $slideImage->getUrl(); 
			$image 			= "<img src='$slideImageUrl' />";
?>

			jQuery("#frm-slide-update-<?=$slideId?> .file-image").html( "<?= $image ?>" );

<?php 
		}
	}
?>
</script>