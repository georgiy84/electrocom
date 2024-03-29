<?php

namespace Core\UserBundle\Entity;
use Symfony\Component\Security\Core\User\UserInterface;

use Doctrine\ORM\Mapping as ORM;

/**
 * users
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="Core\UserBundle\Repository\usersRepository")
 */
class users implements UserInterface, \Serializable{

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * The below length depends on the "algorithm" you use for encoding
     * the password, but this works well with bcrypt.
     *
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @ORM\ManyToOne(targetEntity="country", inversedBy="users")
     * @ORM\JoinColumn(name="country", referencedColumnName="id")
     */
    private $country;

    /**
     * @var int
     *
     * @ORM\Column(name="gender", type="integer")
     */
    private $gender;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_up", type="datetime")
     */
    private $dateUp;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_edit", type="datetime")
     */
    private $dateEdit;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_access", type="datetime")
     */
    private $dateAccess;

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return users
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return users
     */
    public function setEmail($email) {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Get password
     *
     * @return string
     */
    function getPassword() {
        return $this->password;
    }

    /**
     * Set password
     *
     * @return string
     */
    function setPassword($password) {
        $this->password = $password;
    }

    /**
     * Set country
     *
     * @param integer $country
     *
     * @return users
     */
    public function setCountry($country) {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return int
     */
    public function getCountry() {
        return $this->country;
    }

    /**
     * Set gender
     *
     * @param integer $gender
     *
     * @return users
     */
    public function setGender($gender) {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return int
     */
    public function getGender() {
        return $this->gender;
    }

    /**
     * Set dateUp
     *
     * @param \DateTime $dateUp
     *
     * @return users
     */
    public function setDateUp($dateUp) {
        $this->dateUp = $dateUp;

        return $this;
    }

    /**
     * Get dateUp
     *
     * @return \DateTime
     */
    public function getDateUp() {
        return $this->dateUp;
    }

    /**
     * Set dateEdit
     *
     * @param \DateTime $dateEdit
     *
     * @return users
     */
    public function setDateEdit($dateEdit) {
        $this->dateEdit = $dateEdit;

        return $this;
    }

    /**
     * Get dateEdit
     *
     * @return \DateTime
     */
    public function getDateEdit() {
        return $this->dateEdit;
    }

    /**
     * Set dateAccess
     *
     * @param \DateTime $dateAccess
     *
     * @return users
     */
    public function setDateAccess($dateAccess) {
        $this->dateAccess = $dateAccess;

        return $this;
    }

    /**
     * Get dateAccess
     *
     * @return \DateTime
     */
    public function getDateAccess() {
        return $this->dateAccess;
    }
    
    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }
    
     public function getRoles()
    {
        return ['ROLE_USER'];
    }
    
    public function getUsername()
    {
        return $this->name;
    }
    
    public function eraseCredentials()
    {
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize([
            $this->id,
            $this->name,
            $this->password,
            // see section on salt below
            // $this->salt,
        ]);
    }
    
     /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->name,
            $this->password,
            // see section on salt below
            // $this->salt
        ) = unserialize($serialized, ['allowed_classes' => false]);
    }

}
