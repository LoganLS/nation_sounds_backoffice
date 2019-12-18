<?php

namespace App\Form;

use App\Entity\LiveShow;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class LiveShowType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('artist',ChoiceType::class,array(
                'label'=>'Artiste',
                'choices'=>$options['nameArtist'],
                'choice_label' => 'name'
            ))
            ->add('stage',ChoiceType::class,array(
                'label'=>'Scène',
                'choices'=>$options['nameStage'],
                'choice_label' => 'name'
            ))
            ->add('dateStart')
            ->add('dateEnd')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => LiveShow::class,
            'nameArtist' => null,
            'nameStage' => null
        ]);
    }
}
