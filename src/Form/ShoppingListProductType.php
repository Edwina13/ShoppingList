<?php

namespace App\Form;

use App\Entity\ShoppingListProduct;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ShoppingListProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quantity', null, array(
                'label' => false
            ))
            /*->add('shopping_list', EntityType::class, array(
                'class' => 'App:ShoppingList',
                'choice_label' => 'name',
                'label' => false
            ))*/
            ->add('product', EntityType::class, array(
                'class' => 'App:Product',
                'choice_label' => 'name',
                'placeholder' => 'Selectionnez un produit',
                'label' => false
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ShoppingListProduct::class,
        ]);
    }
}
