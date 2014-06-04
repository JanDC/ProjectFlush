<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jan.decavele
 * Date: 2/20/14
 * Time: 11:14 AM
 * To change this template use File | Settings | File Templates.
 */

namespace Intracto\Repository;


use Doctrine\DBAL\Connection;
use Intracto\Model\EmailModel;
use Intracto\Model\IntractoModel;
use Intracto\Model\RegistrationModel;
use Intracto\Model\Status;
use Silex\Application;
use Silex\Provider\DoctrineServiceProvider;

class EmailRepository extends IntractoRepository
{
    /**
     * @var $db Connection
     */
    protected $db;

    public function findOneById($id)
    {
        $dataArray = $this->db->fetchAll("SELECT * FROM email WHERE id = ? LIMIT 1", array($id));

        return new EmailModel(current($dataArray));
    }

    public function getLastEntryByEmail($email_address)
    {
        $dataArray = $this->db->fetchAll(
            "SELECT * FROM email WHERE email_address= ? ORDER BY id DESC LIMIT 1",
            array($email_address)
        );

        return new EmailModel(current($dataArray));
    }

    public function getReffererRegistration(EmailModel $email)
    {
        $dataArray = $this->db->fetchAll(
            "SELECT * FROM registration WHERE id= ? ORDER BY id DESC LIMIT 1",
            array(
                $email->getReffererId()
            )
        );

        return new RegistrationModel(current($dataArray));


    }

    public function findOneByReferrerAndAddress($refferer_id, $emailaddress)
    {
        $dataArray = $this->db->fetchAll(
            "SELECT * FROM email WHERE refferer_id= ? and email_address = ? ORDER BY id DESC LIMIT 1",
            array(
                $refferer_id,
                $emailaddress
            )
        );

        return new EmailModel(current($dataArray));


    }

    public function getRegistrationByMail(EmailModel $email)
    {
        $dataArray = $this->db->fetchAll(
            "SELECT * FROM registration WHERE email_id= ? ORDER BY id DESC LIMIT 1",
            array(
                $email->getId()
            )
        );

        return new RegistrationModel(current($dataArray));
    }


}
