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

	$smallUrl	= $slideImage->getSmallUrl();
	$mediumUrl	= $slideImage->getMediumUrl();
	$imageUrl	= $slideImage->getFileUrl();

	$imageTitle		= $slideImage->title;
	$imageCaption	= $slideImage->caption;
	$imageAlt		= $slideImage->altText;
	$imageDesc		= $slideImage->description;

	$lazyImg = !empty( $widget->lazyImageUrl ) ? $widget->lazyImageUrl : ( $widget->lazySmall ? $slideImage->getSmallPlaceholderUrl() : $slideImage->getPlaceholderUrl() );

	if( isset( $widget->lazyLoad ) ) {

		$srcset = "$imageUrl, $mediumUrl, $smallUrl";
		$sizes	= "1025, 481";

		$content = "<div class=\"fxs-lazy fxs-lazy-bkg wrap-slide-content\" style=\"background-image:url($lazyImg)\" data-lazy=\"0\" data-src=\"$smallUrl\" data-srcset=\"$srcset\" data-sizes=\"$sizes\">";
	}
	else {

		$content = "<div class=\"wrap-slide-content\" style=\"background-image:url($imageUrl)\">";
	}

	if( $fxOptions[ 'resizeBkgImage' ] ) {

		$srcset = "$smallUrl 1x, $mediumUrl 1.5x, $imageUrl 2x";
		$sizes	= "(min-width: 1025px) 2x, (min-width: 481px) 1.5x, 1x";

		$imgClass = $fxOptions[ 'bkgImageClass' ];

		if( isset( $widget->lazyLoad ) ) {

			$content = "<img src=\"$lazyImg\" class=\"fxs-lazy fxs-lazy-img $imgClass\" alt=\"$imageAlt\" data-lazy=\"0\" data-src=\"$smallUrl\" data-srcset=\"$srcset\" data-sizes=\"$sizes\" />
						<div class=\"wrap-slide-content\">";
		}
		else {

			$content = "<img src=\"$smallUrl\" class=\"$imgClass\" alt=\"$imageAlt\" srcset=\"$srcset\" sizes=\"$sizes\" />
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
