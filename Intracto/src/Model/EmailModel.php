<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jan.decavele
 * Date: 2/21/14
 * Time: 3:56 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Intracto\Model;


class EmailModel extends IntractoModel
{

    static function getModelName()
    {
        return 'email';
    }

    static function getForeignKeys()
    {
        $refferer_id = array('refferer_id', 'registration', 'id');

        return array($refferer_id);
    }

    static function getFields()
    {
        $email = array('`email_address`', 'varchar(125) NOT NULL');
        $name = array('`name`', 'varchar(125) DEFAULT NULL');
        $refferer_id = array('`refferer_id`', 'int(11) DEFAULT NULL');
        $timestamp = array('`creation_time`', 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP');
        $accepted = array('`accepted`', 'BOOLEAN NOT NULL');

        return array(
            $email,
            $name,
            $refferer_id,
            $timestamp,
            $accepted
        );
    }

    /**
     * @var $id integer
     */
    private $id;
    /**
     * @var $email_address string
     */
    private $email_address;
    /**
     * @var $name string
     */
    private $name;
    /**
     * @var $accepted boolean
     */
    private $accepted;

    /**
     * @param boolean $accepted
     */
    public function setAccepted($accepted)
    {
        $this->accepted = $accepted;
    }

    /**
     * @return boolean
     */
    public function getAccepted()
    {
        return $this->accepted;
    }

    /**
     * @var $refferer_id integer
     */
    private $refferer_id;
    /**
     * @var $creation_time \DateTime
     */
    private $creation_time;

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $email_address
     */
    public function setEmailAddress($email_address)
    {
        $this->email_address = $email_address;
    }

    /**
     * @return string
     */
    public function getEmailAddress()
    {
        return $this->email_address;
    }

    /**
     * @param \DateTime $creation_time
     */
    public function setCreationTime($creation_time)
    {
        $this->creation_time = $creation_time;
    }

    /**
     * @return \DateTime
     */
    public function getCreationTime()
    {
        return $this->creation_time;
    }

    /**
     * @param integer $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @param int $refferer_id
     */
    public function setReffererId($refferer_id)
    {
        $this->refferer_id = $refferer_id;
    }

    /**
     * @return int
     */
    public function getReffererId()
    {
        return $this->refferer_id;
    }


}