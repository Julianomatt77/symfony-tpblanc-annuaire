<?php

namespace App\Form;

use App\Entity\Animal;
use App\Entity\Department;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Context\ExecutionContextFactoryInterface;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'attr'=> [
                    'class'=> 'form-control rounded-pill bg-light'
                ],
                'constraints' => [
                    new Callback([
                        'callback' => static function (?string $value, ExecutionContextInterface $context){
                        if ((explode('@', $value)[1]) != 'deloitte.com'){
                            $context
                                ->buildViolation("L'adresse mail doit être de type @deloitte.com")
                                ->atPath('email')
                                ->addViolation();
                        }
                        }
                                 ])
                ]
            ])

            ->add('plainPassword', RepeatedType::class, [
                'mapped' => false,
                'attr' => [
                    'autocomplete' => 'new-password',
                    'class' =>'password-field form-control rounded-pill bg-light'
                ],
                'label'=>'Mot de passe',
                'type'=>PasswordType::class,
                'invalid_message' => 'Veuillez vérifier votre mot de passe',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Le mot de passe doit contenir au moins {{ limit }} caractères',
                        'max' => 4096,
                    ]),
                    new Callback([
                     'callback' => static function (?string $value, ExecutionContextInterface $context){
                         if (!\preg_match('/[a-zA-Z]/', $value)){
                             $context
                                 ->buildViolation("Le mot de passe doit contenir au moins une lettre")
                                 ->atPath('[plainPassword]')
                                 ->addViolation();
                         }
                         if (!\preg_match('/[0-9]/', $value)){
                             $context
                                 ->buildViolation("Le mot de passe doit contenir au moins un chiffre")
                                 ->atPath('[plainPassword]')
                                 ->addViolation();
                         }
                         if (!\preg_match('/[\W]/', $value)){
                             $context
                                 ->buildViolation("Le mot de passe doit contenir au moins un caractère spécial")
                                 ->atPath('[plainPassword]')
                                 ->addViolation();
                         }
                     }
                                 ])

                ],
                'required' => true,
                'first_options' => [
                    'label' => 'Mot de Passe',
                    'attr' => [
                        'class' =>'form-control rounded-pill bg-light'
                    ],
                ],
                'second_options' => [
                    'label' => 'Veuillez confirmer votre mot de Passe',
                    'attr' => [
                        'class' =>'form-control rounded-pill bg-light'
                    ],
                ],
            ])
            ->add('firstname', TextType::class, [
                'label'=>'Prénom',
                'attr'=> ['class'=> 'form-control rounded-pill bg-light']
            ])
            ->add('lastname', TextType::class, [
                'label'=>'Nom',
                'attr'=> ['class'=> 'form-control rounded-pill bg-light']
            ])
            ->add('submit', SubmitType::class, [
                'attr'=> [
                    'class'=> 'btn bg-dark yellowFont'
                ]
            ])
            ->add('department', EntityType::class,[
                'class'=>Department::class,
                'label'=>'Département',
                'attr'=>[
                    'class'=>'form-control rounded-pill bg-light'
                ]
            ])
            ->add('picture', FileType::class,[
                'label'=>'Photo',
                'mapped' => false,
                'required' => true,
                'constraints'=>[
                    new File([
                                 'maxSize'=> '2M',
                                 'maxSizeMessage'=> 'Votre fichier est trop lourd !',
                                 'mimeTypes'=> [
                                     'image/jpeg',
                                     'image/png'
                                 ],
                                 'mimeTypesMessage'=> 'Veuillez uploader une image (jpg ou png)!'
                             ] )],
                'attr'=>
                    ['class'=>'form-control mb-4']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
