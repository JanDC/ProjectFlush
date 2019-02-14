<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jan.decavele
 * Date: 2/19/14
 * Time: 9:51 AM
 * To change this template use File | Settings | File Templates.
 */

namespace Intracto\Controllers;

use Imagine\Image\Point;
use Intracto\Form\ContactFormType;
use Intracto\Form\InvitationFormType;
use Intracto\Model\EmailModel;
use Intracto\Model\RegistrationModel;
use Intracto\Repository\EmailRepository;
use Intracto\Repository\RegistrationRepository;
use Intracto\Service\MailService;
use Intracto\Service\RegistrationService;
use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Intracto\Form\RegistrationFormType;

class DefaultController implements ControllerProviderInterface
{
    /**
     * @var $repo RegistrationRepository
     */
    public $repo;
    /**
     * @var $emailrepo EmailRepository
     */
    public $emailrepo;

    public $uploadDir;

    public function connect(Application $app)
    {
        // creates a new controller based on the default route
        $that = $this; //php 5.3 workaround
        $controllers = $app['controllers_factory'];
        $controllers->match(
            '/',
            function (Request $request, Application $app) use ($that) {
                return $that->indexAction($request, $app);
            }
        )->bind('lander');

        return $controllers;
    }


    public function indexAction(Request $request, Application $app)
    {


        return $app['twig']->render(
            'index.html.twig',
            array(),
            new StreamedResponse()
        );
    }


}
