<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Report extends AbstractController
{
    #[Route("/", name: "aboutMe")]
    public function aboutMe(): Response
    {
        return $this->render('report/me.html.twig');
    }
    #[Route("/about", name: "about")]
    public function about(): Response
    {
        return $this->render('report/about.html.twig');
    }
    #[Route("/report", name: "report")]
    public function report(): Response
    {
        return $this->render('report/report.html.twig');
    }
}
