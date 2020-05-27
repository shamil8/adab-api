<?php


namespace App\Controller;


use ApiPlatform\Core\Api\IriConverterInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login", methods={"POST"})
     */
    public function login(IriConverterInterface $iriConverter)
    {
        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->json([
               'error' => "Invalid login request: check that the Content-Type"
            ]);
        }
        return new Response(null, 204, [
            'Location' => $iriConverter->getIriFromItem($this->getUser())
        ]);
    }

    /**
     * @Route("/logout", name="app_logout", methods={"GET", "POST"})
     */
    public function logout() {
        throw new \Exception('should not me reached');
    }
}
