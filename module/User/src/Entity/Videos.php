<?php

namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Videos
 *
 * @ORM\Table(name="videos", indexes={@ORM\Index(name="fk_videos_modules1_idx", columns={"modules_id"})})
 * @ORM\Entity
 */
class Videos
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=45, precision=0, scale=0, nullable=true, unique=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="file", type="text", length=65535, precision=0, scale=0, nullable=true, unique=false)
     */
    private $file;

    /**
     * @var \User\Entity\Modules
     *
     * @ORM\ManyToOne(targetEntity="User\Entity\Modules")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="modules_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $modules;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Videos
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set file
     *
     * @param string $file
     *
     * @return Videos
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file
     *
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set modules
     *
     * @param \User\Entity\Modules $modules
     *
     * @return Videos
     */
    public function setModules(\User\Entity\Modules $modules = null)
    {
        $this->modules = $modules;

        return $this;
    }

    /**
     * Get modules
     *
     * @return \User\Entity\Modules
     */
    public function getModules()
    {
        return $this->modules;
    }
}

