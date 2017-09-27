<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;
use AppBundle\Form\UserType;    



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
        $form = $this->createForm(UserType::class, $user);
    
        // $form->handleRequest($request);
        
        //     if ($form->isSubmitted() && $form->isValid()) {
        //          // $file stores the uploaded PDF file
        //         /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
        //         // echo "<pre>";
        //         // print_r($user);
        //         // die();
                
        //        $user = $this->getAvatarimg();

        //         // Generate a unique name for the file before saving it
        //         $fileName = md5(uniqid()).'.'.$user->guessExtension();
            
        //         //Move the file to the directory where brochures are stored
        //         $user->move($this->getParameter('uploads_directory'), $fileName);
            
        //         // Update the 'brochure' property to store the PDF file name
        //         // instead of its contents
        //         $user->setAvatarimg($fileName);
            
        //         $em = $this->getDoctrine()->getManager();
        //         $em->persist($user);
        //         $em->flush();
            
        //         return $this->redirectToRoute('homepage');
        //     }
            

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
        
        // $form = $this->createFormBuilder($user)
        //     ->add('nom', TextType::class)
        //     ->add('prenom', TextType::class)
        //     ->add('age', TextType::class)
        //     ->add('save', SubmitType::class, array('label' => "Modifier l'utilisateur"))
        //     ->getForm();
      $form = $this->createForm(UserType::class, $user);
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

     /**
     * @Route("/upload", name="upload_file")
     *
     */
     public function uploadAction(Request $request)
     {
        
       $user = null; 
      $form = $this->createForm(UploadType::class, $user);
      $form->handleRequest($request);
      
              if ($form->isSubmitted() && $form->isValid()) {
                  // $file stores the uploaded PDF file
                  /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
                  //$file = $product->getBrochure();
      
                  // Generate a unique name for the file before saving it
                //   $fileName = md5(uniqid()).''.$file->guessExtension();
                  $fileName = md5(uniqid()).'.BIN';
      
                  // Move the file to the directory where brochures are stored
                  $file->move(
                      $this->getParameter('uploads_directory'),
                      $fileName
                  );
      
                  // Update the 'brochure' property to store the PDF file name
                  // instead of its contents
                 // $product->setBrochure($fileName);
      
                  // ... persist the $product variable or any other work
      
                  return $this->redirectToRoute('homepage');
              }
      
              return $this->render('default/upload.html.twig', array(
                  'form' => $form->createView(),
              ));
   

     }


    /**
     * @Route("/generatePdf", name="generatePdf")
     *
     */
     public function generatePdfAction(Request $request)
     {
        $this->get('knp_snappy.pdf')->generate('http://www.google.fr', 'uploads/file.pdf');

            
            return $this->render('default/info.html.twig', array(
                'message' => 'message' ,
     ));
     }
}
