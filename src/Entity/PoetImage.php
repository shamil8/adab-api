<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * @ApiResource(
 *     collectionOperations={"get", "post"},
 *     itemOperations={"get", "put"}
 * )
 * @ORM\Entity()
 */
class PoetImage
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity=Poet::class, inversedBy="images")
     */
    private Poet $poet;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, options={"comment":"Номи сурат"})
     */
    private ?string $title;

    /**
     * @ORM\Column(type="string", length=255, options={"comment":"Пайванд ба сурат"})
     */
    private string $src;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTime $createdAt;

    public function __construct()
    {
        $this->setCreatedAt(new DateTime());
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getPoet(): Poet
    {
        return $this->poet;
    }

    public function setPoet(Poet $poet): self
    {
        $this->poet = $poet;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSrc(): string
    {
        return $this->src;
    }

    public function setSrc(string $src): self
    {
        $this->src = $src;

        return $this;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
