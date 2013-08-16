<?php

namespace DMC\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of ClientKey
 *
 * @author diego
 * @ORM\Entity
 */
class ApiClientKey {

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
     * @ORM\Column(type="string", length=250)
     */
    private $apiKey;

    /**
     *
     * @var string
     * @ORM\Column(type="string", length=250)
     */
    private $apiSecret;

    /**
     *
     * @var ApiClient
     * @ORM\ManyToOne(targetEntity="ApiClient", inversedBy="keys")
     * @ORM\JoinColumn(name="client_id", referencedColumnName="id")
     */
    private $client;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set key
     *
     * @param string $key
     * @return ApiClientKey
     */
    public function setApiKey($key) {
        $this->apiKey = $key;

        return $this;
    }

    /**
     * Get key
     *
     * @return string 
     */
    public function getApiKey() {
        return $this->apiKey;
    }

    /**
     * Set secret
     *
     * @param string $secret
     * @return ApiClientKey
     */
    public function setApiSecret($secret) {
        $this->apiSecret = $secret;

        return $this;
    }

    /**
     * Get secret
     *
     * @return string 
     */
    public function getApiSecret() {
        return $this->apiSecret;
    }

    /**
     * Set client
     *
     * @param \DMC\ApiBundle\Entity\ApiClient $client
     * @return ApiClientKey
     */
    public function setClient(\DMC\ApiBundle\Entity\ApiClient $client = null) {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return \DMC\ApiBundle\Entity\ApiClient 
     */
    public function getClient() {
        return $this->client;
    }

}