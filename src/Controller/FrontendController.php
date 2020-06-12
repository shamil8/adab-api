<?php


namespace App\Controller;


use App\Service\UserService;
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
        $roles = $user ? $user->getRoles() : '';

        return $this->render('homepage.html.twig', [
            'user' => $serializer->serialize($user, 'jsonld'),
            'roles' => $roles
        ]);
    }

    /**
     * @Route("/user", methods={"POST"})
     */
    public function dataUser(UserService $userService) {
        $user = $userService->getCurrentUser();

        if ($user) {
            return $this->json([
                'id' => $user->getId(),
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'roles' => $user->getRoles(),
            ]);
        }

        return $this->json('Error');
    }
}
