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

class PropertyFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, ['label' => 'Titre'])

            ->add('description', TextType::class, ['label' => 'Description'])
            ->add('price', TextType::class, ['label' => 'Prix'])
            ->add('area', TextType::class, ['label' => 'Surface'])
            ->add('city', TextType::class, ['label' => 'Ville'])
            ->add('postcode', TextType::class, ['label' => 'Code Postale'])
            ->add('adress', TextType::class, ['label' => 'Adresse'])
            ->add('phone', TextType::class, ['label' => 'Telephone'])

            ->add('rooms', TextType::class, ['label' => 'Nombre de Pièces'])
            ->add('bedrooms', TextType::class, ['label' => 'Nombre de Chambres'])
            ->add('energy', TextType::class, ['label' => 'Energie'])
            // On ajoute le champ "images" dans le formulaire
            // Il n'est pas lié à la base de données (mapped à false)
            ->add('images', FileType::class, [
                'label' => false,
                'multiple' => true,
                'mapped' => false,
                'required' => false
            ])
            ->add('propertytype', EntityType::class, [
                'class' => PropertyType::class,
                'label' => 'Type de bien'

            ]);
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
        ]);
    }
}
