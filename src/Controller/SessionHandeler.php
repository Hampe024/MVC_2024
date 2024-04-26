<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SessionHandeler extends AbstractController
{
    #[Route("/session", name: "session")]
    public function session(
        SessionInterface $session
    ): Response
    {
        $data = [
            "sessionData" => $session->all()
        ];


        $session->set("test", $session->get("test") + 1);
        return $this->render('misc/session.html.twig', $data);
    }
    #[Route("/session/delete", name: "sessionDelete")]
    public function sessionDelete(
        SessionInterface $session
    ): Response
    {
        $session->clear();

        $this->addFlash(
            'notice',
            'Your session was deleted!'
        );
        
        return $this->redirectToRoute('session');
    }
}


