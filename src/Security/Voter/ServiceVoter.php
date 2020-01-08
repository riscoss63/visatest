<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Security;
use App\Entity\Services;

class ServiceVoter extends Voter
{
    private $security;
    
    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    
    protected function supports($attribute, $subject)
    {
        return $attribute === 'SHOW'
            && $subject instanceof Services;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        // on retrouve l'utilisateur (on peut aussi ré-utiliser $this->security)
        $user = $token->getUser();

        // si l'utilisateur n'est pas authentifié, c'est non!
        if (!$user instanceof UserInterface) 
        {
            return false;
        }

        //On récupere le Role de l'utilisateur
        $roles = $user->getRoles();
        $firstRole = $roles[0];

        // Si dans le tableau de service le role de l'utilisateur est présent, c'est oui!
        if (in_array($firstRole, $subject->getDroits()) ) 
        {
            return true;
        }

        //Retourne tous les utilisateurs reliée a se service
        $users=$subject->getUsers();
        // Si l'utilisateur a une autorisation spécial alors c'est oui !
        if($users->contains($user))
        {
            return true;
        }

        // l'utilisateur est un administrateur
        if ($this->security->isGranted('ROLE_SUPERADMIN')) 
        {
            return true;
        }
        
        return false;
    }
}
