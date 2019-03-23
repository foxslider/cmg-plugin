<?php
$slideImage = $slide->image;

$slideName		= $slide->name;
$slideTitle		= $slide->name;
$slideUrl		= $slide->url;
$slideDesc		= $slide->description;
$slideContent	= $slide->content;

$slideTexture	= isset( $widget->slideTexture ) ? "<div class=\"$widget->slideTexture\"></div>" : null;
$content		= "<div class=\"wrap-slide-content\">";

if( isset( $slideImage ) ) {

	$slideImageUrl	= $slideImage->getFileUrl();

	$imageTitle		= $slideImage->title;
	$imageCaption	= $slideImage->caption;
	$imageAlt		= $slideImage->altText;
	$imageDesc		= $slideImage->description;

	if( isset( $fxOptions[ 'lazyLoad' ] ) && isset( $fxOptions[ 'lazyLoadImage' ] ) ) {

		$lazyImg	= $fxOptions[ 'lazyLoadImage' ];
		$slideImg	= $first ? $slideImageUrl : $lazyImg;
		$content	= "<div class=\"fxs-lazy fxs-lazy-bkg wrap-slide-content\" style=\"background-image:url($slideImg)\" data-src=\"$slideImageUrl\" data-lazy=\"0\">";
	}
	else {

		$content = "<div class=\"wrap-slide-content\" style=\"background-image:url($slideImageUrl)\">";
	}

	if( isset( $fxOptions[ 'resizeBkgImage' ] ) && isset( $fxOptions[ 'bkgImageClass' ] ) ) {

		if( isset( $fxOptions[ 'lazyLoad' ] ) && isset( $fxOptions[ 'lazyLoadImage' ] ) ) {

			$imgClass	= $fxOptions[ 'bkgImageClass' ];
			$lazyImg	= $fxOptions[ 'lazyLoadImage' ];
			$slideImg	= $first ? $slideImageUrl : $lazyImg;
			$content	= "<img src=\"$slideImg\" class=\"fxs-lazy fxs-lazy-img $imgClass\" alt=\"$imageAlt\" data-src=\"$slideImageUrl\" data-lazy=\"0\" />
						   <div class=\"wrap-slide-content\">";
		}
		else {

			$imgClass	= $fxOptions[ 'bkgImageClass' ];
			$content	= "<img src=\"$slideImageUrl\" class=\"$imgClass\" alt=\"$imageAlt\" />
						   <div class=\"wrap-slide-content\">";
		}
	}
}
?>
<?php if( isset( $slideUrl ) && strlen( $slideUrl ) > 0 ) { ?>
	<div>
		<a href="<?= $slideUrl ?>">
			<?= $content ?>
				<?= $slideTexture ?>
				<div class="slide-content">
					<div class="fxs-header">
						<h2><?= $slideTitle ?></h2>
						<p><?= $slideDesc ?></p>
					</div>
					<div class="fxs-content">
						<?= $slideContent ?>
					</div>
				</div>
			</div>
		</a>
	</div>
<?php } else { ?>
	<div>
		<?= $content ?>
			<?= $slideTexture ?>
			<div class="slide-content">
				<div class="fxs-header">
					<h2><?= $slideTitle ?></h2>
					<p><?= $slideDesc ?></p>
				</div>
				<div class="fxs-content">
					<?= $slideContent ?>
				</div>
			</div>
		</div>
	</div>
<?php } ?>
