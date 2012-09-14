<?php

namespace Agenda\UsuariosBundle\DataFixtures\ORM;
//..clases necesarias para traer la inyeccion de dependencias en sf2
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
//..entidades
use Agenda\ContactosBundle\Entity\Agenda;
use Agenda\ContactosBundle\Entity\Numeros;
use Agenda\UsuariosBundle\Entity\Usuario;
//..clases que funcione la carga de objetos
//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class CargarContactos  extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    
    function getOrder()
    {
        return 2;
    }//fin getOrder 
    
    public function load(ObjectManager $manager)
    {
        $codigos=array("0416","0414","0426","0424","0412");
           for ($i=1; $i<=30; $i++) 
           {
                $agenda=new Agenda;
                $usuario = $manager->getRepository("UsuariosBundle:Usuario")->findOneByUser('usuario'.rand(1,10));
                $agenda->setNombres('nombres'.$i);
                $agenda->setApellidos('apellidos'.$i);
                $agenda->setUsuario($usuario);
                $manager->persist($agenda);
                    for($j=1;$j<=rand(1,4);$j++)
                    {
                         $numero=new Numeros;
                         $numero->setNumero($codigos[rand(0,4)].rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9));
                         $numero->setAgenda($agenda);
                         $manager->persist($numero);
                    }
            }//fin for

        $manager->flush();
    }//fin Load


}


?>
