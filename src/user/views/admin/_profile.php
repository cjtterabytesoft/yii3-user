<?php

/*
 * This file is part of the Dektrium project
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

/**
 * @var yii\web\View $this
 * @var dektrium\user\models\User $user
 * @var dektrium\user\models\Profile $profile
 */
?>

<?php $this->beginContent('@dektrium/user/views/admin/update.php', ['user' => $user]) ?>

	<?php $form = ActiveForm::begin([
		'layout' => 'horizontal',
		'enableAjaxValidation' => true,
		'enableClientValidation' => false,
		'fieldConfig' => [
			'horizontalCssClasses' => [
				'wrapper' => 'col-sm-9',
			],
		],
	]); ?>

		<?= $form->field($profile, 'name') ?>
		<?= $form->field($profile, 'public_email') ?>
		<?= $form->field($profile, 'website') ?>
		<?= $form->field($profile, 'location') ?>
		<?= $form->field($profile, 'gravatar_email') ?>
		<?= $form->field($profile, 'bio')->textarea() ?>

		<?= Html::beginTag('div', ['class' => 'form-group']) ?>
			<?= Html::beginTag('div', ['class' => 'col-lg-2 offset-lg-2 col-lg-9']) ?>
				<?= Html::submitButton(Yii::t('user', 'Update'), ['class' => 'btn btn-block btn-success']) ?>
			<?= Html::endTag('div') ?>		
		<?= Html::endTag('div') ?>

	<?php ActiveForm::end(); ?>

<?php $this->endContent() ?>