<?php
$slideImage		= $slide->image;
$slideTitle		= $slide->name;
$slideDesc		= $slide->description;
$slideContent	= $slide->content;
$slideUrl		= $slide->url;
$slideImageUrl	= '';
$slideImageAlt	= '';
$bkgImage		= "<div class='slide-content'>";

if( isset( $slideImage ) ) {

	$slideImageUrl	= $slideImage->getFileUrl();
	$slideImageAlt	= $slideImage->altText;
	$bkgImage		= "<div class='slide-content' style='background-image:url($slideImageUrl)'>";

	if( isset( $this->fxOptions[ 'resizeBkgImage' ] ) && isset( $this->fxOptions[ 'bkgImageClass' ] ) && $this->fxOptions[ 'resizeBkgImage' ] ) {

		$imgClass	= $this->fxOptions[ 'bkgImageClass' ];
		$bkgImage	= "<img src='$slideImageUrl' class='$imgClass' alt='$slideImageAlt' />
						<div class='slide-content'>";
	}
}

if( isset( $slideUrl ) && strlen( $slideUrl ) > 0 ) {

	$slideHtml	= "<div>
						<a href='$slideUrl'>
							$bkgImage
								$this->slideTexture
								<div class='info'>
									<h2>$slideTitle</h2>
									<p>$slideDesc</p>
								</div>
								<div class='content'>
									$slideContent
								</div>
							</div>
						</a>
					</div>";
}
else {

	$slideHtml	= "<div>
						$bkgImage
							$this->slideTexture
							<div class='info'>
								<h2>$slideTitle</h2>
								<p>$slideDesc</p>
							</div>
							<div class='content'>
								$slideContent
							</div>
						</div>
					</div>";
}

echo $slideHtml;
?>