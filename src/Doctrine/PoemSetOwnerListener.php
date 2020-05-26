<?php


namespace App\Doctrine;


use App\Entity\Poem;
use Symfony\Component\Security\Core\Security;

class PoemSetOwnerListener
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function prePersist(Poem $poem)
    {
        if($poem->getOwner()) {
            return;
        }

        if ($this->security->getUser()) {
            $poem->setOwner($this->security->getUser());
        }
    }
}
