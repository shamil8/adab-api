<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class FrontendController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function homepage(SerializerInterface $serializer)
    {
        $user = $this->getUser();
        $role = $user ? $user->getRoles()[0] : '';

        return $this->render('homepage.html.twig', [
            'user' => $serializer->serialize($user, 'jsonld'),
            'role' => $role
        ]);
    }
}
