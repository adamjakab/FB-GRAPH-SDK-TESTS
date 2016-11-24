<?php
/**
 * Created by Adam Jakab.
 * Date: 24/11/16
 * Time: 14.21
 */

namespace Abj\Console;

use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Application
 *
 * @package Abj\Console
 */
class Application extends BaseApplication
{
    
    /**
     * @param string $name
     * @param string $version
     */
    public function __construct($name, $version)
    {
        parent::__construct($name, $version);
        $commands = $this->enumerateCommands();
        foreach ($commands as $command)
        {
            $this->add(new $command);
        }
    }
    
    /**
     * Runs the current application.
     *
     * @param InputInterface  $input  An Input instance
     * @param OutputInterface $output An Output instance
     *
     * @return int 0 if everything went fine, or an error code
     *
     * @throws \Exception When doRun returns Exception
     *
     * @api
     */
    public function run(InputInterface $input = null, OutputInterface $output = null)
    {
        $res = parent::run($input, $output);
        
        return $res;
    }
    
    /**
     * @return array
     */
    protected function enumerateCommands()
    {
        $answer = [];
        $commandsPath = realpath(__DIR__ . '/../Command');
        $commandFiles = glob($commandsPath . '/*Command.php');
        foreach ($commandFiles as &$commandFile)
        {
            $commandClass = 'Abj\\Command\\' . str_replace(
                    '.php', '', str_replace(
                              $commandsPath . '/', '', $commandFile
                          )
                );
            if (in_array('Abj\Console\CommandInterface', class_implements($commandClass)))
            {
                $answer[] = $commandClass;
            }
        }
        
        return $answer;
    }
}

