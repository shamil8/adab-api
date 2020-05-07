<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PoemRepository;
use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=PoemRepository::class)
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
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true, options={"comment":"Тавсиф"})
     */
    private $description;

    /**
     * @ORM\Column(type="text", options={"comment":"Матни шеър"})
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
        $this->setCreatedAt(new DateTime());
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
        $this->description = $description;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
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
