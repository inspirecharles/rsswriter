RSS Generator Module for Yii2
========================
Yii2 module for automatically generation RSS 2.0 feeds.

Main features:
* automatic caching of rss feeds
* unlimited number of rss feeds
* flexible module configuration

Installation
------------
The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

* Either run

```
php composer.phar require --prefer-dist "inspirecharles/rsswriter" "*"
```
or add

```json
"inspirecharles/rsswriter" : "*"
```

to the require section of your application's `composer.json` file.

* Apply all available migrations in `migrations` folder:

```shell
$ php yii migrate/up --migrationPath=@vendor/inspirecharles/rsswriter/migrations
```

* Configure the `cache` component of your application's configuration file, for example:

```php
'components' => [
    'cache' => [
        'class' => 'yii\caching\FileCache',
    ],
]
```

* Add a new module in `modules` section of your application's configuration file, for example:

```php
'modules' => [
    'rss' => [
        'class' => 'inspirecharles\rss\Rss',
        'feeds' => [
            'rss' => [
                'title' => 'Feed title',
                'description' => 'feed description',
                'link' => 'http://your.site.com/',
                'language' => 'en-US'
            ],
        ]
    ],
],
```

* Add a new rule for `urlManager` of your application's configuration file, for example:

```php
'urlManager' => [
    'rules' => [
        ['pattern' => '<id:rss>', 'route' => 'rss/default/index', 'suffix' => '.xml'],
    ],
],
```

* Add a new `<link>` tag to your `<head>` tag, for example:

```html
<link rel="alternate" type="application/rss+xml" title="RSS feed" href="/rss.xml" />
```

Usage
-----
For example:

```php
...
public function beforeSave($insert)
{
    if (parent::beforeSave($insert)) {
        if ($insert) {
            $rss = Yii::$app->getModule('rss');
            $rssItem = $rss->createNewItem();

            $rssItem->title = $this->title;
            $rssItem->description = $this->description;
            $rssItem->link = Url::to($this->url, true);
            $rssItem->pubDate = time();

            return $rss->addItemToFeed('rss', $rssItem);
        }
        return true;
    }
    return false;
}

public function afterDelete()
{
    parent::afterDelete();
    $rss = Yii::$app->getModule('rss');
    
    $rss->deleteItems('rss', ['link' => Url::to($this->url, true)]);
}
```
