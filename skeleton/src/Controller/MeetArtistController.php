<?php

namespace App\Controller;

use App\Entity\MeetArtist;
use App\Form\MeetArtistType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MeetArtistController extends AbstractController
{
    /**
     * @Route("/json/rencontres_artistes", name="meet_artists_json")
     */
    public function meet_artists_json()
    {
        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('App:MeetArtist')
        ;
        
        $meet_artists=$repository->findAll();

        return $this->json([
            'meet_artists' => $meet_artists,
            ],
            200,
            [
                'content-type'=>'application/json',
                'Access-Control-Allow-Origin' => '*'
            ]
        );
    }

    /**
     * @Route("/rencontres_artistes", name="meet_artists")
     */
    public function meet_artists()
    {
        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('App:MeetArtist')
        ;
        
        $meet_artists=$repository->findAll();

        return $this->render('meet_artist/meet_artists.html.twig', [
            'meet_artists' => $meet_artists,
        ]);
    }

    /**
     * @Route("/rencontre_artiste/detail/{id}",name="meet_artist")
     */
    public function meet_artist(int $id)
    {
        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('App:MeetArtist')
        ;

        if(!empty($id)){
            $meet_artist=$repository->find($id);

            return $this->render('meet_artist/meet_artist.html.twig', [
                'meet_artist' => $meet_artist
            ]);
        }else{
            return $this->redirectToRoute('meet_artists');
        }
    }

    /**
     * @Route("/rencontre_artiste/modifier/{id}",name="update_meet_artist")
     */
    public function update_meet_artist(int $id,Request $request, ObjectManager $manager){
        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('App:MeetArtist')
        ;

        if(!empty($id)){
            $meet_artist=$repository->find($id);

            $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('App:Artist')
            ;
            $nameArtist = $repository->findAll();

            $form=$this->createForm(MeetArtistType::class,$meet_artist, array(
                'nameArtist'=>$nameArtist
            ));

            if($meet_artist){
                $form->handleRequest($request);
            
                if($form->isSubmitted() && $form->isValid()){
                    $data=$form->getData();
                    $manager->persist($data);
                    $manager->flush();

                    //redirection sur la page détail du projet ajouté
                    return $this->redirectToRoute('meet_artist',array('id'=>$meet_artist->getId()));
                }

                return $this->render('meet_artist/update_meet_artist.html.twig', [
                    'form' => $form->createView(),
                    'meet_artist' => $meet_artist
                ]);
            }
        }
        return $this->redirectToRoute('meet_artists');
    }

    /**
     * @Route("/rencontre_artiste/supprimer/{id}",name="delete_meet_artist")
     */
    public function delete_meet_artist(int $id, ObjectManager $manager){
        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('App:MeetArtist')
        ;

        if(!empty($id)){
            $meet_artist=$repository->find($id);

            if($meet_artist){
                $manager->remove($meet_artist);
                $manager->flush();
            }

        }
        return $this->redirectToRoute('meet_artists');
    }

    /**
     * @Route("/rencontre_artiste/new",name="new_meet_artist")
     */
    public function new_meet_artist(Request $request, ObjectManager $manager){
        $meet_artist=new MeetArtist();

        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('App:Artist')
        ;
        $nameArtist = $repository->findAll();

        $form=$this->createForm(MeetArtistType::class,$meet_artist, array(
            'nameArtist'=>$nameArtist
        ));
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($meet_artist);
            $manager->flush();

            //redirection sur la page détail du projet ajouté
            return $this->redirectToRoute('meet_artist',array('id'=>$meet_artist->getId()));
        }

        return $this->render('meet_artist/new_meet_artist.html.twig',[
            'form'=>$form->createView()
        ]);
    }
}
