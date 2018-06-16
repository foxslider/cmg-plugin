<?php
// Yii Imports
use yii\helpers\Html;
?>
<span title="Slides"><?= Html::a( "", [ "slides?id=$model->id" ], [ 'class' => 'cmti cmti-list-small' ] )  ?></span>
<span title="Update"><?= Html::a( "", [ "update?id=$model->id" ], [ 'class' => 'cmti cmti-edit' ] )  ?></span>
<span title="Settings"><?= Html::a( "", [ "settings?id=$model->id" ], [ 'class' => 'cmti cmti-setting' ] )  ?></span>

<span class="action action-pop action-delete cmti cmti-close-c" title="Delete" target="<?= $model->id ?>" popup="popup-grid-delete"></span>
