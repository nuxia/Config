<?php

namespace Nuxia\Component\Config;

/**
 * ParameterBagInterface
 *
 * @author Yannick Snobbert <yannick.snobbert@gmail.com>
 */
interface ParameterBagInterface
{
    /**
     * Returns the parameters.
     *
     * @return array An array of parameters
     */
    public function all();

    /**
     * Returns the parameter keys.
     *
     * @return array An array of parameter keys
     */
    public function keys();

    /**
     * Adds parameters.
     *
     * @param array $parameters An array of parameters
     */
    public function add(array $parameters = array());

    /**
     * Returns a parameter by name.
     *
     * @param string $path    The key
     * @param mixed  $default The default value if the parameter key does not exist
     * @param bool   $deep    If true, a path like foo[bar] will find deeper items
     *
     * @return mixed
     *
     * @throws \InvalidArgumentException
     */
    public function get($path, $default = null, $deep = false);

    /**
     * Sets a parameter by name.
     *
     * @param string $key   The key
     * @param mixed  $value The value
     */
    public function set($key, $value);

    /**
     * Returns true if the parameter is defined.
     *
     * @param string $key The key
     *
     * @return bool true if the parameter exists, false otherwise
     */
    public function has($key);

    /**
     * Removes a parameter.
     *
     * @param string $key The key
     */
    public function remove($key);

    /**
     * Returns the number of parameters.
     *
     * @return int The number of parameters
     */
    public function count();

    /**
     * @param string $key
     * @param mixed $value
     */
    public function setIfNotSet($key, $value);

    /**
     * @param  array     $parameters
     * @param  bool|null $override
     *
     * @return mixed
     */
    public function addIfNotSet(array $parameters = array());

    /**
     * @param  array $keys
     * @return array
     */
    public function filterByKeys(array $keys);
}