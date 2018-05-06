<?php
// CMG Imports
use cmsgears\files\widgets\ImageUploader;

$coreProperties = $this->context->getCoreProperties();
$this->title	= 'Slider Slide | ' . $coreProperties->getSiteTitle();
?>
<div class="box-crud-wrap row">
	<div class="box-crud-wrap-main colf colf3x2">
		<div class="box box-crud">
			<div class="box-header">
				<div class="box-header-title">Slider Slides</div>
			</div>
			<div class="box-content-wrap frm-split-40-60">
				<div class="box-content">
					<div class="row">
						<div class="col col2">
							<label>Name</label>
							<input type="text" name="slidername" value="<?= $slider->name ?>" disabled="" >
						</div>
						<div class="col col2">
							<label>Description</label>
							<input type="text" name="slidername" value="<?= $slider->description ?>" disabled="" >
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="filler-height filler-height-medium"></div>
		<form class="frm-split frm-slide fxs-form" cmt-app="main" cmt-controller="gallery" cmt-action="updateItem" action="foxslider/slide/create">
			<div class="box box-crud">
				<div class="box-header">
					<div class="box-header-title">Slide info</div>
				</div>
				<div class="box-content-wrap">
					<div class="box-content">
						<div class="row">
							<div class="col col2">
								<label>Title</label>
								<input type="text" name="Slide[name]" placeholder="Title">
								<div class="clear"><span class="error" cmt-error="name"></span></div>
							</div>
							<div class="col col2">
								<label>Slide Url</label>
								<input type="text" name="Slide[url]" placeholder="Url">
								<div class="clear"><span class="error" cmt-error="url"></span></div>
								<input type="hidden" name="Slide[sliderId]" value="<?=$slider->id?>" />
							</div>
						</div>
						<div class="row">
							<div class="col col2">
								<label>Description</label>
								<textarea name="Slide[description]" placeholder="Description"></textarea>
								<div class="clear"><span class="error" cmt-error="description"></span></div>
							</div>
							<div class="col col2">
								<label >Slide Content</label>
								<textarea class="editor-slide content-editor" name="Slide[content]" placeholder="Content"></textarea>
								<div class="clear"><span class="error" cmt-error="content"></span></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="box box-crud">
				<div class="box-header">
					<div class="box-header-title">Image</div>
				</div>
				<div class="box-content-wrap frm-split-40-60">
					<div class="box-content">
						<div class="row row-inline">
							<?= ImageUploader::widget([
								'directory' => 'slider', 'showFields' => true, 'modelClass' => 'File', 'fileLabel' => true,
								'postAction' => true, 'postActionVisible' => true
							]) ?>
						</div>
						<div class="row">
							<div class="spinner"></div>
							<div class="message"></div>
							<div class="align align-center">
								<input class="element-medium" type="submit" value="Create">
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
		<div class="filler-height filler-height-medium"></div>
		<div class="box box-crud">
			<div class="box-header">
				<div class="box-header-title">All Slide</div>
			</div>
			<div class="box-content-wrap">
				<div class="box-content">
					<ul class="slider-slides clearfix">
						<?php
							foreach ( $slides as $slide ) {

								$slideId	= $slide->id;
								$slideImage	= $slide->image;
						?>
							<li>
								<form class="frm-split frm-slide fxs-form" cmt-app="main" cmt-controller="gallery" cmt-action="updateItem" action="foxslider/slide/update?id=<?= $slideId ?>">
									<div class="row">
										<div class="col col2">
											<label>Title</label>
											<input type="text" name="Slide[name]" placeholder="Title" value="<?= $slide->name ?>">
											<div class="clear"><span class="error" cmt-error="name"></span></div>
										</div>
										<div class="col col2">
											<label>Slide Url</label>
											<input type="text" name="Slide[url]" placeholder="Url" value="<?= $slide->url?>">
											<div class="clear"><span class="error" cmt-error="url"></span></div>
											<input type="hidden" name="Slide[sliderId]" value="<?=$slider->id?>" />
										</div>
									</div>
									<div class="row">
										<div class="col col2">
											<label>Description</label>
											<textarea name="Slide[description]" placeholder="Description" > <?= $slide->description?></textarea>
											<div class="clear"><span class="error" cmt-error="description"></span></div>
										</div>
										<div class="col col2">
											<label>Slide Content</label>
											<textarea class="editor-slide content-editor" name="Slide[content]" placeholder="Content" > <?= $slide->content?></textarea>
											<div class="clear"><span class="error" cmt-error="content"></span></div>
										</div>
									</div>
									<div class="filler-height"></div>
									<div class="box box-crud">
										<div class="box-header">
											<div class="box-header-title">Image</div>
										</div>
										<div class="box-content-wrap frm-split-40-60">
											<div class="box-content">
												<div class="row row-inline">
													<?= ImageUploader::widget([
														'directory' => 'gallery', 'showFields' => true, 'model' => $slideImage,
														'modelClass' => 'File', 'fileLabel' => true,
														'info' => true,
														'postAction' => true, 'postActionVisible' => true
													]) ?>
												</div>
											</div>
										</div>
									</div>
									<div class="filler-height"></div>
									<div class="row">
										<div class="spinner"></div>
										<div class="message"></div>
										<div class="align align-center">
											<input class="element-medium" type="submit" value="Update">
										</div>
									</div>
								</form>
								<div class="filler-height"></div>
								<form cmt-app="main" cmt-controller="gallery" cmt-action="deleteItem" action="foxslider/slide/delete?id=<?= $slideId ?>&pid=<?= $slider->id ?>">
									<div class="max-area-cover spinner">
										<div class="valign-center cmti cmti-spinner-1 spin"></div>
									</div>
									<div class="frm-actions align align-center">
										<input class="element-medium" type="submit" value="Delete" />
									</div>
								</form>
								<div class="filler-height"></div>
							</li>
						<?php } ?>
					</ul>
				</div>
			</div>
		</div>
		<div class="filler-height filler-height-medium"></div>
	</div>
	<div class="box-crud-wrap-sidebar colf colf3">

	</div>
</div>
