<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jan.decavele
 * Date: 2/25/14
 * Time: 1:27 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Intracto\Command;


use Intracto\Repository\QuestionRepository;
use Intracto\Repository\RegistrationRepository;
use Silex\Application;
use Symfony\Component\Console\Input\ArgvInput;

class DoctrineSchemaCommand implements IntractoCommandInterface
{
    private $app;

    function __construct(Application $app)
    {
        $this->app = $app;

    }

    public function execute(ArgvInput $input)
    {

        if ($input->getParameterOption('--drop')) {
//DROP COMMAND HERE
        }
//FILL/ALTER COMMAND HERE

    }
}