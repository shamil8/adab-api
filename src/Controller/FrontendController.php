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

    /**
     * @Route("/api/user", name="app_user", methods={"POST"})
     */
    public function dataUser() {
        $user = $this->getUser();

        if ($user) {
            return $this->json([
                'id' => $user->getId(),
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'role' => $user->getRoles()[0],
            ]);
        }

        return $this->json('Error');
    }
}
