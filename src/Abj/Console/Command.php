<?php
/**
 * Created by Adam Jakab.
 * Date: 07/10/15
 * Time: 14.27
 */

namespace Abj\Console;

use Abj\Console\Configuration;

use Symfony\Component\Console\Command\Command as ConsoleCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Command
 *
 * @package Abj\Console
 */
class Command extends ConsoleCommand
{
    /** @var string */
    protected $configDir = 'config';
    
    /** @var  InputInterface */
    protected $cmdInput;
    
    /** @var  OutputInterface */
    protected $cmdOutput;
    
    /** @var bool */
    protected $logToConsole = false;
    
    /**
     * @param string $name
     */
    public function __construct($name = null)
    {
        parent::__construct($name);
    }
    
    protected function _execute(InputInterface $input, OutputInterface $output)
    {
        $this->cmdInput = $input;
        $this->cmdOutput = $output;
        $this->configure();
    }
    
    /**
     * Parse yml configuration
     */
    protected function configure()
    {
        Configuration::initialize();
    }
    
    /**
     * @param string $msg
     */
    public function log($msg)
    {
        if ($this->logToConsole)
        {
            $this->cmdOutput->writeln($msg);
        }
    }
}