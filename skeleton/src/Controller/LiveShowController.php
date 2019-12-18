<?php

namespace App\Controller;

use App\Entity\LiveShow;
use App\Form\LiveShowType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LiveShowController extends AbstractController
{
    /**
     * @Route("/json/concerts", name="shows_json")
     */
    public function show_json()
    {
        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('App:LiveShow')
        ;
        
        $shows=$repository->findAll();

        return $this->json([
            'shows' => $shows,
            ],
            200,
            [
                'content-type'=>'application/json',
                'Access-Control-Allow-Origin' => '*'
            ]
        );
    }

    /**
     * @Route("/concerts", name="shows")
     */
    public function shows()
    {
        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('App:LiveShow')
        ;
        
        $shows=$repository->findAll();

        return $this->render('liveshow/shows.html.twig', [
            'shows' => $shows,
        ]);
    }

    /**
     * @Route("/concert/detail/{id}",name="show")
     */
    public function show(int $id)
    {
        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('App:LiveShow')
        ;

        if(!empty($id)){
            $show=$repository->find($id);

            return $this->render('liveshow/show.html.twig', [
                'show' => $show
            ]);
        }else{
            return $this->redirectToRoute('shows');
        }
    }

    /**
     * @Route("/concert/modifier/{id}",name="update_show")
     */
    public function update_show(int $id,Request $request, ObjectManager $manager){
        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('App:LiveShow')
        ;

        if(!empty($id)){
            $show=$repository->find($id);

            $repository_artist = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('App:Artist')
            ;
            $nameArtist = $repository_artist->findAll();

            $repository_stage = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('App:Stage')
            ;
            $nameStage = $repository_stage->findAll();

            $form=$this->createForm(LiveShowType::class,$show, array(
                'nameArtist'=>$nameArtist,
                'nameStage'=>$nameStage
            ));

            if($show){
                $form->handleRequest($request);
            
                if($form->isSubmitted() && $form->isValid()){
                    $data=$form->getData();
                    $manager->persist($data);
                    $manager->flush();

                    //redirection sur la page détail du projet ajouté
                    return $this->redirectToRoute('show',array('id'=>$show->getId()));
                }

                return $this->render('liveshow/update_show.html.twig', [
                    'form' => $form->createView(),
                    'show' => $show
                ]);
            }
        }
        return $this->redirectToRoute('shows');
    }

    /**
     * @Route("/concert/supprimer/{id}",name="delete_show")
     */
    public function delete_show(int $id, ObjectManager $manager){
        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('App:LiveShow')
        ;

        if(!empty($id)){
            $show=$repository->find($id);

            if($show){
                $manager->remove($show);
                $manager->flush();
            }

        }
        return $this->redirectToRoute('shows');
    }

    /**
     * @Route("/concert/new",name="new_show")
     */
    public function new_show(Request $request, ObjectManager $manager){
        $show=new LiveShow();

        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('App:Artist')
        ;
        $nameArtist = $repository->findAll();

        $repository_stage = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('App:Stage')
        ;
        $nameStage = $repository_stage->findAll();

        $form=$this->createForm(LiveShowType::class,$show, array(
            'nameArtist'=>$nameArtist,
            'nameStage'=>$nameStage
        ));
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($show);
            $manager->flush();

            //redirection sur la page détail du projet ajouté
            return $this->redirectToRoute('show',array('id'=>$show->getId()));
        }

        return $this->render('liveshow/new_show.html.twig',[
            'form'=>$form->createView()
        ]);
    }
}
