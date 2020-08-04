<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

//Importamos el formulario UserType y la entidad
use App\Form\UserType;
use App\Entity\User;
//importar la libreria request
use Symfony\Component\HttpFoundation\Request;

//importamos la interface para la contraseña
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class RegistroController extends AbstractController
{

    //private $passwordEncoder;

    /**
     * @Route("/registro", name="registro")
     */
    public function index(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User;   //objeto de la clase user                     
        $user->setRoles(['ROLE_USER']);   //tipo array
        $user->setBaneado(False);  //asigno el valor false en la grabacion. Campo obligatorio  
        $form = $this->createForm(UserType::class, $user);                

        $form->handleRequest($request);        
        if ($form->isSubmitted() && $form->isValid()) {                
            //guardar los datos en la base de datos
            //---------------------------------------------
            //recoger los datos del forumlario
            $form->getData();
            //pasar los datos del formulario a una variable
            $grabar = $form->getData();        

            //$password_form = $form->get("password")->getData();
            $password_form = $form['password']->getData();

            $user->setPassword($passwordEncoder->encodePassword(
                //pasamos dos parametros
                             $user,
                             $password_form
            ));

            //$user->setPasswrod->($this-> $passwordEncoder('password'));

            //Guardar con Doctrine
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($grabar);
            $entityManager->flush();            
            $this->addFlash('mensaje', 'Tus cambios se han guardado!');

            //ir a otra pagina
            //return $this->redirectToRoute('task_success');
        }
        
        //renderizar un formualrio, despues del createview()
        return $this->render('registro/index.html.twig', [
            'controller_name' => 'Hola mundo',
            'nombre' => 'javier',
            'apellidos' => 'gonzalez alvarez',
            'formulario' => $form->createview()
        ]);             
    }
}
