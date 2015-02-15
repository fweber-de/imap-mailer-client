<?php

namespace Mailer\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="Mailer\DataBundle\Entity\Account", mappedBy="user")
     */
    private $accounts;

    public function __construct()
    {
        parent::__construct();

        $this->accounts = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getAccounts()
    {
        return $this->accounts;
    }

    /**
     * @param $accounts
     * @return $this
     */
    public function setAccounts($accounts)
    {
        $this->accounts = $accounts;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Add accounts
     *
     * @param  \Mailer\DataBundle\Entity\Account $accounts
     * @return User
     */
    public function addAccount(\Mailer\DataBundle\Entity\Account $accounts)
    {
        $this->accounts[] = $accounts;

        return $this;
    }

    /**
     * Remove accounts
     *
     * @param \Mailer\DataBundle\Entity\Account $accounts
     */
    public function removeAccount(\Mailer\DataBundle\Entity\Account $accounts)
    {
        $this->accounts->removeElement($accounts);
    }
}
