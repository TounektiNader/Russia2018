<?php

namespace Russia\RussiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="user", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_8D93D64992FC23A8", columns={"username_canonical"}), @ORM\UniqueConstraint(name="UNIQ_8D93D649A0D96FBF", columns={"email_canonical"}), @ORM\UniqueConstraint(name="UNIQ_8D93D649C05FB297", columns={"confirmation_token"})})
 * @ORM\Entity
 */
class User
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=200, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=200, nullable=false)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="mdp", type="string", length=200, nullable=false)
     */
    private $mdp;

    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=100, nullable=false)
     */
    private $role;

    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=300, nullable=false)
     */
    private $mail;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=100, nullable=false)
     */
    private $status;

    /**
     * @var integer
     *
     * @ORM\Column(name="jeton", type="integer", nullable=false)
     */
    private $jeton;

    /**
     * @var string
     *
     * @ORM\Column(name="nationalite", type="string", length=200, nullable=false)
     */
    private $nationalite;

    /**
     * @var string
     *
     * @ORM\Column(name="num", type="string", length=1000, nullable=false)
     */
    private $num;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=180, nullable=false)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="username_canonical", type="string", length=180, nullable=false)
     */
    private $usernameCanonical;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=180, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="email_canonical", type="string", length=180, nullable=false)
     */
    private $emailCanonical;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=false)
     */
    private $enabled;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=255, nullable=true)
     */
    private $salt;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     */
    private $password;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_login", type="datetime", nullable=true)
     */
    private $lastLogin;

    /**
     * @var string
     *
     * @ORM\Column(name="confirmation_token", type="string", length=180, nullable=true)
     */
    private $confirmationToken;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="password_requested_at", type="datetime", nullable=true)
     */
    private $passwordRequestedAt;

    /**
     * @var array
     *
     * @ORM\Column(name="roles", type="array", nullable=false)
     */
    private $roles;


}

