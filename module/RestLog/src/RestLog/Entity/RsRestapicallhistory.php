<?php

namespace RestLog\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RsRestapicallhistory
 *
 * @ORM\Table(name="rs_RESTAPICallHistory")
 * @ORM\Entity
 */
class RsRestapicallhistory
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
     * @ORM\Column(name="HMACKey_id", type="string", length=45, nullable=true)
     */
    private $hmackeyId;

    /**
     * @var string
     *
     * @ORM\Column(name="method", type="string", nullable=true)
     */
    private $method;

    /**
     * @var string
     *
     * @ORM\Column(name="uri", type="string", length=45, nullable=true)
     */
    private $uri;

    /**
     * @var string
     *
     * @ORM\Column(name="uri_parameters", type="string", length=45, nullable=true)
     */
    private $uriParameters;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param string $hmackeyId
     */
    public function setHmackeyId($hmackeyId)
    {
        $this->hmackeyId = $hmackeyId;
    }

    /**
     * @return string
     */
    public function getHmackeyId()
    {
        return $this->hmackeyId;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param string $uri
     */
    public function setUri($uri)
    {
        $this->uri = $uri;
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @param string $uriParameters
     */
    public function setUriParameters($uriParameters)
    {
        $this->uriParameters = $uriParameters;
    }

    /**
     * @return string
     */
    public function getUriParameters()
    {
        return $this->uriParameters;
    }



}
