<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jan.decavele
 * Date: 2/24/14
 * Time: 3:57 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Intracto\Command;


use Silex\Application;
use Symfony\Component\Console\Input\ArgvInput;

interface IntractoCommandInterface
{
    public function __construct(Application $silex);

    public function execute(ArgvInput $input);
}