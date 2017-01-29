<?php

namespace SoftUniBlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * About
 *
 * @ORM\Table(name="about")
 * @ORM\Entity(repositoryClass="SoftUniBlogBundle\Repository\AboutRepository")
 */
class About
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
     * @ORM\Column(name="content", type="text", nullable=true)
     */
    private $content;


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
     * Set content
     *
     * @param string $content
     *
     * @return About
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="biography1", type="text")
     */
    private $biography1;

    /**
     * Set biography1
     *
     * @param string $biography1
     *
     * @return About
     */
    public function setBiography1($biography1)
    {
        $this->biography1 = $biography1;

        return $this;
    }

    /**
     * Get biography1
     *
     * @return string
     */
    public function getBiography1()
    {
        return $this->biography1;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="biography2", type="text")
     */
    private $biography2;

    /**
     * Set biography2
     *
     * @param string $biography2
     *
     * @return About
     */
    public function setBiography2($biography2)
    {
        $this->biography2 = $biography2;

        return $this;
    }

    /**
     * Get biography1
     *
     * @return string
     */
    public function getBiography2()
    {
        return $this->biography2;
    }
}

