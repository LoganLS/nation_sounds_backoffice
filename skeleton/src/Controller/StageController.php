<?php

namespace App\Controller;

use App\Entity\Stage;
use App\Form\StageType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StageController extends AbstractController
{
    /**
     * @Route("/json/scenes", name="stages_json")
     */
    public function stages_json()
    {
        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('App:Stage')
        ;
        
        $stages=$repository->findAll();

        return $this->json(
            [
                'stages' => $stages,
            ],
            200,
            [
                'content-type'=>'application/json',
                'Access-Control-Allow-Origin' => '*'
            ]
        );
    }

    /**
     * @Route("/scenes", name="stages")
     */
    public function stages()
    {
        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('App:Stage')
        ;
        
        $stages=$repository->findAll();

        return $this->render('stage/stages.html.twig', [
            'stages' => $stages,
        ]);
    }

    /**
     * @Route("/scene/detail/{id}",name="stage")
     */
    public function stage(int $id)
    {
        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('App:Stage')
        ;

        if(!empty($id)){
            $stage=$repository->find($id);

            return $this->render('stage/stage.html.twig', [
                'stage' => $stage
            ]);
        }else{
            return $this->redirectToRoute('stages');
        }
    }

    /**
     * @Route("/scene/modifier/{id}",name="update_stage")
     */
    public function update_stage(int $id,Request $request, ObjectManager $manager){
        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('App:Stage')
        ;

        if(!empty($id)){
            $stage=$repository->find($id);

            $form=$this->createForm(StageType::class,$stage);

            if($stage){
                $form->handleRequest($request);
            
                if($form->isSubmitted() && $form->isValid()){
                    $data=$form->getData();
                    $manager->persist($data);
                    $manager->flush();

                    //redirection sur la page détail du projet ajouté
                    return $this->redirectToRoute('stage',array('id'=>$stage->getId()));
                }

                return $this->render('stage/update_stage.html.twig', [
                    'form' => $form->createView(),
                    'stage' => $stage
                ]);
            }
        }
        return $this->redirectToRoute('stages');
    }

    /**
     * @Route("/scene/supprimer/{id}",name="delete_stage")
     */
    public function delete_stage(int $id, ObjectManager $manager){
        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('App:Stage')
        ;

        if(!empty($id)){
            $stage=$repository->find($id);

            if($stage){
                $manager->remove($stage);
                $manager->flush();
            }

        }
        return $this->redirectToRoute('stages');
    }

    /**
     * @Route("/scene/new",name="new_stage")
     */
    public function new_stage(Request $request, ObjectManager $manager){
        $stage=new Stage();

        $form=$this->createForm(StageType::class,$stage);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($stage);
            $manager->flush();

            //redirection sur la page détail du projet ajouté
            return $this->redirectToRoute('stage',array('id'=>$stage->getId()));
        }

        return $this->render('stage/new_stage.html.twig',[
            'form'=>$form->createView()
        ]);
    }
}
