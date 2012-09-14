<?php

namespace Agenda\ContactosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class NumerosType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('numero')
            //->add('agenda')
        ;
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Agenda\ContactosBundle\Entity\Numeros',
        );
    }
    public function getName()
    {
        return 'agenda_contactosbundle_numerostype';
    }
}
