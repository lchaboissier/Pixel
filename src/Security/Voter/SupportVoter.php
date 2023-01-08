<?php

namespace App\Security\Voter;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class SupportVoter extends Voter
{
    public const NEW = 'POST_NEW';
    public const EDIT = 'POST_EDIT';
    public const VIEW = 'POST_VIEW';

    protected function supports(string $attribute, mixed $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::NEW, self::EDIT, self::VIEW])
            && $subject instanceof \App\Entity\Support;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface && $attribute !== self::VIEW) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::NEW:
                return $subject->getAuthor() == $user || ($user instanceof User && $user->hasRole('ROLE_ADMIN'));
                break;
            case self::EDIT:
                return $subject->getAuthor() == $user || ($user instanceof User && $user->hasRole('ROLE_ADMIN'));
                break;
            case self::VIEW:
                return $subject->getEnabled() || ($user instanceof User && $user->hasRole('ROLE_ADMIN'));
                break;
        }

        return false;
    }
}
