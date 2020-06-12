<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    /**
     * @Route("/logout", name="app_logout", methods={"GET", "POST"})
     */
    public function logout() {
        throw new \Exception('should not me reached');
    }
}
