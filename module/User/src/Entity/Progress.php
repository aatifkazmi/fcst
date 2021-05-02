<?php

namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Progress
 *
 * @ORM\Table(name="progress", indexes={@ORM\Index(name="fk_progress_videos1_idx", columns={"videos_id"}), @ORM\Index(name="fk_progress_users", columns={"user_id"})})
 * @ORM\Entity
 */
class Progress
{
    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=10, precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $status;

    /**
     * @var \User\Entity\Users
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="User\Entity\Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $user;

    /**
     * @var \User\Entity\Videos
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="User\Entity\Videos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="videos_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $videos;


    /**
     * Set status
     *
     * @param string $status
     *
     * @return Progress
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set user
     *
     * @param \User\Entity\Users $user
     *
     * @return Progress
     */
    public function setUser(\User\Entity\Users $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \User\Entity\Users
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set videos
     *
     * @param \User\Entity\Videos $videos
     *
     * @return Progress
     */
    public function setVideos(\User\Entity\Videos $videos)
    {
        $this->videos = $videos;

        return $this;
    }

    /**
     * Get videos
     *
     * @return \User\Entity\Videos
     */
    public function getVideos()
    {
        return $this->videos;
    }
}

