<?php


namespace BABA\Cache;


class CacheDriver
{
    /** @var array */
    protected $config;

    /**
     * @param $params
     */
    protected function prepareConfig($params)
    {
        foreach ($this->DEFAULTS as $key => $value) {
            if (isset($params[$key])) {
                $this->config[$key] = $value;
            } else {
                $this->config[$key] = $this->DEFAULTS[$key];
            }
        }
    }
}