<?php
// Yii Imports
use yii\widgets\ActiveForm;
use yii\helpers\Html;

// CMG Imports
use cmsgears\core\widgets\Editor;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= $coreProperties->getSiteTitle() . ' | Slider Slides';

Editor::widget( [ 'selector' => '.content-editor' ] );
?>
<section class="wrap-content container clearfix">
	<div class="cud-box">
		<h2>Slider Slides</h2>
		<form action="#" class="frm-split">
			<label>Name</label>
			<label><?=$slider->name?></label>
			<label>Description</label>
			<label><?=$slider->description?></label>
		</form>

		<h4>Create Slide</h4>
		<form class="frm-split frm-ajax" id="frm-slide-create" group="1001" key="1001" action="<?php echo Yii::$app->urlManager->createAbsoluteUrl("apix/foxslider/slide/create"); ?>" method="post">
			<!-- name -->
			<label>Title</label>
			<input type="text" name="Slide[name]" placeholder="Title">
			<span class="form-error" formError="name"></span>
			<!-- desc -->
			<label>Description</label>
			<input type="text" name="Slide[description]" placeholder="Description">
			<span class="form-error" formError="description"></span>
			<!-- content -->
			<label>Content</label>
			<textarea class="editor-slide content-editor" name="Slide[content]" placeholder="Content"></textarea>
			<span class="form-error" formError="content"></span>
			<!-- url -->
			<label>Slide Url</label>
			<input type="text" name="Slide[url]" placeholder="Url">
			<span class="form-error" formError="url"></span>
			<input type="hidden" name="Slide[sliderId]" value="<?=$slider->id?>" />
			<div id="file-slide" class="file-container" legend="Slide Image" selector="slide" utype="image" btn-class="btn file-input-wrap" btn-text="Choose Image">
				<div class="file-fields">
					<input type="hidden" name="File[name]" class= "file-name" />
					<input type="hidden" name="File[extension]" class= "file-extension" />
					<input type="hidden" name="File[directory]" value="slide" />
					<input type="hidden" name="File[changed]" class="file-change" />
					<label>Image Description</label> <input type="text" name="File[description]" />
					<label>Image Alternate Text</label> <input type="text" name="File[altText]" />
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

				$slideId	= $slide->id;
				$slideImage	= $slide->image;
		?>
			<li>
				<form class="frm-ajax" group="1001" key="1001" id="frm-slide-update-<?=$slideId?>" group="0" key="0" action="<?php echo Yii::$app->urlManager->createAbsoluteUrl("apix/foxslider/slide/update?id=$slideId"); ?>" method="post" keepData="true" >
					<!-- name -->
					<label>Title</label>
					<input type="text" name="Slide[name]" value="<?=$slide->name?>" placeholder="Title">
					<span class="form-error" formError="name"></span>
					<!-- desc -->
					<label>Description</label>
					<input type="text" name="Slide[description]" value="<?=$slide->description?>" placeholder="Description">
					<span class="form-error" formError="description"></span>
					<!-- content -->
					<label>Content</label>
					<textarea class="editor-slide content-editor" name="Slide[content]" placeholder="Content"><?=$slide->content?></textarea>
					<span class="form-error" formError="content"></span>
					<!-- url -->
					<label>Slide Url</label>
					<input type="text" name="Slide[url]" value="<?=$slide->url?>" placeholder="Url">
					<span class="form-error" formError="url"></span>

					<div id="file-slide-<?=$slideId?>" class="file-container" legend="Slide Image" selector="slide" utype="image" btn-class="btn file-input-wrap" btn-text="Change Image">
						<div class="file-fields">
							<input type="hidden" name="File[id]" value="<?php if( isset( $slideImage ) ) echo $slideImage->id; ?>" />
							<input type="hidden" name="File[name]" class= "file-name" value="<?php if( isset( $slideImage ) ) echo $slideImage->name; ?>" />
							<input type="hidden" name="File[extension]" class= "file-extension" value="<?php if( isset( $slideImage ) ) echo $slideImage->extension; ?>" />
							<input type="hidden" name="File[directory]" value="slide" />
							<input type="hidden" name="File[changed]" class="file-change" />
							<label>Slide Description</label> <input type="text" name="File[description]" value="<?php if( isset( $slideImage ) ) echo $slideImage->description; ?>" />
							<label>Slide Alternate Text</label> <input type="text" name="File[altText]" value="<?php if( isset( $slideImage ) ) echo $slideImage->altText; ?>" />
						</div>
					</div>

					<input type="hidden" name="Slide[sliderId]" value="<?=$slider->id?>" />					
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

		$slideId		= $slide->id;
		$slideImage		= $slide->image;

		if( isset( $slideImage ) ) {

			$slideImageUrl	= $slideImage->getFileUrl(); 
			$image 			= "<img src='$slideImageUrl' />";
?>

			jQuery("#frm-slide-update-<?=$slideId?> .file-image").html( "<?= $image ?>" );

<?php 
		}
	}
?>
</script>