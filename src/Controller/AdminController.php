<?php

namespace App\Controller;

use App\Entity\Medecin;
use App\Entity\Service;
use App\Entity\Specialite;
use App\Form\MedecinFormType;
use App\Form\ServiceFormType;
use App\Form\SpecialiteFormType;
use App\Controller\AdminController;
use App\Repository\MedecinRepository;
use App\Repository\ServiceRepository;
use App\Repository\SpecialiteRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class AdminController extends AbstractController
{
    public function Medecin(ValidatorInterface $validator)
{
    $Medecin = new Medecin();

    // ... do something to the $Medecin object

    $errors = $validator->validate($Medecin);

    if (count($errors) > 0) {
        /*
         * Uses a __toString method on the $errors variable which is a
         * ConstraintViolationList object. This gives us a nice string
         * for debugging.
         */
        $errorsString = (string) $errors;

        return new Response($errorsString);
    }

    return new Response('The Medecin is valid! Yes!');
}
    public function getLastMedecin(){
 
        $ripo = $this->getDoctrine()->getRepository(Medecin::class);
        $MedecinLast = $ripo->findBy([], ['id'=>'DESC']);
        if($MedecinLast == null){
            return $id = 0;
        }
        else
        {
            return $MedecinLast[0]->getId();
        }
        
    }
   
    /**
     * @Route("/admin", name="admin.medecin.show")
     */
    public function ShowMedecin(MedecinRepository $ripo)
    {
        $Medecins = $ripo->findAll();
        return $this->render('admin/index.html.twig', [
            'Medecins' => $Medecins,
        ]);
    }
    /**
     * @Route("/admin/medecin/", name="admin.medecin.add")
     */
    public function AddMedecin(MedecinRepository $ripo, Request $request)
    {
        $Medecin = new Medecin();
       $idMatricule = $this->getLastMedecin() + 1;
        if(!$Medecin)
        {
            $Medecin = new Medecin();
        }
    $form = $this->createForm(MedecinFormType::class, $Medecin);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        $deuxPremierLettre=strtoupper(substr($Medecin->getService()->getLibelle(), 0,2));
        $longId = strlen((string)$idMatricule);
        // la longueur total du matricule = 8 ex=MOP0001
        $matricule = \str_pad("M".$deuxPremierLettre,8 - $longId,"0").$idMatricule;
        $Medecin->setMatricule($matricule);

      
         $entityManager = $this->getDoctrine()->getManager();
         $entityManager->persist($Medecin);
         $entityManager->flush();

        return $this->redirectToRoute('admin.medecin.add');
    }

    return $this->render('admin/new.html.twig', [
        'form' => $form->createView(),
    ]);
    }
    /**
     * @Route("/admin/medecin/edit/{id}", name="admin.medecin.edit")
     */
    public function EditMedecin($id, MedecinRepository $ripo, Request $request)
    {
        // just setup a fresh $task object (remove the example data)
    $Medecin = $ripo->find($id);

    $form = $this->createForm(MedecinFormType::class, $Medecin);

    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        // $form->getData() holds the submitted values
        // but, the original `$task` variable has also been updated
        

        // ... perform some action, such as saving the task to the database
        // for example, if Task is a Doctrine entity, save it!
         $entityManager = $this->getDoctrine()->getManager();
         $entityManager->persist($Medecin);
         $entityManager->flush();

        return $this->redirectToRoute('admin.medecin.show');
    }

    return $this->render('admin/new.html.twig', [
        'form' => $form->createView(),
    ]);
    }
    /**
     * @Route("/admin/medecin/delete/{id}", name="admin.medecin.delete")
     */
    public function DeleteMedecin($id, MedecinRepository $ripo, Request $request)
    {
        // just setup a fresh $task object (remove the example data)
        $Medecin = $ripo->find($id);

   
        // ... perform some action, such as saving the task to the database
        // for example, if Task is a Doctrine entity, save it!
         $entityManager = $this->getDoctrine()->getManager();
         $entityManager->remove($Medecin);
         $entityManager->flush();

        return $this->redirectToRoute('admin.medecin.show');

    }
    /**
     * @Route("/admin/service/addshow", name="admin.service.add")
     */
    public function AddService(ServiceRepository $ripo, Request $request)
    {
         // just setup a fresh $task object (remove the example data)
    $Service = new Service();

    $form = $this->createForm(ServiceFormType::class, $Service);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        // $form->getData() holds the submitted values
        // but, the original `$task` variable has also been updated
        

        // ... perform some action, such as saving the task to the database
        // for example, if Task is a Doctrine entity, save it!
         $entityManager = $this->getDoctrine()->getManager();
         $entityManager->persist($Service);
         $entityManager->flush();

        return $this->redirectToRoute('admin.service.add');
    }

    return $this->render('admin/addshow.html.twig', [
        'form' => $form->createView(),
    ]);
    }
    /**
     * @Route("/admin/service/addshow/show", name="admin.service.show")
     */
    public function ShowService(ServiceRepository $ripo)
    {
        $Services = $ripo->findAll();
        return $this->render('admin/show.html.twig', [
            'Services' => $Services,
        ]);
    }
    /**
     * @Route("/admin/service/edit/{id}", name="admin.service.edit")
     */
    public function EditService($id, ServiceRepository $ripo, Request $request)
    {
        // just setup a fresh $task object (remove the example data)
    $Service = $ripo->find($id);

    $form = $this->createForm(ServiceFormType::class, $Service);

    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        // $form->getData() holds the submitted values
        // but, the original `$task` variable has also been updated
        

        // ... perform some action, such as saving the task to the database
        // for example, if Task is a Doctrine entity, save it!
         $entityManager = $this->getDoctrine()->getManager();
         $entityManager->persist($Service);
         $entityManager->flush();

        return $this->redirectToRoute('admin.service.show');
    }

    return $this->render('admin/addshow.html.twig', [
        'form' => $form->createView(),
    ]);
    }
    /**
     * @Route("/admin/service/delete/{id}", name="admin.service.delete")
     */
    public function DeleteService($id, ServiceRepository $ripo, Request $request)
    {
        // just setup a fresh $task object (remove the example data)
    $Service = $ripo->find($id);

        // ... perform some action, such as saving the task to the database
        // for example, if Task is a Doctrine entity, save it!
         $entityManager = $this->getDoctrine()->getManager();
         $entityManager->remove($Service);
         $entityManager->flush();

        return $this->redirectToRoute('admin.service.show');
    
    }
    
    /**
     * @Route("/", name="home")
       */
    public function home()
    {
        return $this->render('admin/home.html.twig');
    }

    /**
         * @Route("/admin/specialite/add", name="admin.specialite.add")
         */
        public function AddSpecialite(SpecialiteRepository $ripo, Request $request)
        {
            // just setup a fresh $task object (remove the example data)
        $Specialite = new Specialite();

        $form = $this->createForm(SpecialiteFormType::class, $Specialite);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($Specialite);
            $entityManager->flush();

            return $this->redirectToRoute('admin.specialite.add');
        }

        return $this->render('admin/addspecialite.html.twig', [
            'form' => $form->createView(),
        ]);
        }
        /**
     * @Route("/admin/specialite/add/show", name="admin.specialite.show")
     */
    public function ShowSpecialite(SpecialiteRepository $ripo)
    {
        $Specialites = $ripo->findAll();
        return $this->render('admin/showspecialite.html.twig', [
            'Specialites' => $Specialites,
        ]);
    }
    /**
     * @Route("/admin/specialite/edit/{id}", name="admin.specialite.edit")
     */
    public function EditSpecialite($id, SpecialiteRepository $ripo, Request $request)
    {
        // just setup a fresh $task object (remove the example data)
    $Specialite = $ripo->find($id);

    $form = $this->createForm(SpecialiteFormType::class, $Specialite);

    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        // $form->getData() holds the submitted values
        // but, the original `$task` variable has also been updated
        

        // ... perform some action, such as saving the task to the database
        // for example, if Task is a Doctrine entity, save it!
         $entityManager = $this->getDoctrine()->getManager();
         $entityManager->persist($Specialite);
         $entityManager->flush();

        return $this->redirectToRoute('admin.specialite.show');
    }

    return $this->render('admin/addspecialite.html.twig', [
        'form' => $form->createView(),
    ]);
    }
    /**
     * @Route("/admin/specialite/delete/{id}", name="admin.specialite.delete")
     */
    public function DeleteSpecialite($id, SpecialiteRepository $ripo, Request $request)
    {
        // just setup a fresh $task object (remove the example data)
    $Specialite = $ripo->find($id);

        // ... perform some action, such as saving the task to the database
        // for example, if Task is a Doctrine entity, save it!
         $entityManager = $this->getDoctrine()->getManager();
         $entityManager->remove($Specialite);
         $entityManager->flush();

        return $this->redirectToRoute('admin.specialite.show');
    }

     
}
