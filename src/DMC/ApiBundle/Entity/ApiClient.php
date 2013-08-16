<?php

namespace DMC\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Description of Client
 *
 * @author diego
 * 
 * @ORM\Entity
 */
class ApiClient {

    /**
     *
     * @var integer 
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     *
     * @var string 
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     *
     * @var string 
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     *
     * @var ArrayCollection 
     * @ORM\OneToMany(targetEntity="ApiClientKey", mappedBy="client", cascade={"ALL"})
     */
    private $keys;

    public function __construct() {
        $this->keys = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return ApiClient
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
     * Set description
     *
     * @param string $description
     * @return ApiClient
     */
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Add key
     *
     * @param \DMC\ApiBundle\Entity\ApiClientKey $keys
     * @return ApiClient
     */
    public function addKey(\DMC\ApiBundle\Entity\ApiClientKey $key) {
        $this->keys[] = $key;
        //make change in the owning side also:
        $key->setClient($this);
        return $this;
    }

    /**
     * Remove key
     *
     * @param \DMC\ApiBundle\Entity\ApiClientKey $keys
     */
    public function removeKey(\DMC\ApiBundle\Entity\ApiClientKey $key) {
        $this->keys->removeElement($key);
        //make change in the owning side also:
        $key->setClient(null);
    }

    /**
     * Get keys
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getKeys() {
        return $this->keys;
    }

}