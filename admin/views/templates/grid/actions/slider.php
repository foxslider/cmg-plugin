<?php
// Yii Imports
use yii\helpers\Html;
?>

<span title="Slides"><?= Html::a( "", [ "slides?id=$model->id" ], [ 'class' => 'cmti cmti-list-small' ] )  ?></span>
<span title="Update"><?= Html::a( "", [ "update?id=$model->id" ], [ 'class' => 'cmti cmti-edit' ] )  ?></span>
<span title="Delete"><?= Html::a( "", [ "delete?id=$model->id" ], [ 'class' => 'cmti cmti-close-c-o' ] )  ?></span>