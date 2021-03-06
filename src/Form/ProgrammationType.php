<?php

namespace App\Form;

use App\Entity\Concerts;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProgrammationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('artiste')
            ->add('description')
            ->add('jour', ChoiceType::class, [
                'label' => 'Jour de passage',
                'choices' => $this->getChoices()
            ])
            ->add('heure', null, [
                'label' => 'Heure de passage'
            ])
            ->add('imageFile', FileType::class, [
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Concerts::class,
        ]);
    }

    private function getChoices()
    {
        $choices = Concerts::JOUR;
        $output = [];
        foreach ($choices as $k => $v) {
            $output[$v] = $k;
        }
        return $output;
    }
}
