<?php

namespace Iut\UserBundle\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Iut\UserBundle\Entity\User;

class UserController extends Controller
{
    public function indexAction()
    {
        $repository=$this->getDoctrine()->getManager()->getRepository('IutUserBundle:User');
        $users=$repository->findAll();
        
        return $this->render('IutUserBundle:User:index.html.twig', array('users' => $users));
    }
    public function modifUserAction($id){
        
        
        $repository=$this->getDoctrine()->getManager()->getRepository('IutUserBundle:User');
        $user=$repository->find($id);
        if (isset($_POST['username'])){
            
           
            $user->setEmail($_POST['email']);
            $user->setUsername($_POST['username']);
            $user->setEnabled(true);
            $user->setRoles(array($_POST['role']));
            if ($_POST['pwd']!='') $user->setPlainPassword($_POST['pwd']);
            $this->get('fos_user.user_manager')->updateUser($user);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirect($this->generateUrl('iut_user_homepage'));
        }
        
        return $this->render('IutUserBundle:User:update_user.html.twig',array('user' => $user));
     
    }
    
     public function addUserAction(){
        
        
        
        
        if (isset($_POST['username'])){
            $userManager = $this->get('fos_user.user_manager');
            $user = $userManager->createUser();
            $user->setEmail($_POST['email']);
            $user->setUsername($_POST['username']);
            $user->setPlainPassword($_POST['pwd']);
            $user->setRoles(array($_POST['role']));
            $user->setEnabled(true);
            $userManager->updateUser($user);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirect($this->generateUrl('iut_user_homepage'));
        }
        
        return $this->render('IutUserBundle:User:add_user.html.twig');
     
    }
    public function supprimerUserAction()
    {
      
        $request = $this->container->get('request'); 
        $id=$request->request->get('id');
 
        $repository = $this->getDoctrine()
                            ->getManager()
                            ->getRepository('IutUserBundle:User');
       
        $etudiant= $repository->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($etudiant);
        $em->flush();      
        $response = new Response;
        $response->setContent('ok');
        return $response;
       
    }
    
    public function AideAction(){
        return $this->render('IutUserBundle:User:aide.html.twig');
    }
}
