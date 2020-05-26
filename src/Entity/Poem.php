<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Serializer\Filter\PropertyFilter;
use App\Repository\PoemRepository;
use App\Validator\IsValidOwner;
use Carbon\Carbon;
use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

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
 *              "security_message" = "Only the creator can and edit a poem"
 *          },
 *          "delete" = { "security" = "is_granted('ROLE_ADMIN')" }
 *      },
 *
 *     attributes={
 *     "pagination_items_per_page"=3,
 *      "formats"={"jsonld", "json", "html", "jsonhal", "csv"={"text/csv"}}
 *     }
 * )
 * @ApiFilter(SearchFilter::class, properties={"name": "partial", "text": "partial"})
 * @ApiFilter(PropertyFilter::class)
 * @ORM\Entity(repositoryClass=PoemRepository::class)
 * @ORM\EntityListeners({"App\Doctrine\PoemSetOwnerListener"})
 */
class Poem
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", nullable=true, length=255, options={"comment":"Номи шеър"})
     * @Groups({"poem:read", "poem:write"})
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true, options={"comment":"Тавсиф"})
     * @Groups({"poem:read", "poem:write"})
     */
    private $description;

    /**
     * @ORM\Column(type="text", options={"comment":"Матни шеър"})
     * @Groups({"poem:read", "poem:write", "user:read"})
     * @Assert\NotBlank()
     */
    private $text;

    /**
     * @ORM\Column(type="datetime", options={"comment":"Сохтем дар"})
     */
    private $createdAt;

    /**
     * Соҳиби шеър
     *
     * @ORM\ManyToOne(targetEntity=Poet::class, inversedBy="poems")
     */
    private $poet;

    /**
     * Нафаре ки шеъро ба сомона гузошт
     *
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="poems")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"poem:read", "poem:collection:post"})
     * @IsValidOwner()
     */
    private $owner;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPublished = false;

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

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getIsPublished(): ?bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(bool $isPublished): self
    {
        $this->isPublished = $isPublished;

        return $this;
    }

}
