<?php

namespace Nuxia\Component\Config;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface as SymfonyParameterBagInterface;

/**
 * ParameterBagInterface
 *
 * @author Yannick Snobbert <yannick.snobbert@gmail.com>
 */
interface ParameterBagInterface extends SymfonyParameterBagInterface
{
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