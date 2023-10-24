<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Book;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('ref')
        ->add('title')
        ->add('category', ChoiceType::class, [
            'choices' => [
                'Science-Fiction' => 'Science-Fiction',
                'Mystery' => 'Mystery',
                'Autobiography' => 'Autobiography',
            ],
            'label' => 'Category',
        ])
        ->add('publicationDate', DateType::class,[
            'widget' => 'single_text',
            'years' => range(date('Y'), date('Y')),  
            // Other options...
        ])
        //->add('isPublished')
        // ->add('Author', EntityType::class, [
        //     'class' => Author::class,
        //     'choice_label' => 'username',   
        //     'multiple' => false,
        //     'expanded' => false
        // ])
        // ->add('ajouter',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
