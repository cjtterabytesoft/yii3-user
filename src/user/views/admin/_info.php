<?php

/*
 * This file is part of the Dektrium project
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\bootstrap4\Html;

/**
 * @var yii\web\View $this
 * @var dektrium\user\models\User $user
 */
?>

<?php $this->beginContent('@dektrium/user/views/admin/update.php', ['user' => $user]) ?>

	<?= Html::beginTag('table', ['class' => 'table']) ?>
		<?= Html::beginTag('tr') ?>
			<?= Html::tag('td', '<strong>' . Yii::t('user', 'Register Time') . '</strong>') ?>
			<?= Html::tag('td', Yii::t('user', '{0, date, dd/MM/YYYY HH:mm}', [$user->created_at])) ?>
		<?= Html::endTag('tr'); ?>
		<?php if ($user->registration_ip !== null): ?>
			<?= Html::beginTag('tr') ?>
				<?= Html::tag('td', '<strong>' . Yii::t('user', 'Register IP') . '</strong>') ?>
				<?= Html::tag('td', $user->registration_ip) ?>
			<?= Html::endTag('tr'); ?>
		<?php endif ?>
		<?= Html::beginTag('tr') ?>
			<?= Html::tag('td', '<strong>' . Yii::t('user', 'Confirmation') . '</strong>') ?>
			<?php if ($user->isConfirmed): ?>
				<?= Html::tag('td', Yii::t('user', 'Confirmed at {0, date, dd/MM/YYYY HH:mm}', [$user->confirmed_at]),
				['class' => 'text-success' ]) ?>
			<?php else: ?>
				<?= Html::tag('td', Yii::t('user', 'Unconfirmed'), ['class' => 'text-danger']) ?>
			<?php endif ?>
		<?= Html::endTag('tr'); ?>
		<?= Html::beginTag('tr') ?>
			<?= Html::tag('td', '<strong>' . Yii::t('user', 'Block Status') . '</strong>') ?>
			<?php if ($user->isBlocked): ?>
				<?= Html::beginTag('td', ['class' => 'text-danger']) ?>
					<?= Yii::t('user', 'Blocked at {0, date, dd/MM/YYYY HH:mm}', [$user->blocked_at]) ?>
				<?= Html::endTag('td'); ?>
			<?php else: ?>
				<?= Html::tag('td', Yii::t('user', 'Not Blocked'), ['class' => 'text-success']) ?>
			<?php endif ?>
		<?= Html::endTag('tr'); ?>
	<?= Html::endTag('table'); ?>

<?php $this->endContent() ?>