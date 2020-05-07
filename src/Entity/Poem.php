<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Serializer\Filter\PropertyFilter;
use App\Repository\PoemRepository;
use Carbon\Carbon;
use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     collectionOperations={"get", "post"},
 *     itemOperations={"get", "put"},
 *     normalizationContext={"groups"={"poem:read"}},
 *     denormalizationContext={"groups"={"poem:write"}},
 *
 *     attributes={
 *     "pagination_items_per_page"=3,
 *      "formats"={"jsonld", "json", "html", "jsonhal", "csv"={"text/csv"}}
 *     }
 * )
 * @ORM\Entity(repositoryClass=PoemRepository::class)
 * @ApiFilter(SearchFilter::class, properties={"name": "partial", "text": "partial"})
 * @ApiFilter(PropertyFilter::class)
 */
class Poem
{
    /**
     * @Groups({"poem:read"})
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     *
     * @Groups({"poem:write", "poem:read"})
     *
     * @ORM\Column(type="string", nullable=true, length=255, options={"comment":"Номи шеър"})
     */
    private $name;

    /**
     * @Groups({"poem:write", "poem:read"})
     *
     * @ORM\Column(type="text", nullable=true, options={"comment":"Тавсиф"})
     */
    private $description;

    /**
     * @Groups({"poem:write", "poem:read"})
     *
     * @ORM\Column(type="text", options={"comment":"Матни шеър"})
     * @Assert\NotBlank()
     */
    private $text;

    /**
     * @ORM\Column(type="datetime", options={"comment":"Сохтем дар"})
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=Poet::class, inversedBy="poems")
     */
    private $poet;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = nl2br($description);

        return $this;
    }

    /**
     * @Groups({"poem:read"})
     *
     * @return string|null
     */
    public function getShortText(): ?string
    {
        if (strlen($this->text) < 40) {
            return $this->text;
        }

        return substr($this->text, 0, 40).'...';
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = nl2br($text);

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * How long ago in text that this poem listening was added.
     *
     * @Groups({"poem:read"})
     *
     * @return string
     */
    public function getCreatedAtAgo(): string
    {
        return Carbon::instance($this->getCreatedAt())->locale('ru_RU')->diffForHumans();
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getPoet(): ?Poet
    {
        return $this->poet;
    }

    public function setPoet(?Poet $poet): self
    {
        $this->poet = $poet;

        return $this;
    }

}
