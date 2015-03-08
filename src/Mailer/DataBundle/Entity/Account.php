<?php

namespace Mailer\DataBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Account.
 *
 * @ORM\Table("account")
 * @ORM\Entity
 */
class Account
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="server", type="string", length=255)
     */
    private $server;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creation_date", type="datetime")
     */
    private $creationDate;

    /**
     * @ORM\ManyToOne(targetEntity="Mailer\UserBundle\Entity\User", inversedBy="accounts")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var integer
     *
     * @ORM\Column(name="port", type="integer")
     */
    private $port;

    /**
     * @var string
     *
     * @ORM\Column(name="security", type="string", length=255)
     */
    private $security;

    /**
     * @ORM\OneToMany(targetEntity="Mail", mappedBy="account", cascade={"persist"})
     */
    private $mails;

    public function __construct()
    {
        $this->mails = new ArrayCollection();
    }

    /**
     * Get id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set email.
     *
     * @param string $email
     *
     * @return Account
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set server.
     *
     * @param string $server
     *
     * @return Account
     */
    public function setServer($server)
    {
        $this->server = $server;

        return $this;
    }

    /**
     * Get server.
     *
     * @return string
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     * Set username.
     *
     * @param string $username
     *
     * @return Account
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password.
     *
     * @param string $password
     *
     * @return Account
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set creationDate.
     *
     * @param \DateTime $creationDate
     *
     * @return Account
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get creationDate.
     *
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set port.
     *
     * @param integer $port
     *
     * @return Account
     */
    public function setPort($port)
    {
        $this->port = $port;

        return $this;
    }

    /**
     * Get port.
     *
     * @return integer
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * Set security.
     *
     * @param string $security
     *
     * @return Account
     */
    public function setSecurity($security)
    {
        $this->security = $security;

        return $this;
    }

    /**
     * Get security.
     *
     * @return string
     */
    public function getSecurity()
    {
        return $this->security;
    }

    /**
     * Set user.
     *
     * @param \Mailer\UserBundle\Entity\User $user
     *
     * @return Account
     */
    public function setUser(\Mailer\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return \Mailer\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add mails.
     *
     * @param \Mailer\DataBundle\Entity\Mail $mails
     *
     * @return Account
     */
    public function addMail(\Mailer\DataBundle\Entity\Mail $mails)
    {
        $this->mails[] = $mails;

        return $this;
    }

    /**
     * Remove mails.
     *
     * @param \Mailer\DataBundle\Entity\Mail $mails
     */
    public function removeMail(\Mailer\DataBundle\Entity\Mail $mails)
    {
        $this->mails->removeElement($mails);
    }

    /**
     * Get mails.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMails()
    {
        return $this->mails;
    }
}
