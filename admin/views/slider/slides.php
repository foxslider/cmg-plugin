<?php

use yii\web\View;
// CMG Imports
use cmsgears\files\widgets\ImageUploader;
use cmsgears\core\common\utilities\CodeGenUtil;
$coreProperties = $this->context->getCoreProperties();
$this->title	= 'Slider Slide | ' . $coreProperties->getSiteTitle();
?>
<div class="box-crud-wrap row">
	<div class="box-crud-wrap-main colf colf3x2">
		<div class="box box-crud">
			<div class="box-header">
				<div class="box-header-title"> Slider Slides </div>
			</div>
			<div class="box-content-wrap frm-split-40-60">
				<div class="box-content">
					<div class="row">
						<div class="col col2">
							<label>Name</label>
							<input type="text" name="slidername" value="<?=$slider->name?>" disabled="" >
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="filler-height filler-height-medium"></div>
		
		<form class="frm-split frm-slide fxs-form" id="frm-slide-create" cmt-app="foxslider" cmt-controller="slider" cmt-action="updateSlide" action="foxslider/slide/create">
			<div class="box box-crud">
				<div class="box-header">
					<div class="box-header-title"> Slide info </div>
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
								<label >Slide Content</label>
								<textarea class="editor-slide content-editor" name="Slide[content]" placeholder="Content"></textarea>
								<div class="clear"><span class="error" cmt-error="content"></span></div>
							</div>
							<div class="col col2">
								<label>Description</label>
								<textarea name="Slide[description]" placeholder="Description"></textarea>
								<div class="clear"><span class="error" cmt-error="description"></span></div>
							</div>	
						</div>
					</div>
				</div>
			</div>

			<div class="filler-height filler-height-medium"></div>

			<div class="box box-crud">
				<div class="box-header">
					<div class="box-header-title"> Image </div>
				</div>
				<div class="box-content-wrap frm-split-40-60">
					<div class="box-content">
						<div class="row row-inline">
							<div class="col1">
								<?= ImageUploader::widget(['model' => $slideImage,

									'directory' => 'gallery', 'info' => true, 'infoFields' => []
										
										, 'showFields' => true,  'modelClass' => 'File', 'fileLabel' => true,
								'postAction' => true, 'postActionVisible' => true, 
								
									]); ?>
							</div>	
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
					<div class="box-header-title"> All Slide </div>
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
						<form class="frm-split frm-slide fxs-form" id="frm-slide-create" cmt-app="foxslider" cmt-controller="slider" cmt-action="updateSlide" action="foxslider/slide/update?id=<?=$slideId?>">
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
									<label>Slide Content</label>
									<textarea class="editor-slide content-editor" name="Slide[content]" placeholder="Content" > <?= $slide->content?></textarea>
									<div class="clear"><span class="error" cmt-error="content"></span></div>
								</div>
								<div class="col col2">
									<label>Description</label>
									<textarea name="Slide[description]" placeholder="Description" > <?= $slide->description?></textarea>
									<div class="clear"><span class="error" cmt-error="description"></span></div>
								</div>	
							</div>
							<div class="row">
								<div class="col1 ">
									<?= ImageUploader::widget(['model' => $slideImage,

									'directory' => 'gallery', 'info' => true, 'infoFields' => []
										
										, 'showFields' => true,  'modelClass' => 'File', 'fileLabel' => true,
								'postAction' => true, 'postActionVisible' => true, 
								
									]); ?>
								</div>	
							</div>
							<div class="row">
								<div class="spinner"></div>
								<div class="message"></div>
								<div class="align align-center">
									<input class="element-medium" type="submit" value="Update">
								</div>
							</div>
						</form>	
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
<?= CodeGenUtil::registerJsFromFile( $this, View::POS_END, dirname( __DIR__ ) . "/scripts/main.js" ); ?>

