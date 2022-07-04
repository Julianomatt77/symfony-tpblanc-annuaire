<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{


    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    #[Route('/', name: 'default')]
//    #[IsGranted('ROLE_USER')]
    public function index(): Response
    {
        $users = $this->userRepository->findAll();

        return $this->render('default/index.html.twig', [
            'users' => $users,
        ]);
    }
}
