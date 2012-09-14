<?php

namespace Agenda\ContactosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class AgendaType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('nombres')
            ->add('apellidos')
            ->add('email')
            ->add('usuario')
            ->add('numeros','collection',array("allow_add"=>TRUE,
                                                "type"=>new NumerosType(),
                                                ))
        ;
    }

    public function getName()
    {
        return 'agenda_contactosbundle_agendatype';
    }
}
