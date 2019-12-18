<?php

namespace App\Controller;

use App\Entity\Question;
use App\Form\QuestionType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class QuestionController extends AbstractController
{
    /**
     * @Route("/json/faqs", name="faqs_json")
     */
    public function faqs_json()
    {
        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('App:Question')
        ;
        
        $faqs=$repository->findAll();

        return $this->json([
            'faqs' => $faqs,
            ],
            200,
            [
                'content-type'=>'application/json',
                'Access-Control-Allow-Origin' => '*'
            ]
        );
    }

    /**
     * @Route("/faqs", name="faqs")
     */
    public function faqs()
    {
        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('App:Question')
        ;
        
        $faqs=$repository->findAll();

        return $this->render('faq/faqs.html.twig', [
            'faqs' => $faqs,
        ]);
    }

    /**
     * @Route("/faq/detail/{id}",name="faq")
     */
    public function faq(int $id)
    {
        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('App:Question')
        ;

        if(!empty($id)){
            $faq=$repository->find($id);

            return $this->render('faq/faq.html.twig', [
                'faq' => $faq
            ]);
        }else{
            return $this->redirectToRoute('faqs');
        }
    }

    /**
     * @Route("/faq/modifier/{id}",name="update_faq")
     */
    public function update_faq(int $id,Request $request, ObjectManager $manager){
        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('App:Question')
        ;

        if(!empty($id)){
            $faq=$repository->find($id);

            $form=$this->createForm(QuestionType::class,$faq);

            if($faq){
                $form->handleRequest($request);
            
                if($form->isSubmitted() && $form->isValid()){
                    $data=$form->getData();
                    $manager->persist($data);
                    $manager->flush();

                    //redirection sur la page détail du projet ajouté
                    return $this->redirectToRoute('faq',array('id'=>$faq->getId()));
                }

                return $this->render('faq/update_faq.html.twig', [
                    'form' => $form->createView(),
                    'faq' => $faq
                ]);
            }
        }
        return $this->redirectToRoute('faqs');
    }

    /**
     * @Route("/faq/supprimer/{id}",name="delete_faq")
     */
    public function delete_faq(int $id, ObjectManager $manager){
        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('App:Question')
        ;

        if(!empty($id)){
            $faq=$repository->find($id);

            if($faq){
                $manager->remove($faq);
                $manager->flush();
            }

        }
        return $this->redirectToRoute('faqs');
    }

    /**
     * @Route("/faq/new",name="new_faq")
     */
    public function new_faq(Request $request, ObjectManager $manager){
        $faq=new Question();

        $form=$this->createForm(QuestionType::class,$faq);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($faq);
            $manager->flush();

            //redirection sur la page détail du projet ajouté
            return $this->redirectToRoute('faq',array('id'=>$faq->getId()));
        }

        return $this->render('faq/new_faq.html.twig',[
            'form'=>$form->createView()
        ]);
    }
}
