<?php

namespace App\Service;

use App\Entity\User;

class IpAutoriser
{

    public function autoriserIp(User $user, $ipActu)
    {
        $ips = $user->getIps();
        $ipsAutoriser = [];

        //On enregistre la valeur true dans un tableau
        foreach ($ips as $ip) 
        {
            if($ip->getAutoriser() === true)
            {
                $ipsAutoriser [] = true;
                
            }

        }

        //On vérifie dans notre tableau si au moin une valeur true est existante
        if(in_array(true, $ipsAutoriser))
        {
            //On parcourt nos ips enregistrer
            foreach ($ips as $ip) 
            {
                if($ip->getAutoriser() === true AND $ip->getIp() === $ipActu)
                {
                    return true;
                }
                return false;
            }
        }
        return true;
    
        
    }
}