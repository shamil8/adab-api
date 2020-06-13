<?php


namespace App\Service;


use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Authentication\Token\JWTUserToken;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class UserService
{
    /** @var  JWTTokenManagerInterface */
    private $JWTTokenManager;

    /**
     * @param JWTTokenManagerInterface  $JWTTokenManager
     */
    public function __construct(JWTTokenManagerInterface $JWTTokenManager)
    {
        $this->JWTTokenManager  = $JWTTokenManager;
    }

    /**
     * @param string $token
     * @return array
     */
    public function decodeToken(string $token) : array
    {
        $jwtToken = new JWTUserToken();
        $jwtToken->setRawToken($token);

        return $this->JWTTokenManager->decode($jwtToken);
    }

}
