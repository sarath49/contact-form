<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;

class SupportController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
      $form = $this->createFormBuilder()
        ->add('from', EmailType::class)
        ->add('message', TextareaType::class)
        ->add('send', SubmitType::class)
        ->getForm()
      ;

      $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid()) {
        $our_form = $form->getData();
        //dump($our_form);

        $message = \Swift_Message::newInstance()
          ->setSubject('Symfony 3 Test Mail')
          ->setFrom($our_form['from'])
          ->setTo('goldenvalley4ever@gmail.com')
          ->setBody(
            $our_form['message'],
            'text/plain'
          )
        ;

        $this->get('mailer')->send($message);

      }
         return $this->render('support/index.html.twig', [
          'our_form' => $form->createView(),
        ]);
    }
}
