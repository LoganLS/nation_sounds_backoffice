<?php

namespace App\Controller;

use App\Entity\Artist;
use App\Form\ArtistType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArtistController extends AbstractController
{

    /**
     * @Route("/json/artists", name="artists_json")
     */
    public function artists_json()
    {
        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('App:Artist')
        ;
        
        $artists=$repository->findAll();

        return $this->json([
                'artists' => $artists,
            ],
            200,
            [
                'content-type'=>'application/json',
                'Access-Control-Allow-Origin' => '*'
            ]
        );
    }

    /**
     * @Route("/artists", name="artists")
     */
    public function artists()
    {
        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('App:Artist')
        ;
        
        $artists=$repository->findAll();

        return $this->render('artist/artists.html.twig', [
            'artists' => $artists,
        ]);
    }

    /**
     * @Route("/artiste/detail/{id}",name="artist")
     */
    public function artist(int $id)
    {
        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('App:Artist')
        ;

        if(!empty($id)){
            $artist=$repository->find($id);

            if(!empty($artist)){
                return $this->render('artist/artist.html.twig', [
                    'artist' => $artist
                ]);
            }
        }
        
        return $this->redirectToRoute('artists');
        
    }

    /**
     * @Route("/artiste/modifier/{id}",name="update_artist")
     */
    public function update_artist(int $id,Request $request, ObjectManager $manager){
        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('App:Artist')
        ;

        if(!empty($id)){
            $artist=$repository->find($id);

            $form=$this->createForm(ArtistType::class,$artist);

            if($artist){
                $form->handleRequest($request);
            
                if($form->isSubmitted() && $form->isValid()){
                    /*$file = $form['picture']->getData();
                    $file->move('D:/wamp64/www/nation_sounds/img',$file->getClientOriginalName());
                    $file->move('D:/wamp64/www/nation_sounds_backoffice/img',$file->getClientOriginalName());

                    $artist->setPicture($file->getClientOriginalName());*/

                    $data=$form->getData();
                    $manager->persist($data);
                    $manager->flush();

                    //redirection sur la page détail du projet ajouté
                    return $this->redirectToRoute('artist',array('id'=>$artist->getId()));
                }

                return $this->render('artist/update_artist.html.twig', [
                    'form' => $form->createView(),
                    'artist' => $artist
                ]);
            }
        }
        return $this->redirectToRoute('artists');
    }

    /**
     * @Route("/artiste/supprimer/{id}",name="delete_artist")
     */
    public function delete_artist(int $id, ObjectManager $manager){
        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('App:Artist')
        ;

        if(!empty($id)){
            $artist=$repository->find($id);

            if($artist){
                $manager->remove($artist);
                $manager->flush();
            }

        }
        return $this->redirectToRoute('artists');
    }

    /**
     * @Route("/artists/new",name="new_artist")
     */
    public function new_artist(Request $request, ObjectManager $manager){
        $artist=new Artist();

        $form=$this->createForm(ArtistType::class,$artist);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            /*$file = $form['picture']->getData();
            $file->move('D:/wamp64/www/nation_sounds/img',$file->getClientOriginalName());
            $file->move('D:/wamp64/www/nation_sounds_backoffice/img',$file->getClientOriginalName());

            $artist->setPicture($file->getClientOriginalName());*/
            $manager->persist($artist);
            $manager->flush();

            //redirection sur la page détail du projet ajouté
            return $this->redirectToRoute('artist',array('id'=>$artist->getId()));
        }

        return $this->render('artist/new_artist.html.twig',[
            'form'=>$form->createView()
        ]);
    }
}
