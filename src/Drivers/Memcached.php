<?php


namespace BABA\Cache\Drivers;


use BABA\Cache\ICacheDriver;

class Memcached extends CacheDriver implements ICacheDriver
{
    private $connection;

    protected $DEFAULTS = [
        'host' => '127.0.0.1',
        'port' => 11211,
        'sock' => ''
    ];

    /**
     * Disk constructor.
     * @param $params
     */
    public function __construct($params = [])
    {
        if (!class_exists('Memcached')) {
            throw new Exception('Extension php-memcached is not supported')
        }

        $this->prepareConfig($params);
        $this->connection = new \Memcached();

        if(!empty($this->config['sock'])) {
            $this->connection->addServer('unix://'.$this->config['sock'],0);
        } else {
            $this->connection->addServer($this->config['host'], $this->config['port']);
        }
    }


    /**
     * @param $key
     * @param $object
     * @return bool
     */
    public function store($key, $object): bool {
       return $this->connection->set($key,json_encode($object));
    }

    /**
     * @param $key
     * @return object|null
     */
    public function load($key): ?object
    {
        $f = $this->connection->get($key);
        return $f ? json_decode($f) : $f;
    }
}