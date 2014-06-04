<?php

namespace Intracto\Service;


use Intracto\Model\EmailModel;
use Intracto\Model\Status;
use Intracto\Repository\EmailRepository;
use Silex\Application;
use Silex\ServiceProviderInterface;

class MailService
{
    public function __construct(Application $app)
    {
        $this->repo = new EmailRepository($app);
        $this->mailSubject = $app['mailSubjects'][$app['week_id']];
        $this->template = "email_base.html.twig";
        $this->twig = $app['twig'];
        $this->mailer = $app['mailer'];
        $this->app = $app;
    }

    public function storeMail(EmailModel $email)
    {
        $this->repo->persist($email->toArray(), $email::getModelName());
        $this->repo->flush();
    }

    public function storeAndSendMail(EmailModel $email)
    {
        $this->storeMail($email);
        $this->sendInvitationMail($email);
    }

    public function storeAndSendMails(array $emails)
    {
        foreach ($emails as $email) {
            $this->storeMail($email);
            $this->sendInvitationMail($email);
        }
    }


    public function sendMail($maildata, array $files)
    {
        $message = \Swift_Message::newInstance();
        $message->setSubject($maildata['subject']);
        $message->setTo($maildata['to']);
        $message->setFrom($maildata['from']);
        $message->setBody($maildata['body']);
        foreach ($files as $file) {
            $message->attach(\Swift_Attachment::fromPath($file));
        }
        $this->mailer->send($message);

        if ($this->app['mailer.initialized']) {
            $this->app['swiftmailer.spooltransport']->getSpool()->flushQueue($this->app['swiftmailer.transport']);
        }
    }
}