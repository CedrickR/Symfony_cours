<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;

// Pour la création des formulaires
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * 
     */
    public function indexAction(Request $request)
    {
        // // replace this example code with whatever you need
        // return $this->render('default/liste.html.twig', array(
        //     'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        // ));
        return $this->redirectToRoute('liste');
    }

    /**
     * @Route("/nouveau/{nom}/{prenom}/{age}", name="nouveau")
     *
     */
    public function nouveauAction(Request $request, $nom, $prenom, $age)
    {
         // replace this example code with whatever you need
        //  $em = $this->getDoctrine()->getManager();
        //  $user = new User();
        //  $user->setNom($nom);
        //  $user->setPrenom($prenom);
        //  $user->setAge($age);
        //  $em->persist($user);
        //  $em->flush();
        //  return $this->render('default/index.html.twig', array(
        //     'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        // ));

    }
    /**
     * @Route("/ajouter", name="ajouter")
     *
     */
    public function ajouterAction(Request $request)
    {

            
        $user = new User();
        $form = $this->createFormBuilder($user)
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('age', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Créer un utilisateur'))
            ->getForm();


        $form->handleRequest($request);
        
            if ($form->isSubmitted() && $form->isValid()) {
                // $form->getData() holds the submitted values
                // but, the original `$task` variable has also been updated
                $user = $form->getData();
        
                // ... perform some action, such as saving the task to the database
                // for example, if Task is a Doctrine entity, save it!
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
        
                return $this->redirectToRoute('homepage');
            }
            

        return $this->render('default/ajouter.html.twig', array('form' => $form->createView()
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

        
         return $this->render('default/liste.html.twig', array(
             'utilisateurs' => $utilisateurs ,
         ));
     }

    /**
     * @Route("/detail/{id}", name="detail")
     *
     */
     public function detailAction(Request $request, $id)
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
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()
        ->getRepository('AppBundle:User');

            $utilisateur = $repository->find($id);
        $em->remove($utilisateur);
        $em->flush();
            
            return $this->render('default/info.html.twig', array(
                'message' => "L'utilisateur a été supprimé de la table." ,
     ));
     }
    
     /**
     * @Route("/modifier/{id}", name="modifier")
     *
     */
     public function modifierAction(Request $request, $id)
     {
        
        $repository = $this->getDoctrine()->getRepository("AppBundle:User");
        $user = $repository->find($id);
        
        $form = $this->createFormBuilder($user)
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('age', TextType::class)
            ->add('save', SubmitType::class, array('label' => "Modifier l'utilisateur"))
            ->getForm();


      $form->handleRequest($request);
        
            if ($form->isSubmitted() && $form->isValid()) {
                $user = $form->getData();
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
        
                return $this->redirectToRoute('homepage');
            }
   
    
        return $this->render(
            'default/ajouter.html.twig', 
            array(
                'message' => "L'utilisateur a été modifié de la table." ,
                'form' => $form->createView()
            ));
     }


}
