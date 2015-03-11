<?php

namespace Iut\AncienEtudiantBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Iut\AncienEtudiantBundle\Entity\Etudiant;
use Iut\AncienEtudiantBundle\Entity\Formation;
use Iut\AncienEtudiantBundle\Entity\Experience;
use Iut\AncienEtudiantBundle\Entity\Poste;
use Iut\AncienEtudiantBundle\Entity\Promotion;



class AncienEtudiantController extends Controller

{
    public function indexAction()
    {
        $repository = $this->getDoctrine()
                            ->getManager()
                            ->getRepository('IutAncienEtudiantBundle:Etudiant');
       
        $etudiants= $repository->getListe();
        
        return $this->render('IutAncienEtudiantBundle:AncienEtudiant:index.html.twig',array('etudiants'=>$etudiants));
    }
        
    public function ajouterAction()
    {
            $em = $this->getDoctrine()->getManager();
          
            $PromotionRepository=$em->getRepository('IutAncienEtudiantBundle:Promotion');
            $promotions=$PromotionRepository->findAll();
                    
            
            $error_email="";
          if(isset($_POST['email'])){
            $EtudiantRepository=$em->getRepository('IutAncienEtudiantBundle:Etudiant');
            $student=$EtudiantRepository->findOneBy(array('email'=>$_POST['email']));
           
            
            if($student==null){
               
                $etudiant= new Etudiant();
                $etudiant->setNom($_POST['nom']);
                $etudiant->setPrenom($_POST['prenom']);
                $etudiant->setEmail($_POST['email'])  ; 
                $etudiant->setPromotion($PromotionRepository->find($_POST['promotion']));
                $etudiant->setDateModif(new \Datetime());
                // On enregistre l'objet $etudiant dans la base de données

               $em->persist($etudiant);
               $em->flush();
               return $this->redirect($this->generateUrl('profil_etudiant',array('id'=>$etudiant->getId())));
   
            }
            $error_email="Cette adresse email existe déja";
            return $this->render('IutAncienEtudiantBundle:AncienEtudiant:addUpdateEtudiant.html.twig',array('action'=>$this->generateUrl('ajouter_etudiant'),'promotions'=>$promotions,'email_error'=>$error_email));

         }   
         return $this->render('IutAncienEtudiantBundle:AncienEtudiant:addUpdateEtudiant.html.twig',array('action'=>$this->generateUrl('ajouter_etudiant'),'promotions'=>$promotions,'email_error'=>$error_email));
    }
    public function modifierAction($id)
    {
        $em = $this->getDoctrine()
                   ->getManager();
          
       $PromotionRepository=$em->getRepository('IutAncienEtudiantBundle:Promotion');
       $request = $this->getRequest();
       $EtudiantRepository = $em->getRepository('IutAncienEtudiantBundle:Etudiant');
       $promotions=$PromotionRepository->findAll();
       $etudiant= $EtudiantRepository->find($id);
       $error_email="";
        if ($request->getMethod() == 'POST') {
            
            $etudiant->setNom($_POST['nom']);
            $etudiant->setPrenom($_POST['prenom']);
            $etudiant->setEmail($_POST['email'])  ; 
            $etudiant->setPromotion($PromotionRepository->find($_POST['promotion']));
            $etudiant->setDateModif(new \Datetime());
            
           $em->persist($etudiant);
           $em->flush();
           return $this->redirect($this->generateUrl('profil_etudiant',array('id'=>$etudiant->getId())));
   
        }
        return $this->render('IutAncienEtudiantBundle:AncienEtudiant:addUpdateEtudiant.html.twig',array('action'=>$this->generateUrl('modifier_etudiant',array('id' => $etudiant->getId())),'etudiant'=>$etudiant,'promotions'=>$promotions,'email_error'=>$error_email));

    }
    
    public function supprimerAction()
    {
      
        $request = $this->container->get('request'); 
        $id=$request->request->get('id');
 
        $repository = $this->getDoctrine()
                            ->getManager()
                            ->getRepository('IutAncienEtudiantBundle:Etudiant');
       
        $etudiant= $repository->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($etudiant);
        $em->flush();      
        $response = new Response;
        $response->setContent('ok');
        return $response;
       
    }
    
    public function profilAction($id)
    {
          $em = $this->getDoctrine()
                            ->getManager();
          $EtudiantRepository=$em->getRepository('IutAncienEtudiantBundle:Etudiant');
          $PosteRepository=$em->getRepository('IutAncienEtudiantBundle:Poste');
          $postes=$PosteRepository->findAll();
          $etudiant= $EtudiantRepository->find($id);
        
          if($etudiant!=null)
            return $this->render('IutAncienEtudiantBundle:AncienEtudiant:profil.html.twig',array('etudiant' => $etudiant,'postes'=>$postes));
          else return $this->redirect ($this->generateUrl('ajouter_etudiant'));
    }
    
    
    public function ajouterExperienceAction()
    {
       $em = $this->getDoctrine()->getManager();
       $etudiantRepository=$em->getRepository('IutAncienEtudiantBundle:Etudiant');
       $posteRepository=$em->getRepository('IutAncienEtudiantBundle:Poste');
       $poste=$posteRepository->find($_POST['poste']);
       
       $etudiant= $etudiantRepository->find($_POST['idE']);
       $etudiant->setDateModif(new \Datetime());
       $experience=new Experience;
       $experience->setCompetences($_POST['competences']);
       $experience->setEntreprise($_POST['entreprise']);
       $experience->setDateDebut(new \Datetime($_POST['dateDE']));
       $experience->setDateFin(new \Datetime($_POST['dateFE']));
       $experience->setDescription($_POST['descrip-tache']);
       $experience->setPoste($poste);
       $experience->setEtudiant($etudiant);
       
       $em->persist($experience);
       $em->flush();
       
       return $this->redirect($this->generateUrl('profil_etudiant',array('id'=>$etudiant->getId())));
   
       
    }
    
    public function modifierExperienceAction($id)
    {
              
       $em = $this->getDoctrine()->getManager();
       $idetudiant=$_POST['idE'];
       $ExperienceRepository=$em->getRepository('IutAncienEtudiantBundle:Experience');
       $EtudiantRepository=$em->getRepository('IutAncienEtudiantBundle:Etudiant');
       $posteRepository=$em->getRepository('IutAncienEtudiantBundle:Poste');
       
       $poste=$posteRepository->find($_POST['poste']);
       $experience= $ExperienceRepository->find($id);
       $etudiant=$EtudiantRepository->find($idetudiant);
       
       $etudiant->setDateModif(new \Datetime());
       $experience->setCompetences($_POST['competences']);
       $experience->setEntreprise($_POST['entreprise']);
       $experience->setDateDebut(new \Datetime($_POST['dateDE']));
       $experience->setDateFin(new \Datetime($_POST['dateFE']));
       $experience->setDescription($_POST['descrip-tache']);
       $experience->setPoste($poste);
       $experience->setEtudiant($etudiant);
      
       $em->persist($experience);
       $em->flush();
       
       return $this->redirect($this->generateUrl('profil_etudiant',array('id'=>$idetudiant)));
       }
    public function supprimerExperienceAction()
    {
        
        $id=$_POST['id'];
        $em = $this->getDoctrine()->getManager();
        $repository =$em->getRepository('IutAncienEtudiantBundle:Experience');
       
        $experience = $repository->find($id);
        
        $em->remove($experience);
        $em->flush();      
        
        return new Response('ok');
    }
    
     public function getExperienceAction()
    {
          $id=$_POST['id'];
          $repository = $this->getDoctrine()
                            ->getManager()
                            ->getRepository('IutAncienEtudiantBundle:Experience');
       
          $experience= $repository->getById($id);
          $response = new Response;
          $response->setContent(json_encode($experience));
          return $response;
    }
    
    
    public function ajouterFormationAction()
    {
       $repository = $this->getDoctrine()
                            ->getManager()
                            ->getRepository('IutAncienEtudiantBundle:Etudiant');
       
       $etudiant= $repository->find($_POST['idE']);
       $etudiant->setDateModif(new \Datetime());
       $formation=new Formation;
       $formation->setIntitule($_POST['intitule']);
       $formation->setUniversite($_POST['ecole']);
       $formation->setDateDebut(new \Datetime($_POST['dateDF']));
       $formation->setDateFin(new \Datetime($_POST['dateFF']));
       $formation->setDescription($_POST['descrip-form']);
       $formation->setEtudiant($etudiant);
       
       $em = $this->getDoctrine()->getManager();
       $em->persist($formation);
       $em->flush();
       
       return $this->redirect($this->generateUrl('profil_etudiant',array('id'=>$etudiant->getId())));
   
       
    }
    
    public function modifierFormationAction($id)
    {
              
       $em = $this->getDoctrine()->getManager();
       $idetudiant=$_POST['idE'];
       $FormationRepository=$em->getRepository('IutAncienEtudiantBundle:Formation');
       $EtudiantRepository=$em->getRepository('IutAncienEtudiantBundle:Etudiant');
       $formation= $FormationRepository->find($id);
       $etudiant=$EtudiantRepository->find($idetudiant);
       $etudiant->setDateModif(new \Datetime());
       $formation->setIntitule($_POST['intitule']);
       $formation->setUniversite($_POST['ecole']);
       $formation->setDateDebut(new \Datetime($_POST['dateDF']));
       $formation->setDateFin(new \Datetime($_POST['dateFF']));
       $formation->setDescription($_POST['descrip-form']);
       
       $em->persist($formation);
       $em->flush();
       
       return $this->redirect($this->generateUrl('profil_etudiant',array('id'=>$idetudiant)));
       }
       
    
    public function supprimerFormationAction()
    {
        
        $id=$_POST['id'];
 
        $repository = $this->getDoctrine()
                            ->getManager()
                            ->getRepository('IutAncienEtudiantBundle:Formation');
       
        $formation = $repository->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($formation);
        $em->flush();      
        
        return new Response('ok');
    }
    
     public function getFormationAction()
    {
          $id=$_POST['id'];
          $repository = $this->getDoctrine()
                            ->getManager()
                            ->getRepository('IutAncienEtudiantBundle:Formation');
       
          $formation= $repository->getById($id);
          $response = new Response;
          $response->setContent(json_encode($formation));
          return $response;
    }
    
    public function PosteAction()
    {
       $repository = $this->getDoctrine()
                                ->getManager()
                                ->getRepository('IutAncienEtudiantBundle:Poste');

        $postes = $repository->findAll();
        return $this->render('IutAncienEtudiantBundle:AncienEtudiant:poste.html.twig',array('postes'=>$postes));
   
    }
    public function ajouterPosteAction()
    {
        if(isset($_POST['titre']) and $_POST['titre']!=''){
            $titre=$_POST['titre'];
            $poste=new Poste;
            $poste->setPoste($titre);
            $em = $this->getDoctrine()->getManager();
            $em->persist($poste);
            $em->flush();   
        }
       return $this->redirect($this->generateUrl('poste'));
       }
    
    public function modifierPosteAction()
    {
        if(isset($_POST['id']) and $_POST['id']!=''){
            $titre=$_POST['titre'];
            $em = $this->getDoctrine()->getManager();
            $id=$_POST['id'];
            $PosteRepository=$em->getRepository('IutAncienEtudiantBundle:Poste');
            $poste=$PosteRepository->find($id);
            $poste->setPoste($titre);
            
            $em->persist($poste);
            $em->flush();   
        }
       return $this->redirect($this->generateUrl('poste'));
    }
    public function supprimerPosteAction()
    {
        if(isset($_POST['id']) and $_POST['id']!=''){
            $id=$_POST['id'];
 
            $repository = $this->getDoctrine()
                                ->getManager()
                                ->getRepository('IutAncienEtudiantBundle:Poste');

            $poste = $repository->find($id);
            $em = $this->getDoctrine()->getManager();
            $em->remove($poste);
            $em->flush();      

            return new Response('ok');
        }
      
    }
    public function PromotionAction()
    {
        $repository = $this->getDoctrine()
                                ->getManager()
                                ->getRepository('IutAncienEtudiantBundle:Promotion');

        $promotions = $repository->findAll();
        return $this->render('IutAncienEtudiantBundle:AncienEtudiant:promotion.html.twig',array('promotions'=>$promotions));
    }
     public function ajouterPromotionAction()
    {
        if(isset($_POST['promo']) and $_POST['promo']!=''){
            $annee=$_POST['promo'];
            
            $an=strtotime("01-01-".$annee); 
            $promotion=new Promotion;
            $promotion->setAnnee($an);
            $em = $this->getDoctrine()->getManager();
            $em->persist($promotion);
            $em->flush();   
        }
       return $this->redirect($this->generateUrl('promotion'));
       }
    
    public function modifierPromotionAction()
    {
        if(isset($_POST['id']) and $_POST['id']!=''){
            $annee=$_POST['promo'];
            
            $an=strtotime("01-01-".$annee); 
            $em = $this->getDoctrine()->getManager();
            $id=$_POST['id'];
            $PromotionRepository=$em->getRepository('IutAncienEtudiantBundle:Promotion');
            $promotion=$PromotionRepository->find($id);
            $promotion->setAnnee($an);
            
            $em->persist($promotion);
            $em->flush();   
        }
       return $this->redirect($this->generateUrl('promotion'));
    }
    public function supprimerPromotionAction()
    {
        if(isset($_POST['id']) and $_POST['id']!=''){
            $id=$_POST['id'];
 
            $repository = $this->getDoctrine()
                                ->getManager()
                                ->getRepository('IutAncienEtudiantBundle:Promotion');

            $promotion = $repository->find($id);
            $em = $this->getDoctrine()->getManager();
            $em->remove($promotion);
            $em->flush();      

            return new Response('ok');
        }
    }   
   public function getPosteAction(){
          $id=$_POST['id'];
          $repository = $this->getDoctrine()
                            ->getManager()
                            ->getRepository('IutAncienEtudiantBundle:Poste');
       
          $poste= $repository->getById($id);
          $response = new Response;
          $response->setContent(json_encode($poste));
          return $response;
    }
    
     public function getPromotionAction()
    {
          $id=$_POST['id'];
          $repository = $this->getDoctrine()
                            ->getManager()
                            ->getRepository('IutAncienEtudiantBundle:Promotion');
       
          $promotion= $repository->getById($id);
          $response = new Response;
          $response->setContent(json_encode($promotion));
          return $response;
    }
    
    public function EtudiantPasMajAction(){
         $repository = $this->getDoctrine()
                            ->getManager()
                            ->getRepository('IutAncienEtudiantBundle:Etudiant');
        
         $etudiants=$repository->getListeEnvoiEmail();
         return $this->render('IutAncienEtudiantBundle:AncienEtudiant:envoi_email.html.twig',array('etudiants'=>$etudiants));

    }
    
     public function EnvoyermailAction(){
         $repository = $this->getDoctrine()
                            ->getManager()
                            ->getRepository('IutAncienEtudiantBundle:Etudiant');
        
         $etudiants=$repository->getListeEnvoiEmail();
        
         foreach ($etudiants as  $etudiant){
         $message = \Swift_Message::newInstance()
                    ->setSubject('Email de rappel ')
                    ->setFrom('admin@test.com')
                    ->setTo($etudiant->getEmail())
                    ->setBody($this->renderView('IutAncienEtudiantBundle:AncienEtudiant:email.txt.twig', array('etudiant' => $etudiant)));
         $this->get('mailer')->send($message);
         }
    
        return $this->render('IutAncienEtudiantBundle:AncienEtudiant:envoi_email.html.twig',array('etudiants'=>$etudiants));

    }
    
    public function getListeByCriteraAction(){
            $em = $this->getDoctrine()->getManager();
            $posteRepository=$em->getRepository('IutAncienEtudiantBundle:Poste');
            $promotionRepository=$em->getRepository('IutAncienEtudiantBundle:Promotion');
            $postes=$posteRepository->findAll();
            $promotions=$promotionRepository->findAll();
            
        if(isset($_POST['poste']) or isset($_POST['entreprise']) or isset($_POST['promotion'])){
            $poste=$_POST['poste'];$entreprise=$_POST['entreprise'];$promotion=$_POST['promotion'];
            $repository = $this->getDoctrine()
                                ->getManager()
                                ->getRepository('IutAncienEtudiantBundle:Etudiant');

             $etudiants=$repository->getListeByX($poste,$entreprise,$promotion);
             return $this->render('IutAncienEtudiantBundle:AncienEtudiant:recherche_multi.html.twig',array('etudiants'=>$etudiants,'postes'=>$postes,'promotions'=>$promotions));
        }else{
            
            return $this->render('IutAncienEtudiantBundle:AncienEtudiant:recherche_multi.html.twig',array('postes'=>$postes,'promotions'=>$promotions));
        }
    }
    
     public function getByEmailAction(){
         
            $em = $this->getDoctrine()->getManager();
            $posteRepository=$em->getRepository('IutAncienEtudiantBundle:Poste');
            $promotionRepository=$em->getRepository('IutAncienEtudiantBundle:Promotion');
            $etudiantRepository = $em->getRepository('IutAncienEtudiantBundle:Etudiant');
             
            $postes=$posteRepository->findAll();
            $promotions=$promotionRepository->findAll();
            $etudiants=$etudiantRepository->getByEmail($_POST['email']);
        
           return $this->render('IutAncienEtudiantBundle:AncienEtudiant:recherche_multi.html.twig',array('etudiants'=>$etudiants,'postes'=>$postes,'promotions'=>$promotions));

    }
}
