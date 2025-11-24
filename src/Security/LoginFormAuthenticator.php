<?php

namespace App\Security;

use App\Entity\User;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\SecurityRequestAttributes;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class LoginFormAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';

    public function __construct(private UrlGeneratorInterface $urlGenerator)
    {
    }

    public function authenticate(Request $request): Passport
    {
        $email = $request->request->get('email', '');
        $password = $request->request->get('password', '');
        $csrfToken = $request->request->get('_csrf_token');

        $request->getSession()->set(SecurityRequestAttributes::LAST_USERNAME, $email);

        return new Passport(
            new UserBadge($email),
            new PasswordCredentials($password),
            [
                new CsrfTokenBadge('authenticate', $csrfToken),
                new RememberMeBadge(),
            ]
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        // 1. Redirection vers la page demandée avant la connexion (si elle existe)
        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }

        // 2. Récupération de l'utilisateur et de ses rôles
        /** @var User $user */
        $user = $token->getUser();
        $roles = $user->getRoles();

        // --- GESTION PROFESSEUR ---
        if (in_array('ROLE_PROF', $roles, true)) {
            $professeur = $user->getProfesseur();
            if ($professeur) {
                // Vérifiez bien que la route 'app_professeur_dashboard' existe dans ProfesseurController
                return new RedirectResponse($this->urlGenerator->generate('app_professeur_dashboard', [
                    'id' => $professeur->getId(),
                ]));
            }
        }

        // --- GESTION ELEVE ---
        if (in_array('ROLE_ELEVE', $roles, true)) {
            $eleve = $user->getEleve();
            if ($eleve) {
                return new RedirectResponse($this->urlGenerator->generate('app_eleve_dashboard', [
                    'id' => $eleve->getId(),
                ]));
            }
        }

        // --- GESTION ADMIN ---
        if (in_array('ROLE_ADMIN', $roles, true)) {
            $admin = $user->getAdmin();
            if ($admin) {
                return new RedirectResponse($this->urlGenerator->generate('app_admin_dashboard', [
                    'id' => $admin->getId(),
                ]));
            }
            // Fallback si pas d'objet Admin lié mais qu'il a le rôle
            return new RedirectResponse($this->urlGenerator->generate('app_admin_index')); // Route générique admin
        }

        // --- GESTION GESTIONNAIRE ---
        if (in_array('ROLE_GESTIONNAIRE', $roles, true)) {
            $gestionnaire = $user->getGestionnaire();
            if ($gestionnaire) {
                return new RedirectResponse($this->urlGenerator->generate('app_gestionnaire_dashboard', [
                    'id' => $gestionnaire->getId(),
                ]));
            }
        }

        // 3. Redirection par défaut (Accueil)
        return new RedirectResponse($this->urlGenerator->generate('app_home'));
    }

    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}