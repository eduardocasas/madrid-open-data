<?php

namespace AppBundle\Controller\contact;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Form\Type\ContactType;

class DefaultController extends Controller
{
    
    public function submitAction()
    {
        $form = $this->createForm(new ContactType);
        $form->bind($this->getRequest());
        if ($form->isValid()) {
            $data = $form->getData();
            $message = \Swift_Message::newInstance()
            ->setSubject($data['subject'])
            ->setFrom($this->container->getParameter('my_email'))
            ->setTo($this->container->getParameter('my_email'))
            ->setBody('Correo enviado desde la web www.respiramadrid.com
                    
Email: '.$data['email'].'
    
Asunto: '.$data['subject'].'
    
Mensaje:
                    
'.$data['message']);
            $this->get('mailer')->send($message);
            $this->get('session')->set('email_sent', true);

            return $this->redirect($this->generateUrl('contact_info'));
        }

        return $this->redirect($this->generateUrl('contact'));
    }
    
    public function infoAction()
    {
        if (!$this->get('session')->has('email_sent')) {
            return $this->redirect($this->generateUrl('contact'));
        }
        $this->get('session')->remove('email_sent');

        return $this->render('contact/info.html.twig');
    }
    
    public function indexAction()
    {
        return $this->render('contact/index.html.twig', [
            'section' => 'contact',
            'form' => $this->createForm(new ContactType)->createView()
        ]);
    }
    
}
