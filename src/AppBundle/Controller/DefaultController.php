<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * 
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ));
    }

    /**
     * @Route("/nouveau/{nom}/{prenom}/{age}", name="nouveau")
     *
     */
    public function nouveauAction(Request $request, $nom, $prenom, $age)
    {
         // replace this example code with whatever you need
         $em = $this->getDoctrine()->getManager();
         $user = new User();
         $user->setNom($nom);
         $user->setPrenom($prenom);
         $user->setAge($age);
         $em->persist($user);
         $em->flush();
         return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ));
            
    }


     /**
     * @Route("/liste", name="liste")
     *
     */
     public function listeAction(Request $request)
     {

        $repository = $this->getDoctrine()
            ->getRepository('AppBundle:User');

         $utilisateurs = $repository->findAll();
         //$utilisateurs = $repository->findByAge('Cedrick');
        
         return $this->render('default/liste.html.twig', array(
             'utilisateurs' => $utilisateurs ,
         ));
     }

    /**
     * @Route("/utilisateur/{id}", name="utilisateur")
     *
     */
     public function utilisateurAction(Request $request, $id)
     {
        $repository = $this->getDoctrine()
        ->getRepository('AppBundle:User');

            $utilisateur = $repository->find($id);

            
            return $this->render('default/detail.html.twig', array(
                'utilisateur' => $utilisateur ,
     ));
     }

         /**
     * @Route("/supprimer/{id}", name="supprimer")
     *
     */
     public function supprimerAction(Request $request, $id)
     {
        $repository = $this->getDoctrine()
        ->getRepository('AppBundle:User');

            $utilisateur = $repository->find($id);

            
            return $this->render('default/detail.html.twig', array(
                'utilisateur' => $utilisateur ,
     ));
     }


}
