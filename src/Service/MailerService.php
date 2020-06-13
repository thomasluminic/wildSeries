<?php


namespace App\Service;


use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;

class MailerService
{
    private MailerInterface $mailer;

    private ContainerInterface $container;

    private Environment $twig;

    public function __construct(MailerInterface $mailer, ContainerInterface $container, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->container = $container;
        $this->twig = $twig;
    }

    public function createMail($program)
    {
        $email = (new TemplatedEmail())
            ->from($this->container->getParameter('mailer_from'))
            ->to('toto@gmail.com')
            ->subject('Une nouvelle série vient d\'être publiée !')
            ->htmlTemplate('Mailer/program.html.twig')
            ->context(['program' => $program]);
        $this->mailer->send($email);
    }
}
