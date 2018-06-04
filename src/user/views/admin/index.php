<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\grid\GridView;
use yii\bootstrap4\Html;
use yii\helpers\Url;
use yii\web\View;


/**
 * @var \yii\web\View $this
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \dektrium\user\models\UserSearch $searchModel
 */

$this->title = Yii::t('user', 'Manage users');
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('/_alert', ['module' => Yii::$app->getModule('user')]) ?>

<?= $this->render('/admin/_menu') ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'layout'       => "{items}\n{pager}",
    'columns' => [
        [
        	'label' => Yii::t('user', 'Id'),
            'attribute' => 'id',
            'headerOptions' => ['style' => 'width:90px;'], # 90px is sufficient for 5-digit user ids
        ],
        [
            'label' => Yii::t('user', 'User Name'),
            'attribute' => 'username',
        ],
        [
            'label' => Yii::t('user', 'Email'),
            'attribute' => 'email',
        ],        
        [
            'label' => Yii::t('user', 'Register IP'),
            'attribute' => 'registration_ip',
            'value' => function ($model) {
                return $model->registration_ip == null
                    ?  Html::tag('span', Yii::t('user', '(not set)'), ['class' => 'not-set']) 
                    : $model->registration_ip;
            },
            'format' => 'html',
        ],
        [
            'label' => Yii::t('user', 'Register Time'),
            'attribute' => 'created_at',
            'value' => function ($model) {
                if (extension_loaded('intl')) {
                    return Yii::t('user', '{0, date, dd/MM/YYYY HH:mm}', [$model->created_at]);
                    } else {
                    return date('Y-m-d G:i:s', $model->created_at);
                }
            },
        ],
        [
            'label' => Yii::t('user', 'Last Login'),      
            'attribute' => 'last_login_at',
            'value' => function ($model) {
                if (!$model->last_login_at || $model->last_login_at == 0) {
                    return Yii::t('user', 'Never');
                    } else if (extension_loaded('intl')) {
                        return Yii::t('user', '{0, date, dd/MM/YYYY HH:mm}', [$model->last_login_at]);
                        } else {
                            return date('Y-m-d G:i:s', $model->last_login_at);
                }
            },
        ],
        [
            'header' => Yii::t('user', 'Confirmation'),
            'value' => function ($model) {
                if ($model->isConfirmed) {
                    return  Html::beginTag('div', ['class' => 'text-center']) .
                        Html::tag('span', Yii::t('user', 'Confirmed'), ['class' => 'text-success']) .
                    Html::endTag('div');                    
                    } else {
                        return Html::a(Yii::t('user', 'Confirm'), ['confirm', 'id' => $model->id], [
                            'class' => 'btn btn-sm btn-success btn-block',
                            'data-method' => 'post',
                            'data-confirm' => Yii::t('user', 'Are you sure you want to confirm this user?'),
                        ]);
                }
            },
            'format' => 'raw',
            'visible' => Yii::$app->getModule('user')->enableConfirmation,
        ],
        [
            'header' => Yii::t('user', 'Block <br/>Status'),
        	'headerOptions' => ['style' => 'text-align:center;'],
            'value' => function ($model) {
                if ($model->isBlocked) {
                    return Html::a(Yii::t('user', 'Unblock'), ['block', 'id' => $model->id], [
                        'class' => 'btn btn-sm btn-success btn-block',
                        'data-method' => 'post',
                        'data-confirm' => Yii::t('user', 'Are you sure you want to unblock this user?'),
                    ]);
                    } else {
                        return Html::a(Yii::t('user', 'Block'), ['block', 'id' => $model->id], [
                            'class' => 'btn btn-sm btn-danger btn-block',
                            'data-method' => 'post',
                            'data-confirm' => Yii::t('user', 'Are you sure you want to block this user?'),
                        ]);
                }
            },
            'format' => 'raw',
        ],
        [
            'header' => Yii::t('user', 'Actions'),
            '__class' => yii\grid\ActionColumn::class,
            'template' => '{switch} {resend_password} {update} {delete}',
            'buttons' => [
                'switch' => function ($url, $model) {
                    if(\Yii::$app->user->identity->isAdmin && $model->id != Yii::$app->user->id && Yii::$app->getModule('user')->enableImpersonateUser) {
                        return Html::beginTag('a', [
                            'data-method'=> 'POST', 
                            'data-confirm' => Yii::t('user', 'Are you sure you want to switch to this user for the rest of this Session?'), 
                            'title' => Yii::t('user', 'Become this user'), 
                            'href' => ' '. Url::to(['/user/admin/switch', 'id' => $model->id]) . ' ']) .
                            Html::tag('span', '', ['class' => 'fas fa-user']) .                        
                        Html::endTag('a');
                    }
                },
            	'resend_password' => function ($url, $model, $key) {
                	if (\Yii::$app->user->identity->isAdmin && !$model->isAdmin) {
                        return Html::beginTag('a', [
                            'data-method'=> 'POST', 
                            'data-confirm' => ' ' . Yii::t('user', 'Are you sure?') . ' ',
                            'href' => ' ' . Url::to(['resend-password', 'id' => $model->id]) . ' ']) .
                            Html::tag('span', '', [
                                'title' => ' '. Yii::t('user', 'Generate and send new password to user') . ' ', 
                                'class' => 'fas fa-envelope']) .
                        Html::endTag('a');
                	}	
            	}, 
            	'update' => function ($url, $model) {
                	return Html::a(Html::tag('span', '', ['class' => 'fas fa-edit']), 
                        $url, ['title' => Yii::t('user', 'Update')]
                    );
            	},
            	'delete' => function ($url, $model) {
                	return Html::a(Html::tag('span', '', ['class' => 'fas fa-trash']), 
                        $url, ['title' => Yii::t('user', 'Delete')]
                    );
            	}            
            ]                      
        ],
    ],
]); ?>