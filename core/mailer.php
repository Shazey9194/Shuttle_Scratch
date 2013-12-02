<?php

require_once './vendor/Swiftmailer/swift_required.php';

/**
 * Mailer description
 * 
 * <p>The mailer core<p>
 * 
 * @author Fabien MORCHOISNE <f.morchoisne@insta.fr>
 */
class Mailer
{

    /**
     * The swiftmailer transport layer
     * 
     * @var \Swift_SmtpTransport 
     */
    private $transport;

    /**
     * Construct
     * 
     */
    public function __construct() {
        $transport = Swift_SmtpTransport::newInstance("smtp.gmail.com", 465, 'ssl');
        $transport->setUsername("shuttleticket@gmail.com");
        $transport->setPassword("Insta2013");
        $this->transport = $transport;
    }

    /**
     * 
     * @param type $email
     * @param type $token
     * @param \Twig_Environment $twig
     */
    public function mailRegister($email, $token, \Twig_Environment $twig) {

        $message = Swift_Message::newInstance();
        $message->setTo($email);
        $message->setSubject('Shuttle - Confirmez votre inscription');
        $message->setBody($twig->render('mail/register.html.twig', array(
                    'email' => $email,
                    'token' => $token
                )), 'text/html');
        $message->setFrom("noreply@shuttle.dev", "Shuttle");

        $mailer = Swift_Mailer::newInstance($this->transport);
        $mailer->send($message);
    }

}