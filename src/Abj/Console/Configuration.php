<?php
/**
 * Created by PhpStorm.
 * User: jackisback
 * Date: 14/11/15
 * Time: 22.32
 */

namespace Abj\Console;

use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Parser;

/**
 * Class Configuration
 *
 * @package Abj\Console
 */
class Configuration
{
    /** @var array */
    private static $configuration;
    
    /**
     *
     */
    public static function initialize()
    {
        //do something initworthy
    }
    
    /**
     * @return array
     */
    public static function getConfiguration()
    {
        if (!self::$configuration)
        {
            self::loadConfiguration();
        }
        
        return self::$configuration;
    }
    
    /**
     */
    protected static function loadConfiguration()
    {
        $config = [
            'test-1' => 'aaa',
            'test-2' => 'bbb',
            'test-3' => 'ccc',
        ];
        
        self::$configuration = $config;
    }
    
}