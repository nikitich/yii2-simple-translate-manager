<?php
namespace common\components;

use nikitich\simpletranslatemanager\Defaults;
use yii\base\InvalidConfigException;
use yii\caching\Cache;
use yii\db\Connection;
use yii\db\Query;
use yii\di\Instance;
use yii\helpers\ArrayHelper;
use yii\i18n\MessageSource;

/**
 * DbMessageSource extends [[MessageSource]] and represents a message source that stores translated
 * messages in database.
 *
 * The database must contain the following table:
 *
 * ~~~
 * CREATE TABLE message (
 *     alias CHAR(64) NOT NULL,
 *     language CHAR(5) NOT NULL,
 *     translation TEXT NOT NULL,
 *     date_created DATETIME NOT NULL,
 *     date_updated DATETIME NOT NULL
 *     PRIMARY KEY (`language`, `alias`),
 * );
 * ~~~
 *
 * @author nikitich <nickotin.zp.ua@gmail.com>
 */
class DbMessageSource extends MessageSource
{
    /**
     * Prefix which would be used when generating cache key.
     * @deprecated This constant has never been used and will be removed in 2.1.0.
     */
    const CACHE_KEY_PREFIX = 'DbMessageSource';
    /**
     * @var Connection|array|string the DB connection object or the application component ID of the DB connection.
     *
     * After the DbMessageSource object is created, if you want to change this property, you should only assign
     * it with a DB connection object.
     *
     * Starting from version 2.0.2, this can also be a configuration array for creating the object.
     */
    public $db = 'db';
    /**
     * @var Cache|array|string the cache object or the application component ID of the cache object.
     * The messages data will be cached using this cache object.
     * Note, that to enable caching you have to set [[enableCaching]] to `true`, otherwise setting this property has no effect.
     *
     * After the DbMessageSource object is created, if you want to change this property, you should only assign
     * it with a cache object.
     *
     * Starting from version 2.0.2, this can also be a configuration array for creating the object.
     * @see cachingDuration
     * @see enableCaching
     */
    public $cache = Defaults::CACHE;
    /**
     * @var string the name of the translated message table.
     */
    public $messageTable = Defaults::TRANSLATIONS_TABLE;
    /**
     * @var integer the time in seconds that the messages can remain valid in cache.
     * Use 0 to indicate that the cached data will never expire.
     * @see enableCaching
     */
    public $cachingDuration = 0;
    /**
     * @var boolean whether to enable caching translated messages
     */
    public $enableCaching = false;

    /**
     * Initializes the DbMessageSource component.
     * This method will initialize the [[db]] property to make sure it refers to a valid DB connection.
     * Configured [[cache]] component would also be initialized.
     * @throws InvalidConfigException if [[db]] is invalid or [[cache]] is invalid.
     */
    public function init()
    {
        parent::init();
        $this->db = Instance::ensure($this->db, Connection::class);
        if ($this->enableCaching) {
            $this->cache = Instance::ensure($this->cache, Cache::class);
        }
    }

    /**
     * Loads the message translation for the specified language and category.
     * If translation for specific locale code such as `en-US` isn't found it
     * tries more generic `en`.
     *
     * @param string $category the message category
     * @param string $language the target language
     *
     * @return array the loaded messages. The keys are original messages, and the values
     * are translated messages.
     * @throws \yii\db\Exception
     */
    protected function loadMessages($category, $language)
    {
        if ($this->enableCaching) {
            $key      = [
                __CLASS__,
                $language,
                $category,
            ];
            $messages = $this->cache->get($key);
            if ($messages === false) {
                $messages = $this->loadMessagesFromDb($category, $language);
                $this->cache->set($key, $messages, $this->cachingDuration);
            }

            return $messages;
        } else {
            return $this->loadMessagesFromDb($category, $language);
        }
    }

    /**
     * Loads the messages from database for specified category and language.
     *
     * @param string $category the target category.
     * @param string $language the target language.
     *
     * @return array the messages loaded from database.
     * @throws \yii\db\Exception
     */
    protected function loadMessagesFromDb($category, $language)
    {
        $mainQuery = new Query();
        $mainQuery->select(['alias', 'translation'])
            ->from(["$this->messageTable"])
            ->where([
                'category' => $category,
                'language' => $language,
            ])
        ;

        $messages = $mainQuery->createCommand($this->db)->queryAll();

        return ArrayHelper::map($messages, 'alias', 'translation');
    }
}
