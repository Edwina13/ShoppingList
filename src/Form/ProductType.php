<?php

namespace App\Form;

use App\Entity\Product;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array(
                'label' => false
            ))
            ->add('category', EntityType::class, array(
                'query_builder' => function(EntityRepository $er) use (&$options) {
                    return $er->createQueryBuilder('c')
                        ->orderBy("c.name", 'ASC');
                },
                'class' => 'App:Category',
                'choice_label'=> 'name',
                'placeholder' => 'Selectionner une catégorie',
                'label' => false
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
