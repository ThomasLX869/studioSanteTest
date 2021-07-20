<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 * @ApiResource(
 *     attributes={
 *       "order"={"id":"DESC"},
 *     },
 *     paginationItemsPerPage=5,
 *     normalizationContext={"groups" : "read:product"},
 *     denormalizationContext={"groups" : "write:product"},
 *     collectionOperations={"get", "post"},
 *     itemOperations={"get", "delete", "put"},
 * )
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"read:product"})
     */
    private $id;

    /**
     * @Groups({"read:product"})
     */
    private $md5Id;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"read:product", "write:product"})
     */
    private $active;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Groups({"read:product", "write:product"})
     * @Assert\Length(
     *      max = 255,
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(
     *      max = 255,
     * )
     * @Groups({"read:product", "write:product"})
     */
    private $url;

    /**
     * @ORM\Column(type="text"),
     * @Assert\NotBlank
     * @Groups({"read:product", "write:product"})
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Brand::class, cascade={"persist"})
     * @Assert\NotBlank
     * @Groups({"read:product", "write:product"})
     */
    private $brand;

    /**
     * @ORM\ManyToMany(targetEntity=Category::class, cascade={"persist"})
     * @Groups({"read:product", "write:product"})
     */
    private $categories;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(?bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    public function setBrand(?Brand $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        $this->categories->removeElement($category);

        return $this;
    }

    public function getmd5Id(): ?string
    {
        return md5($this->id);
    }
}
