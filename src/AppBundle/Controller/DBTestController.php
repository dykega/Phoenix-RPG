<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\PhoenixUser;

class DBTestController extends Controller
{
    /**
     * @Route("/Test/DBTest/{action}")
     */
    public function showAction($action)
    {
        $templating = $this->container->get('templating');

        if ($action == "Load") {
            $userId = 1;
            $user = $this->getDoctrine()->getRepository('AppBundle:PhoenixUser')->find($userId);

            if (!$user) {
                throw $this->createNotFoundException('No user found for id '. $userId);
            }
        }
        elseif ($action == "Save") {
            $user = new PhoenixUser();
            $user->setName('Test User');

            $existingUser = $this->getDoctrine()->getRepository('AppBundle:PhoenixUser')->findOneByName('Test User');
            if ($existingUser == null) {
                $em = $this->getDoctrine()->getManager();

                // tells Doctrine you want to (eventually) save the object (no queries yet)
                $em->persist($user);

                // actually executes the queries (i.e. the INSERT query)
                $em->flush();
            }
            else {
                $user->setName("User already exists");
            }


        }
        $userId = $user->getId();
        $userName = $user->getName();
        $html = $templating->render('test/DBTest/DBTest.html.twig', ["userId"=>$userId,"userName"=>$userName]);

        return new Response($html);

    }
}
