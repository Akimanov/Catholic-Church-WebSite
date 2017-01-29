<?php

namespace SoftUniBlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Statistics
 *
 * @ORM\Table(name="statistics")
 * @ORM\Entity(repositoryClass="SoftUniBlogBundle\Repository\StatisticsRepository")
 */
class Statistics
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
     * @ORM\Column(name="Content", type="text", nullable=true)
     */
    private $Content;


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
     * Set Content
     *
     * @param string $Content
     *
     * @return Statistics
     */
    public function setContent($Content)
    {
        $this->Content = $Content;

        return $this;
    }

    /**
     * Get Content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->Content;
    }

}

