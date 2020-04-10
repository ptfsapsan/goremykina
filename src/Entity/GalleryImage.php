<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GalleryImageRepository")
 */
class GalleryImage
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $category_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $subcategory_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $big;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $thumb;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategoryId(): ?int
    {
        return $this->category_id;
    }

    public function setCategoryId(int $category_id): self
    {
        $this->category_id = $category_id;

        return $this;
    }

    public function getSubcategoryId(): ?int
    {
        return $this->subcategory_id;
    }

    public function setSubcategoryId(int $subcategory_id): self
    {
        $this->subcategory_id = $subcategory_id;

        return $this;
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
}
