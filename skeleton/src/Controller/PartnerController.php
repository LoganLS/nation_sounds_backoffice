<?php

namespace App\Controller;

use App\Entity\Partner;
use App\Form\PartnerType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PartnerController extends AbstractController
{
    /**
     * @Route("/json/partenaires", name="partners_json")
     */
    public function partners_json()
    {
        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('App:Partner')
        ;
        
        $partners=$repository->findAll();

        return $this->json([
            'partners' => $partners,
            ],
            200,
            [
                'content-type'=>'application/json',
                'Access-Control-Allow-Origin' => '*'
            ]
        );
    }

    /**
     * @Route("/partenaires", name="partners")
     */
    public function partners()
    {
        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('App:Partner')
        ;
        
        $partners=$repository->findAll();

        return $this->render('partner/partners.html.twig', [
            'partners' => $partners,
        ]);
    }

    /**
     * @Route("/partenaire/detail/{id}",name="partner")
     */
    public function partner(int $id)
    {
        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('App:Partner')
        ;

        if(!empty($id)){
            $partner=$repository->find($id);

            return $this->render('partner/partner.html.twig', [
                'partner' => $partner
            ]);
        }else{
            return $this->redirectToRoute('partners');
        }
    }

    /**
     * @Route("/partenaire/modifier/{id}",name="update_partner")
     */
    public function update_partner(int $id,Request $request, ObjectManager $manager){
        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('App:Partner')
        ;

        if(!empty($id)){
            $partner=$repository->find($id);

            $form=$this->createForm(PartnerType::class,$partner);

            if($partner){
                $form->handleRequest($request);
            
                if($form->isSubmitted() && $form->isValid()){
                    $data=$form->getData();
                    $manager->persist($data);
                    $manager->flush();

                    //redirection sur la page détail du projet ajouté
                    return $this->redirectToRoute('partner',array('id'=>$partner->getId()));
                }

                return $this->render('partner/update_partner.html.twig', [
                    'form' => $form->createView(),
                    'partner' => $partner
                ]);
            }
        }
        return $this->redirectToRoute('partners');
    }

    /**
     * @Route("/partenaire/supprimer/{id}",name="delete_partner")
     */
    public function delete_partner(int $id, ObjectManager $manager){
        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('App:Partner')
        ;

        if(!empty($id)){
            $partner=$repository->find($id);

            if($partner){
                $manager->remove($partner);
                $manager->flush();
            }

        }
        return $this->redirectToRoute('partners');
    }

    /**
     * @Route("/partenaire/new",name="new_partner")
     */
    public function new_partner(Request $request, ObjectManager $manager){
        $partner=new Partner();

        $form=$this->createForm(PartnerType::class,$partner);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($partner);
            $manager->flush();

            //redirection sur la page détail du projet ajouté
            return $this->redirectToRoute('partner',array('id'=>$partner->getId()));
        }

        return $this->render('partner/new_partner.html.twig',[
            'form'=>$form->createView()
        ]);
    }
}
