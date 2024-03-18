<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class UserVoter extends Voter
{
    public const CONNECT = 'GET_CONNECT';
    public const READ = 'GET_READ';
    public const EDIT = 'POST_EDIT';
    public const DELETE = 'POST_DELETE';
    public const NEW = 'POST_NEW';

    protected function supports(string $attribute, mixed $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::CONNECT, self::READ, self::EDIT, self::DELETE, self::NEW])
            && $subject instanceof \App\Entity\User;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::CONNECT:
                if ($user) {
                    return true;
                }
                break;
            case self::READ:
                if (in_array("ROLE_ADMIN", $user->getRoles())) {
                    return true;
                }
                break;
            case self::EDIT:
                if (in_array("ROLE_ADMIN", $user->getRoles())) {
                    return true;
                }
                break;
            case self::NEW:
                if (in_array("ROLE_ADMIN", $user->getRoles())) {
                    return true;
                }
                break;
        }

        return false;
    }
}
