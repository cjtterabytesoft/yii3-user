<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Nav;
use yii\bootstrap4\Html;

/**
 * @var yii\web\View $this
 * @var dektrium\user\models\User $user
 */

$this->title = Yii::t('user', 'Create a user account');
$this->params['breadcrumbs'][] = ['label' => Yii::t('user', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('/_alert', ['module' => Yii::$app->getModule('user'),]) ?>

<?= $this->render('_menu') ?>

<?= Html::beginTag('div', ['class' => 'row']) ?>
	<?= Html::beginTag('div', ['class' => 'col-md-3']) ?>
		<?= Html::beginTag('div', ['class' => 'panel panel-default']) ?>
			<?= Html::beginTag('div', ['class' => 'panel-body']) ?>
				<?= Nav::widget([
					'options' => [
						'class' => 'nav-pills nav-stacked',
					],
					'items' => [
						['label' => Yii::t('user', 'Account details'), 'url' => ['/user/admin/create']],
						['label' => Yii::t('user', 'Profile details'), 'options' => [
							'class' => 'disabled',
							'onclick' => 'return false;',
						]],
						['label' => Yii::t('user', 'Information'), 'options' => [
							'class' => 'disabled',
							'onclick' => 'return false;',
						]],
					],
				]) ?>
			<?= Html::endTag('div') ?>
		<?= Html::endTag('div') ?>
	<?= Html::endTag('div') ?>
	<?= Html::beginTag('div', ['class' => 'col-md-9']) ?>
		<?= Html::beginTag('div', ['class' => 'panel panel-default']) ?>
			<?= Html::beginTag('div', ['class' => 'panel-body']) ?>
				<?= Html::beginTag('div', ['class' => 'alert alert-info']) ?>
					<?= Yii::t('user', 'Credentials will be sent to the user by email') ?>.
					<?= Yii::t('user', 'A password will be generated automatically if not provided') ?>.
				<?= Html::endTag('div') ?>

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

					<?= $this->render('_user', ['form' => $form, 'user' => $user]) ?>

					<?= Html::beginTag('div', ['class' => 'form-group']) ?>
						<?= Html::beginTag('div', ['class' => 'col-lg-2 offset-lg-2 col-lg-9']) ?>
							<?= Html::submitButton(Yii::t('user', 'Save'), ['class' => 'btn btn-block btn-success']) ?>
						<?= Html::endTag('div') ?>
					<?= Html::endTag('div') ?>

				<?php ActiveForm::end(); ?>
			<?= Html::endTag('div') ?>
		<?= Html::endTag('div') ?>
	<?= Html::endTag('div') ?>
<?= Html::endTag('div') ?>