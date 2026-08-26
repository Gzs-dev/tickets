<?php

namespace App\Form;

use App\Entity\Categories;
use App\Entity\States;
use App\Entity\Tickets;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

// use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UpdateTicketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $session = $options['session'];
        $role = $session->get('role');
        $isAdmin = $role === 'ROLE_ADMIN';
        $isStaff = $role === 'ROLE_USER';

        $builder
            ->add('mailClient',EmailType::class,[
                'label'=>'Email client',
                'disabled'=>!$isAdmin])
            ->add('openDate',DateType::class,[
                'label'=>'Date ouverture',
                'disabled'=>!$isAdmin])
            ->add('closeDate',DateType::class,[
                'label'=>'Date fermeture',
                'disabled'=>!$isAdmin,
                'required'=> false])
            ->add('descriptive',TextareaType::class,[
                'label'=>'Description',
                'disabled'=>!$isAdmin])
            ->add('responsable',TextType::class,[
                'label'=>'Responsable',
                'disabled'=>!$isAdmin,
                'required'=> false])
            ->add('category', EntityType::class, [
                'label'=> 'Catégorie',
                'class' => Categories::class,
                'choice_label' => 'name',
                'disabled'=>!$isAdmin])
            ->add('state', EntityType::class, [
                'label'=> 'Etat',
                'class' => States::class,
                'choice_label' => 'name',
            ])
            ->add('Valider', SubmitType::class,['label'=>'Mettre à jour']);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tickets::class,
            'session' => null,
        ]);
    }
}
