<?php

declare(strict_types = 1);

namespace Mact\Controller\Register;

use Doctrine\ORM\EntityManagerInterface;
use Mact\Entity\User;
use Mact\Form\RegisterFormType;
use Mact\Security\EmailVerifier;
use Mact\Security\LoginAuthenticator;
use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

final class RegisterController extends AbstractController
{
    public function __construct(private readonly EmailVerifier $emailVerifier)
    {
    }

    /**
     * @throws TransportExceptionInterface
     */
    #[Route('/register', name: 'mact_register')]
    #[Template('register/register.html.twig')]
    public function register(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        UserAuthenticatorInterface $userAuthenticator,
        LoginAuthenticator $authenticator,
        EntityManagerInterface $entityManager,
    ): array|RedirectResponse {
        $user = new User();
        $form = $this->createForm(RegisterFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();

            // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation('mact_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('no-reply@mact.com', 'Mact Bot'))
                    ->to($user->getEmail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('register/confirmation_email.html.twig')
            );
            // do anything else you need here, like send an email

            $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );

            return $this->redirectToRoute('mact_home');
        }

        return [
            'registrationForm' => $form->createView(),
        ];
    }
}
