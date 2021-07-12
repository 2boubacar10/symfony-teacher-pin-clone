<?php

namespace App\Controller;

use App\Entity\Pin;
use App\Repository\PinRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class PinsController extends AbstractController
{
    private $entity_manager;

    public function __construct(EntityManagerInterface $em)
    {
        $this->entity_manager = $em;
    }


    /**
     * @Route("/", name="accueil")
     */
    public function index(PinRepository $repo): Response
    {
        $pins = $repo->findAll();
        return $this->render("pins/index.html.twig", compact('pins'));
    }

    /**
     * @Route("/pins/create", name="create_pin", methods="GET|POST")
     */

    public function create(Request $request){

        if($request->isMethod("POST")){
            
            $title = $request->request->get('title');
            $description = $request->request->get('description');

            $pin = new Pin();
            $pin->setTitle($title);
            $pin->setDescription($description);
            $this->entity_manager->persist($pin);
            $this->entity_manager->flush();

            //return $this->redirect("/");
            return $this->redirectToRoute("accueil");
        }
        return $this->render("pins/create.html.twig");
    }

    /**
     * @Route("/index", name="accueil2")
     */
    public function liste_pin(): Response
    {
        $repo = $this->entity_manager->getRepository(Pin::class);
        $pins = $repo->findAll();


       return $this->render("pins/index.html.twig", compact('pins'));

        return $this->render("pins/index.html.twig", [
            "controller_name" => "Boubacar",
            "pins" => $pins
        ]);
    }

    /**
     * @Route("/pins", name="pins")
     * @Route("/create_pin", name="boubs")
     */
    public function create_pin(): Response
    {
        $pin = new Pin();

        $pin->setTitle("Titre 3");
        $pin->setDescription("Description 3");

        //$entity_manager = $this->getDoctrine()->getManager();

        $this->entity_manager->persist($pin);
        $this->entity_manager->flush();

        dump($pin);

        return $this->render('pins/index.html.twig', [
            'controller_name' => "PinsController",
        ]);
        return new Response("salut");
        return $this->json([
            'message' => "salut"
        ]);
        return $this->render('pins/index.html.twig', [
            'controller_name' => 'PinsController',
        ]);
    }
}
