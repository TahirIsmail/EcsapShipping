<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error">
    <h2>We ran into problem</h2>
    <p>We are sorry this occured. As we are early in the development of our new system please take a screenshot of this whole page along with the adress bar and comunicate it to AFG Global Support team.<p>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p>
         <strong><?= Html::encode($this->title) ?></strong>
    </p>

</div>
