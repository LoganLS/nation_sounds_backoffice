<?php

namespace App\Form;

use App\Entity\MeetArtist;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class MeetArtistType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('artist',ChoiceType::class,array(
                'label'=>'Artiste',
                'choices'=>$options['nameArtist'],
                'choice_label' => 'name'
            ))
            ->add('dateStart')
            ->add('dateEnd')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MeetArtist::class,
            'nameArtist' => null
        ]);
    }
}
