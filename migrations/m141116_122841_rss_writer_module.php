<?php
/**
 * @link https://github.com/inspirecharles/rsswriter
 */

use yii\db\Schema;
use yii\db\Migration;

class m141116_122841_rss_writer_module extends Migration
{
    const TABLE_NAME = '{{%rss_feed}}';

    public function up()
    {
        $this->createTable(self::TABLE_NAME, [
            'id' => 'pk',
            'feed_id' => Schema::TYPE_STRING . ' NOT NULL',
            'title' => Schema::TYPE_STRING . ' NOT NULL',
            'description' => Schema::TYPE_TEXT . ' NOT NULL',
            'link' => Schema::TYPE_STRING . ' NOT NULL',
            'content' => Schema::TYPE_TEXT . ' NOT NULL',
            'author' => Schema::TYPE_STRING . ' NOT NULL',
            'pubDate' => Schema::TYPE_STRING . ' NOT NULL'
        ]);
        $this->createIndex('feed_id', self::TABLE_NAME, 'feed_id');
    }

    public function down()
    {
        $this->dropTable(self::TABLE_NAME);
    }
}
