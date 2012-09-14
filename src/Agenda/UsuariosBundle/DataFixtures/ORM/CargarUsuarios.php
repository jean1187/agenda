<?php

namespace Agenda\UsuariosBundle\DataFixtures\ORM;
//..clases necesarias para traer la inyeccion de dependencias en sf2
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
//..entidad usuario
use Agenda\UsuariosBundle\Entity\Usuario;
//..clases que funcione la carga de objetos
//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class CargarUsuarios  extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    
    function getOrder()
    {
        return 1;
    }//fin getOrder 
    
    public function load(ObjectManager $manager)
    {
           for ($i=1; $i<=10; $i++) 
           {
                $usuario = new Usuario();

                $usuario->setUser('usuario'.$i);
                $usuario->setSalt(base_convert(sha1(uniqid(mt_rand(), true)), 16, 36));
                $passwordEnClaro = 'password'.$i;
                $encoder = $this->container->get('security.encoder_factory')->getEncoder($usuario);
                $passwordCodificado = $encoder->encodePassword($passwordEnClaro, $usuario->getSalt());
                $usuario->setPassword($passwordCodificado);

                $manager->persist($usuario);
            }//fin for

        $manager->flush();
    }//fin Load


}


?>
