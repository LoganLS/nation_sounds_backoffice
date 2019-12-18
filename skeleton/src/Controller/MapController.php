<?php

namespace App\Controller;

use App\Form\MapType;
use App\Entity\Map;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MapController extends AbstractController
{
    /**
     * @Route("/json/maps", name="maps_json")
     */
    public function maps_json()
    {
        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('App:Map')
        ;
        
        $maps=$repository->findAll();

        return $this->json([
            'maps' => $maps,
            ],
            200,
            [
                'content-type'=>'application/json',
                'Access-Control-Allow-Origin' => '*'
            ]
        );
    }

    /**
     * @Route("/maps", name="maps")
     */
    public function maps()
    {
        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('App:Map')
        ;
        
        $maps=$repository->findAll();

        return $this->render('map/maps.html.twig', [
            'maps' => $maps,
        ]);
    }

    /**
     * @Route("/map/detail/{id}",name="map")
     */
    public function map(int $id)
    {
        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('App:Map')
        ;

        if(!empty($id)){
            $map=$repository->find($id);

            return $this->render('map/map.html.twig', [
                'map' => $map
            ]);
        }else{
            return $this->redirectToRoute('maps');
        }
    }

    /**
     * @Route("/map/modifier/{id}",name="update_map")
     */
    public function update_map(int $id,Request $request, ObjectManager $manager){
        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('App:Map')
        ;

        if(!empty($id)){
            $map=$repository->find($id);

            $form=$this->createForm(MapType::class,$map);

            if($map){
                $form->handleRequest($request);
            
                if($form->isSubmitted() && $form->isValid()){
                    $data=$form->getData();
                    $manager->persist($data);
                    $manager->flush();

                    //redirection sur la page détail du projet ajouté
                    return $this->redirectToRoute('map',array('id'=>$map->getId()));
                }

                return $this->render('map/update_map.html.twig', [
                    'form' => $form->createView(),
                    'map' => $map
                ]);
            }
        }
        return $this->redirectToRoute('maps');
    }

    /**
     * @Route("/map/supprimer/{id}",name="delete_map")
     */
    public function delete_map(int $id, ObjectManager $manager){
        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('App:Map')
        ;

        if(!empty($id)){
            $map=$repository->find($id);

            if($map){
                $manager->remove($map);
                $manager->flush();
            }

        }
        return $this->redirectToRoute('maps');
    }

    /**
     * @Route("/map/new",name="new_map")
     */
    public function new_map(Request $request, ObjectManager $manager){
        $map=new Map();

        $form=$this->createForm(MapType::class,$map);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($map);
            $manager->flush();

            //redirection sur la page détail du projet ajouté
            return $this->redirectToRoute('map',array('id'=>$map->getId()));
        }

        return $this->render('map/new_map.html.twig',[
            'form'=>$form->createView()
        ]);
    }
}
