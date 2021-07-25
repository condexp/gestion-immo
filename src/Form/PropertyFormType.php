<?php

namespace App\Form;

use App\Entity\Property;
use App\Entity\PropertyType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;




use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

//PropertyFormType
//PropertyType
class PropertyFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)

            ->add('description')
            ->add('price')
            ->add('area')
            ->add('city')
            ->add('postcode')
            ->add('adress')

            ->add('rooms')
            ->add('bedrooms')
            ->add('energy')
            // On ajoute le champ "images" dans le formulaire
            // Il n'est pas lié à la base de données (mapped à false)
            ->add('images', FileType::class, [
                'label' => false,
                'multiple' => true,
                'mapped' => false,
                'required' => false
            ])
            ->add('propertytype', EntityType::class, [
                'class' => PropertyType::class
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
        ]);
    }
}
