<?php
namespace App\Controller\FrontEnd\EspaceClient;

use App\Entity\Demande;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/espace-client")
 */
class EspaceClientController extends AbstractController
{
    /**
     * @Route("/mes-commandes", name="mes_commandes")
     */
    public function commandes(PaginatorInterface $paginator, Request $request) : Response
    {
        $client = $this->getUser();
        $demandes = $client->getDemandes();
        $commandes = $paginator->paginate(
            $demandes,
            $request->query->getInt('page', 1),
            3
        );
        foreach($commandes as $demande)
        {
             
            if($demande->getEtat() === 'commande')
            {
                $commandesEnCours[] = $demande;
            }
            
            $commandesEnCours;
        }

        return $this->render('/front_end/espace_client/mes_commandes.html.twig', [
            'client'        => $client,
            'commandes'     => $commandes,
            'commandesEnCours'  => $commandesEnCours
        ]);
    }

    /**
     * @Route("/commande-visa-classic-{id}", name="visa_classic_commande")
     */
    public function visaClassicCommande($id)
    {
        $commande = $this->getDoctrine()->getRepository(Demande::class)->find($id);
        $client = $commande->getClient();
        return $this->render('/front_end/espace_client/visa_classic_commande.html.twig', [
            'commande'      => $commande,
            'client'        => $client
        ]);
    }

    /**
     * @Route("/commande-evisa-{id}", name="evisa_demande")
     */
    public function evisaCommande($id)
    {
        return $this->render('');
    }
}