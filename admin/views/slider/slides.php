<?php
$coreProperties = $this->context->getCoreProperties();
$themeTemplates	= Yii::getAlias( '@themes/admin/views/templates' );
$this->title 	= 'FoxSlider Slides | ' . $coreProperties->getSiteTitle();
$apixBase		= $this->context->apixBase;
$returnUrl		= $this->context->returnUrl;

include "$themeTemplates/components/crud/foxslider/card.php";
