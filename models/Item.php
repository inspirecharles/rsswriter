<?php
/**
 * @link https://github.com/inspirecharles/rsswriter
 */

namespace inspirecharles\rss\models;

use yii\base\Model;

class Item extends Model
{
    public $title;
    public $description;
    public $link;
    public $content = '';
    public $author = '';
    public $pubDate = '';

    public function rules()
    {
        return [
            [['title', 'description', 'link'], 'required'],
            [['description', 'content'], 'string'],
            [['title', 'link', 'author'], 'string', 'max' => 255],
            [['pubDate'], 'integer'],
        ];
    }
}
