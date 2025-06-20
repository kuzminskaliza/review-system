<?php

namespace api\controllers;

use api\models\Review;
use api\models\search\ReviewSearch;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\Cors;
use yii\rest\ActiveController;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use Exception;
use Yii;

class ReviewController extends ActiveController
{
    public $modelClass = Review::class;

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
        'metaEnvelope' => 'meta',
        'linksEnvelope' => 'links',
    ];

    public function actions(): array
    {
        return [
            'options' => [
                'class' => 'yii\rest\OptionsAction',
            ],
        ];
    }

    /**
     * @return array
     */
    public function behaviors(): array
    {
        $behaviors['corsFilter'] = [
            'class' => Cors::class,
            'cors' => [
                'Origin' => Yii::$app->params['origin_url'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Allow-Credentials' => false,
                'Access-Control-Max-Age' => 3600,
            ],
        ];

        $behaviors['access'] = [
            'class' => AccessControl::class,
            'only' => ['update'],
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['update'],
                    'matchCallback' => function () {
                        $token = Yii::$app->request->getHeaders()->get('Authentication');
                        return $token == Yii::$app->params['access-token'];
                    }
                ],
            ],
            'denyCallback' => function () {
                throw new ForbiddenHttpException('У вас немає доступу.');
            },
        ];

        return $behaviors;
    }

    public function actionCreate()
    {
        $model = Yii::createObject(Review::class);

        if (!$model->load(Yii::$app->request->post(), '')) {
            throw new Exception('щось тут не то');
        }

        if (!$model->save()) {
            return $model;
        }

        return $model;

    }

    public function actionIndex(): ActiveDataProvider
    {
        $modelSearch = Yii::createObject(ReviewSearch::class);
        return $modelSearch->search(Yii::$app->request->get());
    }

    public function actionUpdate(int $id)
    {
        $model = Review::findOne($id);

        if (!$model) {
            throw new NotFoundHttpException('Review not found');
        }

        if (!$model->load(Yii::$app->request->post(), '')) {
            throw new Exception('щось тут не то');
        }

        if ($model->save()) {
            return $model;
        }
        return $model;
    }
}