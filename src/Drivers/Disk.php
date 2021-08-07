<?php


namespace BABA\Cache\Drivers;


use BABA\Cache\CacheDriver;
use BABA\Cache\ICacheDriver;

class Disk extends CacheDriver implements ICacheDriver
{
    /** @var array */
    protected $DEFAULTS = [
        'folder' => __DIR__ . '/../../cache'
    ];

    /**
     * Disk constructor.
     * @param $params
     */
    public function __construct($params = [])
    {
        $this->prepareConfig($params);

        if (!is_dir($this->config['folder'])) {
            mkdir($this->config['folder'], 0700, true);
        }
    }


    /**
     * @param $key
     * @param $object
     * @return bool
     */
    public function store($key, $object): bool
    {
        return file_put_contents($this->config['folder'] . DIRECTORY_SEPARATOR . md5($key) . '.json', json_encode($object));
    }

    /**
     * @param $key
     * @return object|null
     */
    public function load($key): ?object
    {
        $f = file_get_contents($this->config['folder'] . DIRECTORY_SEPARATOR . md5($key) . '.json');
        return $f ? json_decode($f) : NULL;
    }
}