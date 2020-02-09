<?php

namespace App\Service;

use App\Entity\Demande;
use Symfony\Component\HttpFoundation\Request;

class MoneticoPaiement
{
    private $moneticoEpt;
    private $moneticoHmac;
    private $paiement;

    public function __construct(MoneticoEpt $moneticoEpt, MoneticoHmac $moneticoHmac, PayementService $paiement)
    {
        $this->moneticoEpt = $moneticoEpt;
        $this->moneticoHmac = $moneticoHmac;
        $this->paiement = $paiement;
    }

    public function genererFormData(Demande $demande)
    {
        // Reference: unique, alphaNum (A-Z a-z 0-9), 12 characters max
        $sReference = $demande->getReference();

        // Amount : format  "xxxxx.yy" (no spaces)
        $sMontant = number_format($demande->getTotal(), 2, ',', ' ');

        // Currency : ISO 4217 compliant
        $sDevise  = "EUR";

        // Contextual information related to the order : JSON, UTF-8, hexadecimally encoded
        // cart details, shipping and delivery addresses, technical context
        $rawContexteCommand = '{
                        "billing" :
                        {
                                    "firstName" : '.$demande->getClient()->getNom().',
                                    "lastName" : '.$demande->getClient()->getPrenom().',
                                    "addressLine1" : '.$demande->getClient()->getAdresse().',
                                    "mobilePhone" : '.$demande->getClient()->getTelephone().',
                                    "city" : '.$demande->getClient()->getVille().',
                                    "postalCode" : '.$demande->getClient()->getCodePostal().',
                                    "country" : '.$demande->getClient()->getPays().',
                                    "email" : '.$demande->getClient()->getEmail().',
                        },
        }';

        $utf8ContexteCommande = utf8_encode( $rawContexteCommand );
        $sContexteCommande = base64_encode( $utf8ContexteCommande );

        // free texte : a bigger reference, session context for the return on the merchant website
        $sTexteLibre = "Reglement Visa en ligne";

        // transaction date : format d/m/y:h:m:s
        $sDate = date("d/m/Y:H:i:s");

        // Language of the company code
        $sLangue = "FR";

        // customer email
        $sEmail = $demande->getClient()->getEmail();

        // -------------------------------------------------------------------------------------------------------------------------------------------------------------
        // SECTION PAIEMENT FRACTIONNE - Section spécifique au paiement fractionné
        //
        // INSTALMENT PAYMENT SECTION - Section specific to the installment payment
        // -------------------------------------------------------------------------------------------------------------------------------------------------------------

        // between 2 and 4
        // entre 2 et 4
        //$sNbrEch = "4";
        $sNbrEch = "";

        // date echeance 1 - format dd/mm/yyyy
        //$sDateEcheance1 = date("d/m/Y");
        $sDateEcheance1 = "";

        // montant �ch�ance 1 - format  "xxxxx.yy" (no spaces)
        //$sMontantEcheance1 = "0.26" . $sDevise;
        $sMontantEcheance1 = "";

        // date echeance 2 - format dd/mm/yyyy
        $sDateEcheance2 = "";

        // montant �ch�ance 2 - format  "xxxxx.yy" (no spaces)
        //$sMontantEcheance2 = "0.25" . $sDevise;
        $sMontantEcheance2 = "";

        // date echeance 3 - format dd/mm/yyyy
        $sDateEcheance3 = "";

        // montant �ch�ance 3 - format  "xxxxx.yy" (no spaces)
        //$sMontantEcheance3 = "0.25" . $sDevise;
        $sMontantEcheance3 = "";

        // date echeance 4 - format dd/mm/yyyy
        $sDateEcheance4 = "";

        // montant �ch�ance 4 - format  "xxxxx.yy" (no spaces)
        //$sMontantEcheance4 = "0.25" . $sDevise;
        $sMontantEcheance4 = "";

        // =============================================================================================================================================================
        // FIN SECTION PAIEMENT
        //
        // END PAYMENT SECTION
        // =============================================================================================================================================================

        // =============================================================================================================================================================
        // SECTION CODE : Cette section ne doit pas être modifiée
        //
        // CODE SECTION : This section must not be modified
        // =============================================================================================================================================================

        $oEpt = $this->moneticoEpt;
        $this->moneticoHmac->setUsableKey($oEpt);
        $oHmac = $this->moneticoHmac;

        // Control String for support
        $CtlHmac = sprintf($_ENV['MONETICOPAIEMENT_CTLHMAC'], $_ENV['MONETICOPAIEMENT_VERSION'], $oEpt->sVersion, $oEpt->sNumero, $oHmac->computeHmac(sprintf($_ENV['MONETICOPAIEMENT_CTLHMACSTR'], $oEpt->sVersion, $oEpt->sNumero)));

        // Data to certify
        $phase1go_fields = implode(
        '*',
        [
            "TPE={$oEpt->sNumero}",
            "contexte_commande=$sContexteCommande",
            "date=$sDate",
            "dateech1=$sDateEcheance1",
            "dateech2=$sDateEcheance2",
            "dateech3=$sDateEcheance3",
            "dateech4=$sDateEcheance4",
            "lgue=$sLangue",
            "mail=$sEmail",
            "montant=$sMontant{$sDevise}",
            "montantech1=$sMontantEcheance1",
            "montantech2=$sMontantEcheance2",
            "montantech3=$sMontantEcheance3",
            "montantech4=$sMontantEcheance4",
            "nbrech=$sNbrEch",
            "reference=$sReference",
            "societe={$oEpt->sCodeSociete}",
            "texte-libre=$sTexteLibre",
            "url_retour_err=$oEpt->sUrlKO",
            "url_retour_ok=$oEpt->sUrlOK",
            "version={$oEpt->sVersion}"
        ]
        );

        // MAC computation
        $sMAC = $oHmac->computeHmac($phase1go_fields);

        $formdata = array(
            'version' => $oEpt->sVersion,
            'TPE' => $oEpt->sNumero,
            'date' => $sDate,
            'montant' => $sMontant . $sDevise,
            'reference' => $sReference,
            'MAC' => $sMAC,
            'url_retour' => $oEpt->sUrlKO . '/' . $demande->getId(),
            'url_retour_ok' => $oEpt->sUrlOK . '/' . $demande->getId(),
            'url_retour_err' => $oEpt->sUrlKO . '/' . $demande->getId(),
            'lgue' => $oEpt->sLangue,
            'societe' => $oEpt->sCodeSociete,
            'textelibre' => $this->moneticoHmac->HtmlEncode($sTexteLibre),
            'mail' => $sEmail,
            'nbrech' => $sNbrEch,
            'dateech1' => $sDateEcheance1,
            'montantech1' => $sMontantEcheance1,
            'dateech2' => $sDateEcheance2,
            'montantech2' => $sMontantEcheance2,
            'dateech3' => $sDateEcheance3,
            'montantech3' => $sMontantEcheance3,
            'dateech4' => $sDateEcheance4,
            'montantech4' => $sMontantEcheance4,
        );
        
        return $formdata;
    }

    public function getFormAction()
    {
        return $this->moneticoEpt->sUrlPaiement;
    }
    
    // ----------------------------------------------------------------------------
    // function getMethode 
    //
    // IN: 
    // OUT: Donn�es soumises par GET ou POST / Data sent by GET or POST
    // description: Renvoie le tableau des donn�es / Send back the data array
    // ----------------------------------------------------------------------------

    public function getMethode(Request $request)
    {
        if ($request->isMethod('get'))
            return $request->query->all();
            
            if ($request->isMethod('post'))
                return $request->request->all();
                
                die ('Invalid REQUEST_METHOD (not GET, not POST).');
    }

    // ----------------------------------------------------------------------------
    // function HtmlEncode
    //
    // IN:  chaine a encoder / String to encode
    // OUT: Chaine encod�e / Encoded string
    //
    // Description: Encode special characters under HTML format
    //                           ********************
    //              Encodage des caract�res sp�ciaux au format HTML
    // ----------------------------------------------------------------------------
    function HtmlEncode ($data)
    {
        $SAFE_OUT_CHARS = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890._-";
        $encoded_data = "";
        $result = "";
        for ($i=0; $i<strlen($data); $i++)
        {
            if (strchr($SAFE_OUT_CHARS, $data{$i})) {
                $result .= $data{$i};
            }
            else if (($var = bin2hex(substr($data,$i,1))) <= "7F"){
                $result .= "&#x" . $var . ";";
            }
            else
                $result .= $data{$i};
                
        }
        return $result;
    }

    // =============================================================================================================================================================
    // SECTION CODE : Cette section ne doit pas être modifiée
    //
    // CODE SECTION : This section must not be modified
    // =============================================================================================================================================================
    
    public function callback(Request $request)
    {
        // Begin Main : Retrieve Variables posted by Monetico Paiement Server
        $MoneticoPaiement_bruteVars = $this->getMethode($request);

        // TPE init variables
        $oEpt = $this->moneticoEpt;
        $this->moneticohmac->setUsableKey($oEpt);
        $oHmac = $this->moneticohmac;


        // Message Authentication
        $MAC_source = computeHmacSource($MoneticoPaiement_bruteVars, $oEpt);
        $computed_MAC = $oHmac->computeHmac($MAC_source);
        $congruent_MAC = array_key_exists('MAC', $MoneticoPaiement_bruteVars) &&
        $computed_MAC == strtolower($MoneticoPaiement_bruteVars['MAC']);

        if ($congruent_MAC)
        {
        // =============================================================================================================================================================
        // FIN SECTION CODE
        //
        // END CODE SECTION
        // =============================================================================================================================================================

        // =============================================================================================================================================================
        // SECTION IMPLEMENTATION : Vous devez modifier ce code afin d'y mettre votre propre logique métier
        //
        // IMPLEMENTATION SECTION : You must adapt this code with your own application logic.
        // =============================================================================================================================================================

            switch($MoneticoPaiement_bruteVars['code-retour']) {

                case "Annulation" :
                    // Paiement refusé
                    // Insérez votre code ici (envoi d'email / mise à jour base de données)
                    // Attention : une autorisation peut toujours être délivrée pour ce paiement
                    //
                    // Payment has been refused
                    // put your code here (email sending / Database update)
                    // Attention : an authorization may still be delivered for this payment
                    break;

                case "payetest":
                    // Paiement accepté sur le serveur de test
                    // Insérez votre code ici (envoi d'email / mise à jour base de données)
                    //
                    // Payment has been accepted on the test server
                    // put your code here (email sending / Database update)
                    $this->paiement->paiementValider($MoneticoPaiement_bruteVars['reference']);
                    break;

                case "paiement":
                    // Paiement accepté sur le serveur de production
                    // Insérez votre code ici (envoi d'email / mise à jour base de données)
                    //
                    // Payment has been accepted on the productive server
                    // put your code here (email sending / Database update)
                    $this->paiement->paiementValider($MoneticoPaiement_bruteVars['reference']);
                    break;


                /*** SEULEMENT POUR LES PAIEMENTS FRACTIONNES ***/
                /***              ONLY FOR MULTIPART PAYMENT              ***/
                case "paiement_pf2":
                case "paiement_pf3":
                case "paiement_pf4":
                    // Paiement accepté sur le serveur de production pour l'échéance #N
                    // Le code de retour est du type paiement_pf[#N]
                    // Insérez votre code ici (envoi d'email / mise à jour base de données)
                    // Le montant du paiement pour cette échéance se trouve dans $MoneticoPaiement_bruteVars['montantech']
                    //
                    // Payment has been accepted on the productive server for the part #N
                    // return code is like paiement_pf[#N]
                    // put your code here (email sending / Database update)
                    // You have the amount of the payment part in $MoneticoPaiement_bruteVars['montantech']
                    break;

                case "Annulation_pf2":
                case "Annulation_pf3":
                case "Annulation_pf4":
                    // Paiement refusé sur le serveur de production pour l'échéance #N
                    // Le code de retour est du type Annulation_pf[#N]
                    // Insérez votre code ici (envoi d'email / mise à jour base de données)
                    // Le montant du paiement pour cette échéance se trouve dans $MoneticoPaiement_bruteVars['montantech']
                    //
                    // Payment has been refused on the productive server for the part #N
                    // return code is like Annulation_pf[#N]
                    // put your code here (email sending / Database update)
                    // You have the amount of the payment part in $MoneticoPaiement_bruteVars['montantech']
                    break;
            }

        // =============================================================================================================================================================
        // FIN SECTION IMPLEMENTATION
        //
        // END IMPLEMENTATION SECTION
        // =============================================================================================================================================================

        // =============================================================================================================================================================
        // SECTION CODE 2 : Cette section ne doit pas être modifiée
        //
        // CODE SECTION 2 : This section must not be modified
        // =============================================================================================================================================================

            $receipt = $_ENV['MONETICOPAIEMENT_PHASE2BACK_MACOK'];

        }
        else
        {
            // traitement en cas de HMAC incorrect
            // your code if the HMAC doesn't match
        $receipt = $_ENV['MONETICOPAIEMENT_PHASE2BACK_MACNOTOK'].$computed_MAC.
            "\n$MAC_source";
            ;
        }

        // =============================================================================================================================================================
        // FIN SECTION CODE 2
        //
        // END CODE SECTION 2
        // =============================================================================================================================================================

        //-----------------------------------------------------------------------------
        // Send receipt to Monetico Paiement server
        //-----------------------------------------------------------------------------
        return printf ($_ENV['MONETICOPAIEMENT_PHASE2BACK_RECEIPT'], $receipt);

        // Copyright (c) 2014 Euro-Information
        // All rights reserved. ---
        
    }

    function computeHmacSource($source, $oEpt)
    {
        $anomalies = null;
        if( array_key_exists('TPE', $source) )
            $anomalies = $source["TPE"] != $oEpt->sNumero ? ":TPE" : null;
        if( array_key_exists('version', $source) )
            $anomalies .= $source["version"] == $oEpt->sVersion ? ":version" : null;

        // sole field to exclude from the MAC computation
        if( array_key_exists('MAC', $source) )
            unset($source['MAC']);
        else
            $anomalies .= ":MAC";

        if($anomalies != null)
            return "anomaly_detected" . $anomalies;

        // order by key is mandatory
        ksort($source);
        // map entries to "key=value" to match the target format
        array_walk($source, function(&$a, $b) { $a = "$b=$a"; });
        // join all entries using asterisk as separator
        return implode( '*', $source);
    }
}