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
 *     "pagination_items_per_page"=5,
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
     * @Groups({"poem:read"})
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
     * Соҳиби шеър (холи буда наметавонад)
     * агар шеър соҳиб надошта бошад шоъири номаълумро интихоб кунанад!
     *
     * @ORM\ManyToOne(targetEntity=Poet::class, inversedBy="poems")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"poem:read", "poem:write", "poem:collection:post"})
     */
    private $poet;

    /**
     * Нафаре ки шеъро ба сомона гузошт (холи буда наметавонад)
     *
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="poems")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"poem:read", "poem:collection:post"})
     * @IsValidOwner()
     */
    private $owner;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"poem:read", "poem:write", "poem:collection:post"})
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
        $symbol = '<br />';
        $count = 3;
        $strPosition = $this->strposX($this->text, $symbol, $count);

        $strPosition = $strPosition
            ? $strPosition  - strlen($symbol) * $count - $count - 1
            : strlen($this->text) + 1;

        if (strlen($this->text) < $strPosition) {
            return $this->text;
        }

        return mb_substr($this->text, 0, $strPosition, "utf-8");
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

    /**
     * Find the position of the Xth occurrence of a substring in a string
     * @param $haystack
     * @param $needle
     * @param $number integer > 0
     * @return int
     */
    private function strposX($haystack, $needle, $number){
        if(!strpos($haystack, $needle) || $number == '1'){
            return strpos($haystack, $needle);
        }elseif($number > '1'){
            return strpos($haystack, $needle, $this->strposX($haystack, $needle, $number - 1) + strlen($needle));
        }else{
            return error_log('Error: Value for parameter $number is out of range');
        }
    }
}
