<?php

namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

//Importo los tipos de datos para el formulario
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\JsonType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
//Cargamos la calse para las restricciones de FILE
use Symfony\Component\Validator\Constraints\File;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titulo', TextType::class)
            //->add('likes')
            //->add('foto')

            ->add('foto', FileType::class, [
                'label' => 'Foto (PDF file)',
                // unmapped means that this field is not associated to any entity property
                'mapped' => false,
                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,
                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        //'mimeTypes' => [
                        //    'application/pdf',
                        //    'application/x-pdf',
                        //],
                        //'mimeTypesMessage' => 'Por favor sube solo fichero en formato PDF',
                    ])
                ],
            ])

            //->add('fecha_publicacion')   //esta en el constructor
            ->add('contenido', TextareaType::class)
            //->add('user')   //lo controlamos desde el controller
            ->add('save', SubmitType::class, array('label' => 'Grabar registro')) 
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
