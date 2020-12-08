<?php


namespace App\Controller;


use App\Entity\User;
use App\Service\UserService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class FrontendController extends AbstractController
{
    /**
     * @Route("/some")
     * @return Response
     */
    public function someAction(): Response
    {
        return new Response('Hello world');
    }

    /**
     * @Route("/")
     * @param SerializerInterface $serializer
     * @return Response
     */
    public function homepage(SerializerInterface $serializer) : Response
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
     * @param Request $req
     * @param UserService $userService
     * @return JsonResponse
     */
    public function dataUser(Request $req, UserService $userService) : JsonResponse
    {
        $data = $req->getContent();
        $data = json_decode($data, true);

        $tokenUser = $userService->decodeToken($data['token']);

        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['email' => $tokenUser['email']]);

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
