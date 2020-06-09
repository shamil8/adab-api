<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Serializer\Filter\PropertyFilter;
use App\Repository\PoetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use DateTime;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     collectionOperations={
 *          "get",
 *          "post" = { "security" = "is_granted('ROLE_USER')" }
 *     },
 *     itemOperations={
 *          "get",
 *          "put" = {
 *              "security"="is_granted('EDIT', object)",
 *              "security_message" = "Only the creator can and edit a poet"
 *          },
 *          "delete" = { "security" = "is_granted('ROLE_ADMIN')" }
 *      },
 *     normalizationContext={"groups"={"poet:read"}},
 *     denormalizationContext={"groups"={"user:write"}},
 *
 *     attributes={
 *     "pagination_items_per_page"=3,
 *      "formats"={"jsonld", "json", "html", "jsonhal", "csv"={"text/csv"}}
 *     }
 * )
 * @ApiFilter(SearchFilter::class, properties={"name": "partial", "text": "partial"})
 * @ApiFilter(PropertyFilter::class)
 * @ORM\Entity(repositoryClass=PoetRepository::class)
 */
class Poet
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, options={"comment":"Ном"} )
     * @Groups({"poet:read", "poet:write", "poem:read"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, options={"comment":"Насаб"})
     * @Groups({"poet:read", "poet:write", "poem:read"})
     */
    private $surname;

    /**
     * @ORM\Column(type="string", length=255, options={"comment":"Номи пурра"})
     * @Groups({"poet:read", "poet:write"})
     */
    private $fullName;

    /**
     * @ORM\Column(type="text", nullable=true, options={"comment":"Тарҷумаи ҳол"})
     * @Groups({"poet:read", "poet:write"})
     */
    private $biography;

    /**
     * @ORM\Column(type="date", nullable=true, options={"comment":"Саннаи таваллуд"})
     * @Groups({"poet:read", "poet:write"})
     */
    private $dateBirth;

    /**
     * @ORM\Column(type="date", nullable=true, options={"comment":"Саннаи вафот"})
     * @Groups({"poet:read", "poet:write"})
     */
    private $dateDeath;

    /**
     * @ORM\Column(type="datetime", options={"comment":"Сохтем дар"})
     */
    private $createAt;

    /**
     * @ORM\OneToMany(targetEntity=PoetImage::class, mappedBy="poet", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $images;

    /**
     * @ORM\OneToMany(targetEntity=Poem::class, mappedBy="poet", cascade={"persist", "remove"}, orphanRemoval=true)
     * @Groups({"poet:read"})
     */
    private $poems;

    public function __construct()
    {
        $this->setCreateAt(new DateTime());

        $this->images = new ArrayCollection();
        $this->poems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(?string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): self
    {
        $this->fullName = $fullName;

        return $this;
    }

    public function getBiography(): ?string
    {
        return $this->biography;
    }

    public function setBiography(?string $biography): self
    {
        $this->biography = nl2br($biography);

        return $this;
    }

    public function getDateBirth(): ?\DateTimeInterface
    {
        return $this->dateBirth;
    }

    public function setDateBirth(?\DateTimeInterface $dateBirth): self
    {
        $this->dateBirth = $dateBirth;

        return $this;
    }

    public function getDateDeath(): ?\DateTimeInterface
    {
        return $this->dateDeath;
    }

    public function setDateDeath(?\DateTimeInterface $dateDeath): self
    {
        $this->dateDeath = $dateDeath;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeInterface $createAt): self
    {
        $this->createAt = $createAt;

        return $this;
    }

    /**
     * @return Collection|PoetImage[]
     */
    public function getPoetImages(): Collection
    {
        return $this->images;
    }

    public function addPoetImage(PoetImage $image): self
    {
        if (!$this->images->contains($image)) {
            $image->setPoet($this);
            $this->images->add($image);
        }

        return $this;
    }

    public function removePoemImage(PoetImage $images): self
    {
        if ($this->images->contains($images)) {
            $this->images->removeElement($images);
            // set the owning side to null (unless already changed)
            if ($images->getPoet() === $this) {
                $images->setPoet(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Poem[]
     */
    public function getPoems(): Collection
    {
        return $this->poems;
    }

    public function addPoem(Poem $poem): self
    {
        if (!$this->poems->contains($poem)) {
            $poem->setPoet($this);
            $this->poems->add($poem);
        }

        return $this;
    }

    public function removePoem(Poem $poem): self
    {
        if ($this->poems->contains($poem)) {
            $this->poems->removeElement($poem);
            // set the owning side to null (unless already changed)
            if ($poem->getPoet() === $this) {
                $poem->setPoet(null);
            }
        }

        return $this;
    }
}
