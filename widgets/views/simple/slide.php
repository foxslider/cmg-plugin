<?php
$slideImage		= $slide->image;
$slideTitle		= $slide->name;
$slideDesc		= $slide->description;
$slideContent	= $slide->content;
$slideUrl		= $slide->url;
$slideImageUrl	= '';
$slideImageAlt	= '';

if( isset( $slideImage ) ) {

	$slideImageUrl	= $slideImage->getFileUrl();
	$slideImageAlt	= $slideImage->altText;
	$content		= "<div class='wrap-slide-content' style='background-image:url($slideImageUrl)'>";

	if( isset( $fxOptions[ 'resizeBkgImage' ] ) && isset( $fxOptions[ 'bkgImageClass' ] ) && $fxOptions[ 'resizeBkgImage' ] ) {

		$imgClass	= $fxOptions[ 'bkgImageClass' ];
		$content	= "<img src='$slideImageUrl' class='$imgClass' alt='$slideImageAlt' />
					   <div class='wrap-slide-content'>";
	}
}

if( isset( $slideUrl ) && strlen( $slideUrl ) > 0 ) {

	$slideHtml	= "<div>
						<a href='$slideUrl'>
							$content
								$slideTexture
								<div class='slide-content'>
									<div class='header'>
										<h2>$slideTitle</h2>
										<p>$slideDesc</p>
									</div>
									<div class='content'>
										$slideContent
									</div>
								</div>
							</div>
						</a>
					</div>";
}
else {

	$slideHtml	= "<div>
						$content
							$slideTexture
							<div class='slide-content'>
								<div class='header'>
									<h2>$slideTitle</h2>
									<p>$slideDesc</p>
								</div>
								<div class='content'>
									$slideContent
								</div>
							</div>
						</div>
					</div>";
}

echo $slideHtml;
?>