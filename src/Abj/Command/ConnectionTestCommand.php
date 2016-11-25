<?php
/**
 * Created by Adam Jakab.
 * Date: 07/10/15
 * Time: 14.26
 */

namespace Abj\Command;

use Abj\Console\Command;
use Abj\Console\CommandInterface;
use Abj\Console\Configuration;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ConnectionTestCommand extends Command implements CommandInterface
{
    const COMMAND_NAME = 'fb:connection-test';
    const COMMAND_DESCRIPTION = 'Run some fb tests...';
    
    public function __construct()
    {
        parent::__construct(null);
    }
    
    /**
     * Configure command
     */
    protected function configure()
    {
        $this->setName(static::COMMAND_NAME);
        $this->setDescription(static::COMMAND_DESCRIPTION);
        //$this->setDefinition();
    }
    
    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return null|int null or 0 if everything went fine, or an error code
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        parent::_execute($input, $output);
    
        return $this->executeCommand();
    }
    
    /**
     * Execute Command
     */
    protected function executeCommand()
    {
        //$this->log(static::COMMAND_NAME . " working...");
        $this->doEmailCheck();
    }
    
    protected function doEmailCheck()
    {
        $accessToken = Configuration::getConfiguration("facebook.me.access_token");
        $fb = Configuration::getFacebook();
        $fb->setDefaultAccessToken($accessToken);
    
        $me = false;
    
        try
        {
            $response = $fb->get('/me');
            $me = $response->getGraphUser();
        }
        catch(FacebookResponseException $e)
        {
            // When Graph returns an error
            $this->log('Graph returned an error: ' . $e->getMessage());
        }
        catch(FacebookSDKException $e)
        {
            // When validation fails or other local issues
            $this->log('Facebook SDK returned an error: ' . $e->getMessage());
        }
    
        if ($me)
        {
            $this->log('Logged in as ' . $me->getName());
        }
        
    }
}