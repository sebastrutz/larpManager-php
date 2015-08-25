<?php

/**
 * Auto generated by MySQL Workbench Schema Exporter.
 * Version 2.1.6-dev (doctrine2-annotation) on 2015-08-25 21:04:50.
 * Goto https://github.com/johmue/mysql-workbench-schema-exporter for more
 * information.
 */

namespace LarpManager\Entities;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * LarpManager\Entities\User
 *
 * @Entity()
 * @Table(name="`user`", indexes={@Index(name="fk_user_joueur1_idx", columns={"joueur_id"}), @Index(name="fk_user_groupe1_idx", columns={"groupe_id"})}, uniqueConstraints={@UniqueConstraint(name="email_UNIQUE", columns={"email"}), @UniqueConstraint(name="username_UNIQUE", columns={"username"}), @UniqueConstraint(name="id_UNIQUE", columns={"id"})})
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({"base":"BaseUser", "extended":"User"})
 */
class BaseUser
{
    /**
     * @Id
     * @Column(type="integer", options={"unsigned":true})
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Column(type="string", length=100)
     */
    protected $email;

    /**
     * @Column(name="`password`", type="string", length=255, nullable=true)
     */
    protected $password;

    /**
     * @Column(type="string", length=255)
     */
    protected $salt;

    /**
     * @Column(type="string", length=255)
     */
    protected $rights;

    /**
     * @Column(name="`name`", type="string", length=100)
     */
    protected $name;

    /**
     * @Column(type="datetime")
     */
    protected $creation_date;

    /**
     * @Column(type="string", length=100, nullable=true)
     */
    protected $username;

    /**
     * @Column(type="boolean")
     */
    protected $isEnabled;

    /**
     * @Column(type="string", length=100, nullable=true)
     */
    protected $confirmationToken;

    /**
     * @Column(type="integer", nullable=true, options={"unsigned":true})
     */
    protected $timePasswordResetRequested;

    /**
     * @OneToMany(targetEntity="Groupe", mappedBy="userRelatedByScenaristeId")
     * @JoinColumn(name="id", referencedColumnName="scenariste_id")
     */
    protected $groupeRelatedByScenaristeIds;

    /**
     * @OneToMany(targetEntity="Groupe", mappedBy="userRelatedByResponsableId")
     * @JoinColumn(name="id", referencedColumnName="responsable_id")
     */
    protected $groupeRelatedByResponsableIds;

    /**
     * @OneToMany(targetEntity="Objet", mappedBy="userRelatedByResponsableId")
     * @JoinColumn(name="id", referencedColumnName="responsable_id")
     */
    protected $objetRelatedByResponsableIds;

    /**
     * @OneToMany(targetEntity="Objet", mappedBy="userRelatedByCreateurId")
     * @JoinColumn(name="id", referencedColumnName="createur_id")
     */
    protected $objetRelatedByCreateurIds;

    /**
     * @OneToOne(targetEntity="Joueur", inversedBy="user")
     * @JoinColumn(name="joueur_id", referencedColumnName="id")
     */
    protected $joueur;

    /**
     * @ManyToOne(targetEntity="Groupe", inversedBy="users")
     * @JoinColumn(name="groupe_id", referencedColumnName="id")
     */
    protected $groupe;

    public function __construct()
    {
        $this->groupeRelatedByScenaristeIds = new ArrayCollection();
        $this->groupeRelatedByResponsableIds = new ArrayCollection();
        $this->objetRelatedByResponsableIds = new ArrayCollection();
        $this->objetRelatedByCreateurIds = new ArrayCollection();
    }

    /**
     * Set the value of id.
     *
     * @param integer $id
     * @return \LarpManager\Entities\User
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of email.
     *
     * @param string $email
     * @return \LarpManager\Entities\User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of password.
     *
     * @param string $password
     * @return \LarpManager\Entities\User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of password.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of salt.
     *
     * @param string $salt
     * @return \LarpManager\Entities\User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get the value of salt.
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set the value of rights.
     *
     * @param string $rights
     * @return \LarpManager\Entities\User
     */
    public function setRights($rights)
    {
        $this->rights = $rights;

        return $this;
    }

    /**
     * Get the value of rights.
     *
     * @return string
     */
    public function getRights()
    {
        return $this->rights;
    }

    /**
     * Set the value of name.
     *
     * @param string $name
     * @return \LarpManager\Entities\User
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of creation_date.
     *
     * @param \DateTime $creation_date
     * @return \LarpManager\Entities\User
     */
    public function setCreationDate($creation_date)
    {
        $this->creation_date = $creation_date;

        return $this;
    }

    /**
     * Get the value of creation_date.
     *
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creation_date;
    }

    /**
     * Set the value of username.
     *
     * @param string $username
     * @return \LarpManager\Entities\User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get the value of username.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set the value of isEnabled.
     *
     * @param boolean $isEnabled
     * @return \LarpManager\Entities\User
     */
    public function setIsEnabled($isEnabled)
    {
        $this->isEnabled = $isEnabled;

        return $this;
    }

    /**
     * Get the value of isEnabled.
     *
     * @return boolean
     */
    public function getIsEnabled()
    {
        return $this->isEnabled;
    }

    /**
     * Set the value of confirmationToken.
     *
     * @param string $confirmationToken
     * @return \LarpManager\Entities\User
     */
    public function setConfirmationToken($confirmationToken)
    {
        $this->confirmationToken = $confirmationToken;

        return $this;
    }

    /**
     * Get the value of confirmationToken.
     *
     * @return string
     */
    public function getConfirmationToken()
    {
        return $this->confirmationToken;
    }

    /**
     * Set the value of timePasswordResetRequested.
     *
     * @param integer $timePasswordResetRequested
     * @return \LarpManager\Entities\User
     */
    public function setTimePasswordResetRequested($timePasswordResetRequested)
    {
        $this->timePasswordResetRequested = $timePasswordResetRequested;

        return $this;
    }

    /**
     * Get the value of timePasswordResetRequested.
     *
     * @return integer
     */
    public function getTimePasswordResetRequested()
    {
        return $this->timePasswordResetRequested;
    }

    /**
     * Add Groupe entity related by `scenariste_id` to collection (one to many).
     *
     * @param \LarpManager\Entities\Groupe $groupe
     * @return \LarpManager\Entities\User
     */
    public function addGroupeRelatedByScenaristeId(Groupe $groupe)
    {
        $this->groupeRelatedByScenaristeIds[] = $groupe;

        return $this;
    }

    /**
     * Remove Groupe entity related by `scenariste_id` from collection (one to many).
     *
     * @param \LarpManager\Entities\Groupe $groupe
     * @return \LarpManager\Entities\User
     */
    public function removeGroupeRelatedByScenaristeId(Groupe $groupe)
    {
        $this->groupeRelatedByScenaristeIds->removeElement($groupe);

        return $this;
    }

    /**
     * Get Groupe entity related by `scenariste_id` collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGroupeRelatedByScenaristeIds()
    {
        return $this->groupeRelatedByScenaristeIds;
    }

    /**
     * Add Groupe entity related by `responsable_id` to collection (one to many).
     *
     * @param \LarpManager\Entities\Groupe $groupe
     * @return \LarpManager\Entities\User
     */
    public function addGroupeRelatedByResponsableId(Groupe $groupe)
    {
        $this->groupeRelatedByResponsableIds[] = $groupe;

        return $this;
    }

    /**
     * Remove Groupe entity related by `responsable_id` from collection (one to many).
     *
     * @param \LarpManager\Entities\Groupe $groupe
     * @return \LarpManager\Entities\User
     */
    public function removeGroupeRelatedByResponsableId(Groupe $groupe)
    {
        $this->groupeRelatedByResponsableIds->removeElement($groupe);

        return $this;
    }

    /**
     * Get Groupe entity related by `responsable_id` collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGroupeRelatedByResponsableIds()
    {
        return $this->groupeRelatedByResponsableIds;
    }

    /**
     * Add Objet entity related by `responsable_id` to collection (one to many).
     *
     * @param \LarpManager\Entities\Objet $objet
     * @return \LarpManager\Entities\User
     */
    public function addObjetRelatedByResponsableId(Objet $objet)
    {
        $this->objetRelatedByResponsableIds[] = $objet;

        return $this;
    }

    /**
     * Remove Objet entity related by `responsable_id` from collection (one to many).
     *
     * @param \LarpManager\Entities\Objet $objet
     * @return \LarpManager\Entities\User
     */
    public function removeObjetRelatedByResponsableId(Objet $objet)
    {
        $this->objetRelatedByResponsableIds->removeElement($objet);

        return $this;
    }

    /**
     * Get Objet entity related by `responsable_id` collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getObjetRelatedByResponsableIds()
    {
        return $this->objetRelatedByResponsableIds;
    }

    /**
     * Add Objet entity related by `createur_id` to collection (one to many).
     *
     * @param \LarpManager\Entities\Objet $objet
     * @return \LarpManager\Entities\User
     */
    public function addObjetRelatedByCreateurId(Objet $objet)
    {
        $this->objetRelatedByCreateurIds[] = $objet;

        return $this;
    }

    /**
     * Remove Objet entity related by `createur_id` from collection (one to many).
     *
     * @param \LarpManager\Entities\Objet $objet
     * @return \LarpManager\Entities\User
     */
    public function removeObjetRelatedByCreateurId(Objet $objet)
    {
        $this->objetRelatedByCreateurIds->removeElement($objet);

        return $this;
    }

    /**
     * Get Objet entity related by `createur_id` collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getObjetRelatedByCreateurIds()
    {
        return $this->objetRelatedByCreateurIds;
    }

    /**
     * Set Joueur entity (one to one).
     *
     * @param \LarpManager\Entities\Joueur $joueur
     * @return \LarpManager\Entities\User
     */
    public function setJoueur(Joueur $joueur)
    {
        $this->joueur = $joueur;

        return $this;
    }

    /**
     * Get Joueur entity (one to one).
     *
     * @return \LarpManager\Entities\Joueur
     */
    public function getJoueur()
    {
        return $this->joueur;
    }

    /**
     * Set Groupe entity (many to one).
     *
     * @param \LarpManager\Entities\Groupe $groupe
     * @return \LarpManager\Entities\User
     */
    public function setGroupe(Groupe $groupe = null)
    {
        $this->groupe = $groupe;

        return $this;
    }

    /**
     * Get Groupe entity (many to one).
     *
     * @return \LarpManager\Entities\Groupe
     */
    public function getGroupe()
    {
        return $this->groupe;
    }

    public function __sleep()
    {
        return array('id', 'email', 'password', 'salt', 'rights', 'name', 'creation_date', 'username', 'isEnabled', 'confirmationToken', 'timePasswordResetRequested', 'joueur_id', 'groupe_id');
    }
}