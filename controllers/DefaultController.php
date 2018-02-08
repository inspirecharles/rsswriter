<?php
/**
 * @link https://github.com/inspirecharles/rsswriter
 */

namespace inspirecharles\rss\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use inspirecharles\rss\models\Feed;

class DefaultController extends Controller
{
    public function actionIndex($id = 0)
    {
        /** @var \inspirecharles\rss\Rss $module */
        $module = $this->module;
        if (empty($module->feeds[$id])) {
            throw new NotFoundHttpException("RSS feed not found.");
        }

        Yii::$app->response->format = Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', 'text/xml');
        if ($view = Yii::$app->cache->get("{$module->cacheKeyPrefix}-{$id}")) {
            echo $view;
            return;
        }

        $feedItems = Feed::find()
            ->select('title, description, link, content, author, pubDate')
            ->where(['feed_id' => $id])
            ->orderBy(['id' => SORT_DESC])
            ->asArray()
            ->all();

        echo $view = $this->renderPartial('index', [
            'channel' => $module->feeds[$id],
            'items' => $feedItems
        ]);
        Yii::$app->cache->set("{$module->cacheKeyPrefix}-{$id}", $view, $module->cacheExpire);
    }
}
