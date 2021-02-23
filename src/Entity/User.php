<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Constants\RoleConstants;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Serializer\Filter\PropertyFilter;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

/**
 *
 * and object === user - it means that only this user can change data
 * security - it means default access user
 *
 * @ApiResource(
 *     security="is_granted('ROLE_USER')",
 *     collectionOperations={
 *          "get",
 *          "post" = {
 *              "security" = "is_granted('IS_AUTHENTICATED_ANONYMOUSLY')",
 *              "validation_groups" = {"Default", "create"}
 *          }
 *      },
 *     itemOperations={
 *          "get" = {
 *              "security" = "is_granted('IS_AUTHENTICATED_ANONYMOUSLY')",
 *          },
 *          "put" = { "security" = "is_granted('ROLE_USER') and object === user" },
 *          "delete" = { "security" = "is_granted('ROLE_ADMIN')" }
 *      },
 *     normalizationContext={"groups"={"user:read"}},
 *     denormalizationContext={"groups"={"user:write"}},
 * )
 * @ApiFilter(PropertyFilter::class)
 * @UniqueEntity(fields={"username"})
 * @UniqueEntity(fields={"email"})
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"user:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"user:read", "user:write"})
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     * @Groups({"user:read", "admin:write"})
     */
    private array $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @Groups({"user:write"})
     * @SerializedName("password")
     * @Assert\NotBlank(groups={"create"})
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Groups({"user:read", "user:write"})
     * @Assert\NotBlank()
     */
    private $username;

    /**
     * Шеърҳои пахш карда
     *
     * @ORM\OneToMany(targetEntity=Poem::class, mappedBy="owner")
     * @Groups({"user:read", "user:write"})
     */
    private $poems;

    /**
     * "owner:read" - it's only example!
     * @ORM\Column(type="string", length=155, options={"comment":"Ном ва насаб"})
     * @Groups({"user:read", "owner:read", "user:write", "poem:read"})
     */
    private $name;

    public function __construct()
    {
        $this->poems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = RoleConstants::USER;

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPlainPassword(): ?string
    {
        return (string) $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
         $this->plainPassword = null;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return Collection|Poem[]
     */
    public function getPoems(): Collection
    {
        return $this->poems;
    }

    /**
     * @Groups({"user:read"})
     * @SerializedName("poems")
     */
    public function getPublishedPoems(): Collection
    {
        return $this->poems->filter(function (Poem $poem) {
            return $poem->getIsPublished();
        });
    }

    public function addPoem(Poem $poem): self
    {
        if (!$this->poems->contains($poem)) {
            $this->poems[] = $poem;
            $poem->setOwner($this);
        }

        return $this;
    }

    public function removePoem(Poem $poem): self
    {
        if ($this->poems->contains($poem)) {
            $this->poems->removeElement($poem);
            // set the owning side to null (unless already changed)
            if ($poem->getOwner() === $this) {
                $poem->setOwner(null);
            }
        }

        return $this;
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
}
