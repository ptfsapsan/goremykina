<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MainImageRepository")
 */
class MainImage
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $big;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $thumb;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $active;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBig(): ?string
    {
        return $this->big;
    }

    public function setBig(string $big): self
    {
        $this->big = $big;

        return $this;
    }

    public function getThumb(): ?string
    {
        return $this->thumb;
    }

    public function setThumb(string $thumb): self
    {
        $this->thumb = $thumb;

        return $this;
    }

    public function getActive(): ?string
    {
        return $this->active;
    }

    public function setActive(string $active): self
    {
        $this->active = $active;

        return $this;
    }
}
