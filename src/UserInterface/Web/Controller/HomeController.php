<?php
declare(strict_types=1);

namespace App\UserInterface\Web\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HomeController
 * @package App\UserInterface\Web\Controller
 */
class HomeController extends AbstractController
{
    /**
     * @return Response
     * @Route("/", methods={"GET"})
     */
    public function home(): Response
    {
        return new Response('');
    }
}
