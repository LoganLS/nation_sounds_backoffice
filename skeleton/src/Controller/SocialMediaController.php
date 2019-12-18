<?php

namespace App\Controller;

use App\Entity\SocialMedia;
use App\Form\SocialMediaType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SocialMediaController extends AbstractController
{
    /**
     * @Route("/json/reseaux_sociaux", name="social_medias_json")
     */
    public function social_medias_json()
    {
        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('App:SocialMedia')
        ;
        
        $social_medias=$repository->findAll();

        return $this->json([
            'social_medias' => $social_medias,
            ],
            200,
            [
                'content-type'=>'application/json',
                'Access-Control-Allow-Origin' => '*'
            ]
        );
    }
    
    /**
     * @Route("/reseaux_sociaux", name="social_medias")
     */
    public function social_medias()
    {
        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('App:SocialMedia')
        ;
        
        $social_medias=$repository->findAll();

        return $this->render('social_media/social_medias.html.twig', [
            'social_medias' => $social_medias,
        ]);
    }

    /**
     * @Route("/reseau_social/detail/{id}",name="social_media")
     */
    public function social_media(int $id)
    {
        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('App:SocialMedia')
        ;

        if(!empty($id)){
            $social_media=$repository->find($id);

            return $this->render('social_media/social_media.html.twig', [
                'social_media' => $social_media
            ]);
        }else{
            return $this->redirectToRoute('social_medias');
        }
    }

    /**
     * @Route("/reseau_social/modifier/{id}",name="update_social_media")
     */
    public function update_social_media(int $id,Request $request, ObjectManager $manager){
        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('App:SocialMedia')
        ;

        if(!empty($id)){
            $social_media=$repository->find($id);

            $form=$this->createForm(SocialMediaType::class,$social_media);

            if($social_media){
                $form->handleRequest($request);
            
                if($form->isSubmitted() && $form->isValid()){
                    $data=$form->getData();
                    $manager->persist($data);
                    $manager->flush();

                    //redirection sur la page détail du projet ajouté
                    return $this->redirectToRoute('social_media',array('id'=>$social_media->getId()));
                }

                return $this->render('social_media/update_social_media.html.twig', [
                    'form' => $form->createView(),
                    'social_media' => $social_media
                ]);
            }
        }
        return $this->redirectToRoute('social_medias');
    }

    /**
     * @Route("/reseau_social/supprimer/{id}",name="delete_social_media")
     */
    public function delete_social_media(int $id, ObjectManager $manager){
        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('App:SocialMedia')
        ;

        if(!empty($id)){
            $social_media=$repository->find($id);

            if($social_media){
                $manager->remove($social_media);
                $manager->flush();
            }

        }
        return $this->redirectToRoute('social_medias');
    }

    /**
     * @Route("/reseau_social/new",name="new_social_media")
     */
    public function new_social_media(Request $request, ObjectManager $manager){
        $social_media=new SocialMedia();

        $form=$this->createForm(SocialMediaType::class,$social_media);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($social_media);
            $manager->flush();

            //redirection sur la page détail du projet ajouté
            return $this->redirectToRoute('social_media',array('id'=>$social_media->getId()));
        }

        return $this->render('social_media/new_social_media.html.twig',[
            'form'=>$form->createView()
        ]);
    }
}
