<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jan.decavele
 * Date: 2/19/14
 * Time: 10:03 AM
 * To change this template use File | Settings | File Templates.
 */

namespace Intracto;


use Intracto\Controllers\QuestionFourController;
use Intracto\Service\BaladeMailService;
use Intracto\Service\MailService;
use Intracto\Service\QuestionFourService;
use Intracto\Service\QuestionService;
use Intracto\Service\RegistrationService;
use Silex\Application;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\SecurityServiceProvider;
use Silex\Provider\SwiftmailerServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\ServiceProviderInterface;
use Symfony\Component\HttpFoundation\RequestMatcher;
use Symfony\Component\Translation\Loader\YamlFileLoader;

/**
 * Registers needed providers in the application using config.php
 *
 * Put non vendor providers here for easier debugging:
 * - week_id
 * - mailService
 * - registrationService
 *
 * Class Kernel
 * @package Intracto
 */
class Kernel
{
    public function __construct($configuration)
    {
        $conf = include $configuration;
        $this->doctrine = $conf['doctrine'];
        $this->mailer = $conf['swiftmailer'];
        $this->security = $conf['security'];
        $this->weekId = $conf['week_id'];
        $this->startDate = $conf['startDate'];
        $this->question_one_options = $conf['question_one_options'];
        $this->question_one_heads = $conf['question_one_heads'];
        $this->question_two_pictures = $conf['question_two_pictures'];
        $this->question_two_options = $conf['question_two_options'];
        $this->question_three_options = $conf['question_three_options'];
        $this->tiebreakers = $conf['tiebreakers'];
        $this->mailSubjects = $conf['mailSubjects'];
        $this->assets = $conf['assets'];
    }

    public function load(Application $app, $env = 'web')
    {
        $app['assets_base'] = $this->assets['base_url'];
        $app['week_id'] = $this->weekId;
        $app['mailSubjects'] = $this->mailSubjects;
        $app['startDate'] = date_create_from_format("d-m-Y H:i:s", $this->startDate);
        $app['question_one_options'] = $this->question_one_options;
        $app['question_one_heads'] = $this->question_one_heads;
        $app['question_two_pictures'] = $this->question_two_pictures;
        $app['question_two_options'] = $this->question_two_options;
        $app['question_three_options'] = $this->question_three_options;
        $app['tiebreakers'] = $this->tiebreakers;


        $app->register(
            new MonologServiceProvider(),
            array(
                'monolog.logfile' => __DIR__ . '/../../logs/development.log',
                'monolog.level' => \Monolog\Logger::DEBUG,
                'monolog.name' => 'bfff',
            )
        );

        $app->register(
            new DoctrineServiceProvider(),
            array(
                'db.options' => array(
                    'driver' => $this->doctrine['driver'],
                    'dbname' => $this->doctrine['dbname'],
                    'host' => $this->doctrine['host'],
                    'user' => $this->doctrine['user'],
                    'password' => $this->doctrine['password'],
                ),
            )
        );
        $app->register(new SwiftmailerServiceProvider());
        $app['swiftmailer.options'] = array(
            'host' => $this->mailer['host'],
            'port' => $this->mailer['port'],
            'username' => $this->mailer['username'],
            'password' => $this->mailer['password'],
            'encryption' => $this->mailer['encryption'],
            'auth_mode' => $this->mailer['auth_mode']
        );
        $app->register(
            new TwigServiceProvider(),
            array(
                'twig.path' => __DIR__ . '/Resources/views',
                'twig.options' => array('cache' => __DIR__ . '/../../cache/twig')
            )
        );
        $app->register(new UrlGeneratorServiceProvider());
        $app->register(new FormServiceProvider());
        $app->register(new ValidatorServiceProvider());
        $app->register(new TranslationServiceProvider(), array('locale_fallbacks' => array('nl'),));
        $app['translator'] = $app->share(
            $app->extend(
                'translator',
                function ($translator, $app) {
                    $translator->addLoader('yaml', new YamlFileLoader());
                    $translator->addResource('yaml', __DIR__ . '/Resources/translations/nl.yml', 'nl');

                    return $translator;
                }
            )
        );

        if ($env == "web") {
            //add web exclusive loaders here
            $app->register(
                new SecurityServiceProvider(),
                array(
                    'security.firewalls' => array(
                        'admin' => array(
                            'pattern' => '^/admin',
                            'http' => true,
                            'users' => array(
                                $this->security['user'] => array($this->security['role'], $this->security['password'])
                            ),
                        )
                    )
                )
            );
        } elseif ($env == "cli") {
            //add console exclusive loaders here
        }

        //custom services
        $app['intracto.mailService'] = $app->share(
            function () use ($app) {
                return new MailService($app);
            }
        );
        $app['intracto.registrationService'] = $app->share(
            function () use ($app) {
                return new RegistrationService($app);
            }
        );
        $app['intracto.questionService'] = $app->share(
            function () use ($app) {
                return new QuestionService($app);
            }
        );
        $app['intracto.question4Service'] = $app->share(
            function () use ($app) {
                return new QuestionFourService($app);
            }
        );

    }
}

