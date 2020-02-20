<?php
namespace App\Service;

use App\Repository\InfosEntrepriseRepository;
use Knp\Snappy\Pdf;

class BonDeCommandeService
{
    private $mailer;
    private $templating;
    private $repo;
    private $pdf;

    public function __construct( \Swift_Mailer $mailer, \Twig\Environment $templating, InfosEntrepriseRepository $repo, Pdf $pdf)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->repo = $repo;
        $this->pdf = $pdf;
    }

    /**
     * Generateur de bon de commande
     *
     * @param Demande $demande
     * @param string $template format('/front_end/pdf/visa_classic/bon_de_commande.html.twig')
     * @param array $vars
     * @param InfosEntrepriseRepository $repo
     * @param Pdf $pdf
     * @param \Swift_Mailer $mailer
     * @return void
     */
    public function generateur($demande, $template, $vars)
    {

        //Génerer le pdf bon de commande
        $html = $this->templating->render('/front_end/pdf/visa_classic/bon_de_commande.html.twig',   
            [
                'demande'  => $demande,
                'entreprise'    => $this->repo->findOneBy(
                    [
                        'typeVisa'  => 'visa_classic'
                    ]
                ),
            ]
        );

        $filename = sprintf('bon de commande-%s.pdf', date('Y-m-d'));
        $pdf = $this->pdf->getOutputFromHtml($html);

        $message= (new \Swift_Message('Document manquant : visa en ligne'))
            ->setFrom('sghairipro63@gmail.com')
            ->setTo($demande->getClient()->getEmail())
            ->setBody(
                $this->templating->render(
                    $template, $vars
                ),
                'text/html'
        );

        $attachement = new \Swift_Attachment($pdf, $filename, 'application/pdf');
        $message->attach($attachement);
        $this->mailer->send($message);

        
    }
}