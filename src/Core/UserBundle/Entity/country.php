<?php

namespace Core\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;

/**
 * country
 *
 * @ORM\Table(name="country")
 * @ORM\Entity(repositoryClass="Core\UserBundle\Repository\countryRepository")
 */
class country
{
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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return country
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    
     /**
     * @ORM\OneToMany(targetEntity="users", mappedBy="country")
     */
    private $Users;

    public function __construct()
    {
        $this->Users = new ArrayCollection();
    }
}

