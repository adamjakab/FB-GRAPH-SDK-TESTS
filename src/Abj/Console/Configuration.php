<?php
/**
 * Created by PhpStorm.
 * User: jackisback
 * Date: 14/11/15
 * Time: 22.32
 */

namespace Abj\Console;

use Facebook\Facebook;
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
    
    /** @var Facebook */
    private static $facebook;
    
    /**
     *
     */
    public static function initialize()
    {
        //do something init-worthy
    }
    
    /**
     * very weak configuration getter
     *
     * @param string $path A dot separated path to deep array element like fb.app.it for $config["fb"]["app"]["id"]
     *
     * @throws \Exception
     *
     * @return mixed
     */
    public static function getConfiguration($path = '')
    {
        if (!self::$configuration)
        {
            self::loadConfiguration();
        }
    
        $parts = [];
        if ($path)
        {
            $parts = explode(".", $path);
        }
    
        $answer = self::$configuration;
        foreach ($parts as $part)
        {
            if (!array_key_exists($part, $answer))
            {
                throw new \Exception("Configuration - invalid requested path($path) part: $part");
            }
            $answer = $answer[$part];
        }
    
        return $answer;
    }
    
    //https://developers.facebook.com/docs/php/Facebook/5.0.0
    //https://developers.facebook.com/tools/explorer/145634995501895/?method=GET&path=10209460937019193&version=v2.8
    /**
     * @return \Facebook\Facebook
     */
    public static function getFacebook()
    {
        if (!self::$facebook)
        {
            $cfg = self::getConfiguration();
            
            self::$facebook = new Facebook
            (
                [
                    'app_id'                  => self::getConfiguration('facebook.app.id'),
                    'app_secret'              => self::getConfiguration('facebook.app.secret'),
                    /*'default_access_token'    => '{access-token}',*/
                    'enable_beta_mode'        => true,
                    'default_graph_version'   => 'v2.8',
                    /*'http_client_handler'     => 'guzzle',*/
                    'persistent_data_handler' => 'memory',
                    /*'url_detection_handler' => new MyUrlDetectionHandler(),*/
                    /*'pseudo_random_string_generator' => new MyPseudoRandomStringGenerator(),*/
                ]
            );
        }
        
        return self::$facebook;
    }
    
    /**
     * Load configuration file
     */
    protected static function loadConfiguration()
    {
        $config = [];
        require("config.php");
        self::$configuration = $config;
    }
}