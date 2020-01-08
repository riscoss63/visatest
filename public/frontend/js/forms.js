var progressSteps = $('div.progress-steps div.step');

$('#date1').date

$(document).ready(function(){
    var submitButton = $(".form-step a.btn-next");
    var previousButton = $('.previous-arrow');
    var addCountryButton = $('.add-country');
    var addCityButton = $('.add-city');
    var rangeBox = $('.range-box');

    setProgressBar();

    if($('.countrypicker').length){
        populateCountrySelect();
    }

    if ($('#phone').length){
        setTelInputWithLibrary();
    }
	if ($('#telephone').length){
        setTelInputWithLibraryMobile();
    }
    if($('.russia-cities').length){
        populateCitySelect();
    }

    $('.addVoyageur').click(function(){
        $('#accordeon').append($(".card:first").clone(true, true));
    })
    submitButton.on('click', function(){
        goToNextScreen();
    });

    previousButton.on('click', function () {
        goToLastScreen();
    });

    addCountryButton.on('click', function () {
        addSelectCountryBelow(addCountryButton);
    });
    

    addCityButton.on('click', function () {
        addSelectCityBelow(addCityButton);
    });

    rangeBox.on('click', function(){
        changeQuantity();
    });
	//Change la couleur du label des formulaire (version mobile) au focus
	$("#codePostal0").focus(function(){
        $("label[for=codePostal0]").css("color", "#cccc00");
		$("label[for=codePostal0]").css("transform", "translateY(-100%)");
    });
	
	
	$("#ville0").focus(function(){
        $("label[for=ville0]").css("color", "#cccc00");
		$("label[for=ville0]").css("transform", "translateY(-100%)");
	});
	$("#numeroVol").focus(function(){
        $("label[for=numeroVol]").css("color", "#cccc00");
		$("label[for=numeroVol]").css("transform", "translateY(-100%)");
    });
	$("#jourVol").focus(function(){
        $("label[for=jourVol]").css("color", "#cccc00");
		$("label[for=jourVol]").css("transform", "translateY(-100%)");
    });
	$("#nomAssure1").focus(function(){
        $("label[for=nomAssure1]").css("color", "#cccc00");
		$("label[for=nomAssure1]").css("transform", "translateY(-100%)");
    });
	$("#prenomAssure1").focus(function(){
        $("label[for=prenomAssure1]").css("color", "#cccc00");
		$("label[for=prenomAssure1]").css("transform", "translateY(-100%)");
	});
	$("#nomAssure2").focus(function(){
        $("label[for=nomAssure2]").css("color", "#cccc00");
		$("label[for=nomAssure2]").css("transform", "translateY(-100%)");
    });
	$("#prenomAssure2").focus(function(){
        $("label[for=prenomAssure2]").css("color", "#cccc00");
		$("label[for=prenomAssure2]").css("transform", "translateY(-100%)");
	});
    $("#nomSociete").focus(function(){
        $("label[for=nomSociete]").css("color", "#cccc00");
		$("label[for=nomSociete]").css("transform", "translateY(-100%)");
    });
	$("#nom").focus(function(){
        $("label[for=nom]").css("color", "#cccc00");
		$("label[for=nom]").css("transform", "translateY(-100%)");
    });
	$("#prenom").focus(function(){
        $("label[for=prenom]").css("color", "#cccc00");
		$("label[for=prenom]").css("transform", "translateY(-100%)");
    });
	$("#adresse").focus(function(){
        $("label[for=adresse]").css("color", "#cccc00");
		$("label[for=adresse]").css("transform", "translateY(-100%)");
    });
	$("#codePostal").focus(function(){
        $("label[for=codePostal]").css("color", "#cccc00");
		$("label[for=codePostal]").css("transform", "translateY(-100%)");
		
    });
    $('#numero-passeport').focus(function(){
        $("label[for=numero-passeport]").css("color","#cccc00");
        $("label[for=numero-passeport]").css("transform","translateY(-100%)");
    });

    $('#date-expiration').focus(function(){
        $("label[for=date-expiration]").css("color","#cccc00");
        $("label[for=date-expiration]").css("transform","translateY(-100%)");
    });

	$("#ville").focus(function(){
        $("label[for=ville]").css("color", "#cccc00");
		$("label[for=ville]").css("transform", "translateY(-100%)");
    });
	$("#telephone").focus(function(){
        $("label[for=telephone]").css("color", "#cccc00");
		$("label[for=telephone]").css("transform", "translate(-25%,-200%)");
		$("label[for=telephone]").css("background", "url(images/phone-green.svg) no-repeat left, top");
    });

    //  hide/show particulier-entreprise
    $('#choix').on('change', function(){
        if($(this).val()=== "Entreprise"){
            $('#nomSociete').show()
        }else{
            $('#nomSociete').hide()
        }
    });
    
});

function populateCountrySelect() {
    $(function() {
        // The isoCountries should be retrieved from JSON file from back. Data below is complete.
        var isoCountries = [
            { id: 'FR', text: 'France'},
            { id: 'AF', text: 'Afghanistan'},
            { id: 'AF', text: 'Afrique du Sud'},
            { id: 'AL', text: 'Albanie'},
            { id: 'DZ', text: 'Algérie'},
            { id: 'DE', text: 'Allemagne'},
            { id: 'AD', text: 'Andorre'},
            { id: 'AO', text: 'Angola'},
            { id: 'AI', text: 'Anguilla'},
            { id: 'AQ', text: 'Antarctique'},
            { id: 'AG', text: 'Antigua-et-Barbuda'},
            { id: 'AN', text: 'Antilles Néerlandaises'},
            { id: 'SA', text: 'Arabie Saoudite'},
            { id: 'AR', text: 'Argentine'},
            { id: 'AM', text: 'Arménie'},
            { id: 'AW', text: 'Aruba'},
            { id: 'AU', text: 'Australie'},
            { id: 'AT', text: 'Autriche'},
            { id: 'AZ', text: 'Azerbaïdjan'},
            { id: 'BS', text: 'Bahamas'},
            { id: 'BH', text: 'Bahreïn'},
            { id: 'BD', text: 'Bangladesh'},
            { id: 'BB', text: 'Barbade'},
            { id: 'BY', text: 'Bélarus'},
            { id: 'BE', text: 'Belgique'},
            { id: 'BZ', text: 'Belize'},
            { id: 'BJ', text: 'Bénin'},
            { id: 'BM', text: 'Bermudes'},
            { id: 'BT', text: 'Bhoutan'},
            { id: 'BO', text: 'Bolivie'},
            { id: 'BA', text: 'Bosnie-Herzégovine'},
            { id: 'BW', text: 'Botswana'},
            { id: 'BR', text: 'Brésil'},
            { id: 'BN', text: 'Brunéi Darussalam'},
            { id: 'BG', text: 'Bulgarie'},
            { id: 'BF', text: 'Burkina Faso'},
            { id: 'BI', text: 'Burundi'},
            { id: 'KH', text: 'Cambodge'},
            { id: 'CM', text: 'Cameroun'},
            { id: 'CA', text: 'Canada'},
            { id: 'CV', text: 'Cap-vert'},
            { id: 'CL', text: 'Chili'},
            { id: 'CN', text: 'Chine'},
            { id: 'CY', text: 'Chypre'},
            { id: 'CO', text: 'Colombie'},
            { id: 'KM', text: 'Comores'},
            { id: 'CR', text: 'Costa Rica'},
            { id: 'CI', text: 'Côte D\'Ivoire'},
            { id: 'HR', text: 'Croatie'},
            { id: 'CU', text: 'Cuba'},
            { id: 'DK', text: 'Danemark'},
            { id: 'DJ', text: 'Djibouti'},
            { id: 'DM', text: 'Dominique'},
            { id: 'EG', text: 'Égypte'},
            { id: 'SV', text: 'El Salvador'},
            { id: 'AE', text: 'Émirats Arabes Unis'},
            { id: 'EC', text: 'Équateur'},
            { id: 'ER', text: 'Érytrée'},
            { id: 'ES', text: 'Espagne'},
            { id: 'EE', text: 'Estonie'},
            { id: 'FM', text: 'États Fédérés de Micronésie'},
            { id: 'US', text: 'États-Unis'},
            { id: 'ET', text: 'Éthiopie'},
            { id: 'RU', text: 'Fédération de Russie'},
            { id: 'FJ', text: 'Fidji'},
            { id: 'FI', text: 'Finlande'},
            { id: 'GA', text: 'Gabon'},
            { id: 'GM', text: 'Gambie'},
            { id: 'GE', text: 'Géorgie'},
            { id: 'GS', text: 'Géorgie du Sud et les Îles Sandwich du Sud'},
            { id: 'GH', text: 'Ghana'},
            { id: 'GI', text: 'Gibraltar'},
            { id: 'GR', text: 'Grèce'},
            { id: 'GD', text: 'Grenade'},
            { id: 'GL', text: 'Groenland'},
            { id: 'GP', text: 'Guadeloupe'},
            { id: 'GU', text: 'Guam'},
            { id: 'GT', text: 'Guatemala'},
            { id: 'GN', text: 'Guinée'},
            { id: 'GQ', text: 'Guinée-Équatoriale'},
            { id: 'GW', text: 'Guinea-Bissau'},
            { id: 'GY', text: 'Guyane'},
            { id: 'GY', text: 'Guyane Française'},
            { id: 'HT', text: 'Haïti'},
            { id: 'HN', text: 'Honduras'},
            { id: 'HK', text: 'Hong-Kong'},
            { id: 'HU', text: 'Hongrie'},
            { id: 'BV', text: 'Île Bouvet'},
            { id: 'CX', text: 'Île Christmas'},
            { id: 'IM', text: 'Île de Man'},
            { id: 'NF', text: 'Île Norfolk'},
            { id: 'FK', text: 'Îles (malvinas) Falkland'},
            { id: 'AX', text: 'Îles Åland'},
            { id: 'KY', text: 'Îles Caïmanes'},
            { id: 'CC', text: 'Îles Cocos (Keeling)'},
            { id: 'CK', text: 'Îles Cook'},
            { id: 'FO', text: 'Îles Féroé'},
            { id: 'HM', text: 'Îles Heard et Mcdonald'},
            { id: 'MP', text: 'Îles Mariannes du Nord'},
            { id: 'MH', text: 'Îles Marshall'},
            { id: 'UM', text: 'Îles Mineures Éloignées des États-Unis'},
            { id: 'SB', text: 'Îles Salomon'},
            { id: 'TC', text: 'Îles Turks et Caïques'},
            { id: 'VG', text: 'Îles Vierges Britanniques'},
            { id: 'VI', text: 'Îles Vierges des États-Unis'},
            { id: 'IN', text: 'Inde'},
            { id: 'ID', text: 'Indonésie'},
            { id: 'IQ', text: 'Iraq'},
            { id: 'IE', text: 'Irlande'},
            { id: 'IS', text: 'Islande'},
            { id: 'IL', text: 'Israël'},
            { id: 'IT', text: 'Italie'},
            { id: 'LY', text: 'Jamahiriya Arabe Libyenne'},
            { id: 'JM', text: 'Jamaïque'},
            { id: 'JP', text: 'Japon'},
            { id: 'JO', text: 'Jordanie'},
            { id: 'KZ', text: 'Kazakhstan'},
            { id: 'KE', text: 'Kenya'},
            { id: 'KG', text: 'Kirghizistan'},
            { id: 'KI', text: 'Kiribati'},
            { id: 'KW', text: 'Koweït'},
            { id: 'LS', text: 'Lesotho'},
            { id: 'LV', text: 'Lettonie'},
            { id: 'MK', text: 'L\'ex-République Yougoslave de Macédoine'},
            { id: 'LB', text: 'Liban'},
            { id: 'LR', text: 'Libéria'},
            { id: 'LI', text: 'Liechtenstein'},
            { id: 'LT', text: 'Lithuanie'},
            { id: 'LU', text: 'Luxembourg'},
            { id: 'MO', text: 'Macao'},
            { id: 'MG', text: 'Madagascar'},
            { id: 'MY', text: 'Malaisie'},
            { id: 'MW', text: 'Malawi'},
            { id: 'MV', text: 'Maldives'},
            { id: 'ML', text: 'Mali'},
            { id: 'MT', text: 'Malte'},
            { id: 'MA', text: 'Maroc'},
            { id: 'MQ', text: 'Martinique'},
            { id: 'MU', text: 'Maurice'},
            { id: 'MR', text: 'Mauritanie'},
            { id: 'YT', text: 'Mayotte'},
            { id: 'MX', text: 'Mexique'},
            { id: 'MC', text: 'Monaco'},
            { id: 'MN', text: 'Mongolie'},
            { id: 'MS', text: 'Montserrat'},
            { id: 'MZ', text: 'Mozambique'},
            { id: 'MM', text: 'Myanmar'},
            { id: 'NA', text: 'Namibie'},
            { id: 'NR', text: 'Nauru'},
            { id: 'NP', text: 'Népal'},
            { id: 'NI', text: 'Nicaragua'},
            { id: 'NE', text: 'Niger'},
            { id: 'NG', text: 'Nigéria'},
            { id: 'NU', text: 'Niué'},
            { id: 'NO', text: 'Norvège'},
            { id: 'NC', text: 'Nouvelle-Calédonie'},
            { id: 'NZ', text: 'Nouvelle-Zélande'},
            { id: 'OM', text: 'Oman'},
            { id: 'UG', text: 'Ouganda'},
            { id: 'UZ', text: 'Ouzbékistan'},
            { id: 'PK', text: 'Pakistan'},
            { id: 'PW', text: 'Palaos'},
            { id: 'PA', text: 'Panama'},
            { id: 'PG', text: 'Papouasie-Nouvelle-Guinée'},
            { id: 'PY', text: 'Paraguay'},
            { id: 'NL', text: 'Pays-Bas'},
            { id: 'PE', text: 'Pérou'},
            { id: 'PH', text: 'Philippines'},
            { id: 'PN', text: 'Pitcairn'},
            { id: 'PL', text: 'Pologne'},
            { id: 'PF', text: 'Polynésie Française'},
            { id: 'PR', text: 'Porto Rico'},
            { id: 'PT', text: 'Portugal'},
            { id: 'QA', text: 'Qatar'},
            { id: 'SY', text: 'République Arabe Syrienne'},
            { id: 'CF', text: 'République Centrafricaine'},
            { id: 'KR', text: 'République de Corée'},
            { id: 'MD', text: 'République de Moldova'},
            { id: 'CD', text: 'République Démocratique du Congo'},
            { id: 'LA', text: 'République Démocratique Populaire Lao'},
            { id: 'DO', text: 'République Dominicaine'},
            { id: 'CG', text: 'République du Congo'},
            { id: 'IR', text: 'République Islamique d\'Iran'},
            { id: 'KP', text: 'République Populaire Démocratique de Corée'},
            { id: 'CZ', text: 'République Tchèque'},
            { id: 'TZ', text: 'République-Unie de Tanzanie'},
            { id: 'RE', text: 'Réunion'},
            { id: 'RO', text: 'Roumanie'},
            { id: 'GB', text: 'Royaume-Uni'},
            { id: 'RW', text: 'Rwanda'},
            { id: 'EH', text: 'Sahara Occidental'},
            { id: 'SH', text: 'Sainte Hélène'},
            { id: 'LC', text: 'Sainte Lucie'},
            { id: 'KN', text: 'Saint-Kitts-et-Nevis'},
            { id: 'SM', text: 'Saint-Marin'},
            { id: 'PM', text: 'Saint-Pierre-et-Miquelon'},
            { id: 'PM', text: 'Saint-Siège (état de la Cité du Vatican'},
            { id: 'VC', text: 'Saint-Vincent-et-les-Grenadines'},
            { id: 'WS', text: 'Samoa'},
            { id: 'AS', text: 'Samoa Américaines'},
            { id: 'ST', text: 'Sao Tomé-et-Principe'},
            { id: 'SN', text: 'Sénégal'},
            { id: 'RS', text: 'Serbie-et-Monténégro'},
            { id: 'SC', text: 'Seychelles'},
            { id: 'SL', text: 'Sierra Leone'},
            { id: 'SG', text: 'Singapour'},
            { id: 'SK', text: 'Slovaquie'},
            { id: 'SI', text: 'Slovénie'},
            { id: 'SO', text: 'Somalie'},
            { id: 'SD', text: 'Soudan'},
            { id: 'LK', text: 'Sri Lanka'},
            { id: 'SE', text: 'Suède'},
            { id: 'CH', text: 'Suisse'},
            { id: 'SR', text: 'Suriname'},
            { id: 'SJ', text: 'Svalbard et Île Jan Mayen'},
            { id: 'SZ', text: 'Swaziland'},
            { id: 'TJ', text: 'Tadjikistan'},
            { id: 'TW', text: 'Taïwan'},
            { id: 'TD', text: 'Tchad'},
            { id: 'TF', text: 'Terres Australes Françaises'},
            { id: 'IO', text: 'Territoire Britannique de l\'Océan Indien'},
            { id: 'PS', text: 'Territoire Palestinien Occupé'},
            { id: 'TH', text: 'Thaïlande'},
            { id: 'TL', text: 'Timor-Leste'},
            { id: 'TG', text: 'Togo'},
            { id: 'TK', text: 'Tokelau'},
            { id: 'TO', text: 'Tonga'},
            { id: 'TT', text: 'Trinité-et-Tobago'},
            { id: 'TN', text: 'Tunisie'},
            { id: 'TM', text: 'Turkménistan'},
            { id: 'TR', text: 'Turquie'},
            { id: 'TV', text: 'Tuvalu'},
            { id: 'UA', text: 'Ukraine'},
            { id: 'UY', text: 'Uruguay'},
            { id: 'VU', text: 'Vanuatu'},
            { id: 'VE', text: 'Venezuela'},
            { id: 'VN', text: 'Viet Nam'},
            { id: 'WF', text: 'Wallis And Futuna'},
            { id: 'YE', text: 'Yémen'},
            { id: 'ZM', text: 'Zambie'},
            { id: 'ZW', text: 'Zimbabwe'}
        ];

        function formatCountry (country) {
            if (!country.id) { return country.text; }
            var $country = $(
                '<span class="flag-icon flag-icon-'+ country.id.toLowerCase() +' flag-icon-squared"></span>' +
                '<span class="flag-text">'+ country.text+"</span>"
            );
            return $country;
        }

        $("[name='registration[pays]']").select2({
            templateSelection: formatCountry,
            templateResult: formatCountry,
            data: isoCountries
        });
    });
}

function populateCitySelect(){
    $(function() {
        // The isoCountries should be retrieved from JSON file from back. Data below is complete.
        var isoRussiaCities = [
            { text: "Moscow", id: "RU" },
            { text: "Saint Petersburg", id: "RU" },
            { text: "Novosibirsk", id: "RU" },
            { text: "Yekaterinburg", id: "RU" },
            { text: "Nizhniy Novgorod", id: "RU" },
            { text: "Samara", id: "RU" },
            { text: "Omsk", id: "RU" },
            { text: "Kazan'", id: "RU" },
            { text: "Chelyabinsk", id: "RU" },
            { text: "Rostov-na-Donu", id: "RU" },
            { text: "Ufa", id: "RU" },
            { text: "Perm'", id: "RU" },
            { text: "Volgograd", id: "RU" },
            { text: "Krasnoyarsk", id: "RU" },
            { text: "Voronezh", id: "RU" },
            { text: "Saratov", id: "RU" },
            { text: "Krasnodar", id: "RU" },
            { text: "Ul'yanovsk", id: "RU" },
            { text: "Izhevsk", id: "RU" },
            { text: "Yaroslavl'", id: "RU" },
            { text: "Barnaul", id: "RU" },
            { text: "Vladivostok", id: "RU" },
            { text: "Irkutsk", id: "RU" },
            { text: "Khabarovsk", id: "RU" },
            { text: "Makhachkala", id: "RU" },
            { text: "Orenburg", id: "RU" },
            { text: "Novokuznetsk", id: "RU" },
            { text: "Tomsk", id: "RU" },
            { text: "Ryazan'", id: "RU" },
            { text: "Tyumen'", id: "RU" },
            { text: "Lipetsk", id: "RU" },
            { text: "Penza", id: "RU" },
            { text: "Astrakhan'", id: "RU" },
            { text: "Tula", id: "RU" },
            { text: "Kemerovo", id: "RU" },
            { text: "Krasnyye Chelny", id: "RU" },
            { text: "Kirov", id: "RU" },
            { text: "Cheboksary", id: "RU" },
            { text: "Kaliningrad", id: "RU" },
            { text: "Bryansk", id: "RU" },
            { text: "Afanasovo", id: "RU" },
            { text: "Magnitogorsk", id: "RU" },
            { text: "Kursk", id: "RU" },
            { text: "Tver'", id: "RU" },
            { text: "Surgut", id: "RU" },
            { text: "Nizhniy Tagil", id: "RU" },
            { text: "Vladikavkaz", id: "RU" },
            { text: "Stavropol'", id: "RU" },
            { text: "Ulan-Ude", id: "RU" },
            { text: "Arkhangel'sk", id: "RU" },
            { text: "Belgorod", id: "RU" },
            { text: "Kurgan", id: "RU" },
            { text: "Kaluga", id: "RU" },
            { text: "Orël", id: "RU" },
            { text: "Novyy Sochi", id: "RU" },
            { text: "Yoshkar-Ola", id: "RU" },
            { text: "Volzhskiy", id: "RU" },
            { text: "Smolensk", id: "RU" },
            { text: "Podol'sk", id: "RU" },
            { text: "Murmansk", id: "RU" },
            { text: "Vladimir", id: "RU" },
            { text: "Cherepovets", id: "RU" },
            { text: "Chita", id: "RU" },
            { text: "Nal'chik", id: "RU" },
            { text: "Saransk", id: "RU" },
            { text: "Tambov", id: "RU" },
            { text: "Vologda", id: "RU" },
            { text: "Taganrog", id: "RU" },
            { text: "Kostroma", id: "RU" },
            { text: "Komsomol'sk-na-Amure", id: "RU" },
            { text: "Prokop'yevsk", id: "RU" },
            { text: "Sterlitamak", id: "RU" },
            { text: "Petrozavodsk", id: "RU" },
            { text: "Dzerzhinsk", id: "RU" },
            { text: "Orsk", id: "RU" },
            { text: "Bratsk", id: "RU" },
            { text: "Nizhnevartovsk", id: "RU" },
            { text: "Angarsk", id: "RU" },
            { text: "Novorossiysk", id: "RU" },
            { text: "Yakutsk", id: "RU" },
            { text: "Nizhnekamsk", id: "RU" },
            { text: "Syktyvkar", id: "RU" },
            { text: "Noginsk", id: "RU" },
            { text: "Noginsk", id: "RU" },
            { text: "Staryy Oskol", id: "RU" },
            { text: "Groznyy", id: "RU" },
            { text: "Kolpino", id: "RU" },
            { text: "Shakhty", id: "RU" },
            { text: "Blagoveshchensk", id: "RU" },
            { text: "Velikiy Novgorod", id: "RU" },
            { text: "Rybinsk", id: "RU" },
            { text: "Biysk", id: "RU" },
            { text: "Pskov", id: "RU" },
            { text: "Balakovo", id: "RU" },
            { text: "Armavir", id: "RU" },
            { text: "Engel's", id: "RU" },
            { text: "Severodvinsk", id: "RU" },
            { text: "Zlatoust", id: "RU" },
            { text: "Syzran'", id: "RU" },
            { text: "Petropavlovsk-Kamchatskiy", id: "RU" },
            { text: "Kamensk-Ural'skiy", id: "RU" },
            { text: "Yuzhno-Sakhalinsk", id: "RU" },
            { text: "Berezniki", id: "RU" },
            { text: "Volgodonsk", id: "RU" },
            { text: "Miass", id: "RU" },
            { text: "Abakan", id: "RU" },
            { text: "Novocherkassk", id: "RU" },
            { text: "Noril'sk", id: "RU" },
            { text: "Rubtsovsk", id: "RU" },
            { text: "Salavat", id: "RU" },
            { text: "Nakhodka", id: "RU" },
            { text: "Nakhodka", id: "RU" },
            { text: "Maykop", id: "RU" },
            { text: "Ussuriysk", id: "RU" },
            { text: "Kovrov", id: "RU" },
            { text: "Novokuybyshevsk", id: "RU" },
            { text: "Kolomna", id: "RU" },
            { text: "Pyatigorsk", id: "RU" },
            { text: "Arzamas", id: "RU" },
            { text: "Al'met'yevsk", id: "RU" },
            { text: "Orekhovo-Zuyevo", id: "RU" },
            { text: "Serpukhov", id: "RU" },
            { text: "Nevinnomyssk", id: "RU" },
            { text: "Pervoural'sk", id: "RU" },
            { text: "Kislovodsk", id: "RU" },
            { text: "Dimitrovgrad", id: "RU" },
            { text: "Muromskiy", id: "RU" },
            { text: "Novomoskovsk", id: "RU" },
            { text: "Kamyshin", id: "RU" },
            { text: "Neftekamsk", id: "RU" },
            { text: "Achinsk", id: "RU" },
            { text: "Vyborg", id: "RU" },
            { text: "Cherkessk", id: "RU" },
            { text: "Yelets", id: "RU" },
            { text: "Tobol'sk", id: "RU" },
            { text: "Nefteyugansk", id: "RU" },
            { text: "Noyabr'sk", id: "RU" },
            { text: "Bataysk", id: "RU" },
            { text: "Sergiyev Posad", id: "RU" },
            { text: "Leninsk-Kuznetskiy", id: "RU" },
            { text: "Kyzyl", id: "RU" },
            { text: "Oktyabr'skiy", id: "RU" },
            { text: "Obninsk", id: "RU" },
            { text: "Chapayevsk", id: "RU" },
            { text: "Elista", id: "RU" },
            { text: "Kandalaksha", id: "RU" },
            { text: "Novotroitsk", id: "RU" },
            { text: "Derbent", id: "RU" },
            { text: "Kiselëvsk", id: "RU" },
            { text: "Velikiye Luki", id: "RU" },
            { text: "Ukhta", id: "RU" },
            { text: "Kansk", id: "RU" },
            { text: "Sarapul", id: "RU" },
            { text: "Solikamsk", id: "RU" },
            { text: "Glazov", id: "RU" },
            { text: "Ust'-Ilimsk", id: "RU" },
            { text: "Novoshakhtinsk", id: "RU" },
            { text: "Tuapse", id: "RU" },
            { text: "Votkinsk", id: "RU" },
            { text: "Serov", id: "RU" },
            { text: "Balashov", id: "RU" },
            { text: "Zheleznogorsk", id: "RU" },
            { text: "Kuznetsk", id: "RU" },
            { text: "Magadan", id: "RU" },
            { text: "Novyy Urengoy", id: "RU" },
            { text: "Imeni Michurina", id: "RU" },
            { text: "Nazran'", id: "RU" },
            { text: "Kineshma", id: "RU" },
            { text: "Bugul'ma", id: "RU" },
            { text: "Novoaltaysk", id: "RU" },
            { text: "Gatchina", id: "RU" },
            { text: "Kirovo-Chepetsk", id: "RU" },
            { text: "Yegor'yevsk", id: "RU" },
            { text: "Yeysk", id: "RU" },
            { text: "Buzuluk", id: "RU" },
            { text: "Shchëkino", id: "RU" },
            { text: "Usol'ye-Sibirskoye", id: "RU" },
            { text: "Yurga", id: "RU" },
            { text: "Anzhero-Sudzhensk", id: "RU" },
            { text: "Troitsk", id: "RU" },
            { text: "Kaspiysk", id: "RU" },
            { text: "Asbest", id: "RU" },
            { text: "Klin", id: "RU" },
            { text: "Vorkuta", id: "RU" },
            { text: "Kropotkin", id: "RU" },
            { text: "Shadrinsk", id: "RU" },
            { text: "Birobidzhan", id: "RU" },
            { text: "Kamensk-Shakhtinskiy", id: "RU" },
            { text: "Buynaksk", id: "RU" },
            { text: "Georgiyevsk", id: "RU" },
            { text: "Chusovoy", id: "RU" },
            { text: "Chernogorsk", id: "RU" },
            { text: "Vol'sk", id: "RU" },
            { text: "Belogorsk", id: "RU" },
            { text: "Tuymazy", id: "RU" },
            { text: "Borisoglebsk", id: "RU" },
            { text: "Khanty-Mansiysk", id: "RU" },
            { text: "Ishim", id: "RU" },
            { text: "Oktyabr'skiy", id: "RU" },
            { text: "Apatity", id: "RU" },
            { text: "Aleksin", id: "RU" },
            { text: "Kungur", id: "RU" },
            { text: "Klintsy", id: "RU" },
            { text: "Neryungri", id: "RU" },
            { text: "Leninogorsk", id: "RU" },
            { text: "Lesosibirsk", id: "RU" },
            { text: "Polevskoy", id: "RU" },
            { text: "Kumertau", id: "RU" },
            { text: "Tikhoretsk", id: "RU" },
            { text: "Svobodnyy", id: "RU" },
            { text: "Rzhev", id: "RU" },
            { text: "Novaya Balakhna", id: "RU" },
            { text: "Belebey", id: "RU" },
            { text: "Chistopol'", id: "RU" },
            { text: "Tikhvin", id: "RU" },
            { text: "Labinsk", id: "RU" },
            { text: "Iskitim", id: "RU" },
            { text: "Vyksa", id: "RU" },
            { text: "Sibay", id: "RU" },
            { text: "Sal'sk", id: "RU" },
            { text: "Shuya", id: "RU" },
            { text: "Zima", id: "RU" },
            { text: "Kotlas", id: "RU" },
            { text: "Gorno-Altaysk", id: "RU" },
            { text: "Mikhaylovka", id: "RU" },
            { text: "Solnechnogorsk", id: "RU" },
            { text: "Arsen'yev", id: "RU" },
            { text: "Borovichi", id: "RU" },
            { text: "Cheremkhovo", id: "RU" },
            { text: "Roslavl'", id: "RU" },
            { text: "Nizhnyaya Tura", id: "RU" },
            { text: "Sayanogorsk", id: "RU" },
            { text: "Gelendzhik", id: "RU" },
            { text: "Vyaz'ma", id: "RU" },
            { text: "Krasnokamensk", id: "RU" },
            { text: "Severomorsk", id: "RU" },
            { text: "Vyshniy Volochëk", id: "RU" },
            { text: "Buguruslan", id: "RU" },
            { text: "Livny", id: "RU" },
            { text: "Krasnokamsk", id: "RU" },
            { text: "Tayshetka", id: "RU" },
            { text: "Nyagan'", id: "RU" },
            { text: "Kimry", id: "RU" },
            { text: "Tulun", id: "RU" },
            { text: "Kyshtym", id: "RU" },
            { text: "Otradnyy", id: "RU" },
            { text: "Kanash", id: "RU" },
            { text: "Monchegorsk", id: "RU" },
            { text: "Korshunovka", id: "RU" },
            { text: "Ruzayevka", id: "RU" },
            { text: "Verkhnyaya Salda", id: "RU" },
            { text: "Slobodskoy", id: "RU" },
            { text: "Megion", id: "RU" },
            { text: "Torzhok", id: "RU" },
            { text: "Belaya Kalitva", id: "RU" },
            { text: "Mtsensk", id: "RU" },
            { text: "Gryazi", id: "RU" },
            { text: "Mozhga", id: "RU" },
            { text: "Amursk", id: "RU" },
            { text: "Safonovo", id: "RU" },
            { text: "Alatyr'", id: "RU" },
            { text: "Nadym", id: "RU" },
            { text: "Pechora", id: "RU" },
            { text: "Spasskoye", id: "RU" },
            { text: "Apsheronsk", id: "RU" },
            { text: "Mozdok", id: "RU" },
            { text: "Volkhov", id: "RU" },
            { text: "Yefremov", id: "RU" },
            { text: "Gorod Shebekino", id: "RU" },
            { text: "Chernyakhovsk", id: "RU" },
            { text: "Usinsk", id: "RU" },
            { text: "Strezhevoy", id: "RU" },
            { text: "Yelkhovskiy", id: "RU" },
            { text: "Kamen'-na-Obi", id: "RU" },
            { text: "Akhtubinsk", id: "RU" },
            { text: "Timashevsk", id: "RU" },
            { text: "Alapayevsk", id: "RU" },
            { text: "Novozybkov", id: "RU" },
            { text: "Nizhneudinsk", id: "RU" },
            { text: "Sovetsk", id: "RU" },
            { text: "Mariinsk", id: "RU" },
            { text: "Krasnoufimsk", id: "RU" },
            { text: "Partizansk", id: "RU" },
            { text: "Sokol", id: "RU" },
            { text: "Yemanzhelinsk", id: "RU" },
            { text: "Lesozavodsk", id: "RU" },
            { text: "Uryupinsk", id: "RU" },
            { text: "Gay", id: "RU" },
            { text: "Zelenokumsk", id: "RU" },
            { text: "Birsk", id: "RU" },
            { text: "Frolovo", id: "RU" },
            { text: "Mirnyy", id: "RU" },
            { text: "Luga", id: "RU" },
            { text: "Ob'", id: "RU" },
            { text: "Uray", id: "RU" },
            { text: "Alekseyevka", id: "RU" },
            { text: "Bogoroditsk", id: "RU" },
            { text: "Tavda", id: "RU" },
            { text: "Kirov", id: "RU" },
            { text: "Vichuga", id: "RU" },
            { text: "Asha", id: "RU" },
            { text: "Gur'yevsk", id: "RU" },
            { text: "Millerovo", id: "RU" },
            { text: "Salekhard", id: "RU" },
            { text: "Uglich", id: "RU" },
            { text: "Tynda", id: "RU" },
            { text: "Kasimov", id: "RU" },
            { text: "Serdobsk", id: "RU" },
            { text: "Slantsy", id: "RU" },
            { text: "Severoural'sk", id: "RU" },
            { text: "Blagodarnyy", id: "RU" },
            { text: "Boyarka", id: "RU" },
            { text: "Yalutorovsk", id: "RU" },
            { text: "Valuyki", id: "RU" },
            { text: "Shar'ya", id: "RU" },
            { text: "Shumerlya", id: "RU" },
            { text: "Korsakov", id: "RU" },
            { text: "Bezhetsk", id: "RU" },
            { text: "Kondopoga", id: "RU" },
            { text: "Staraya Russa", id: "RU" },
            { text: "Slavgorod", id: "RU" },
            { text: "Verkhniy Ufaley", id: "RU" },
            { text: "Zaozërnyy", id: "RU" },
            { text: "Rostov", id: "RU" },
            { text: "Dyat'kovo", id: "RU" },
            { text: "Segezha", id: "RU" },
            { text: "Velikiy Ustyug", id: "RU" },
            { text: "Kotovsk", id: "RU" },
            { text: "Kholmsk", id: "RU" },
            { text: "Omutninsk", id: "RU" },
            { text: "Kudymkar", id: "RU" },
            { text: "Barabinsk", id: "RU" },
            { text: "Novaya Gubakha", id: "RU" },
            { text: "Sasovo", id: "RU" },
            { text: "Karpinsk", id: "RU" },
            { text: "Mednogorsk", id: "RU" },
            { text: "Borzya", id: "RU" },
            { text: "Svetogorsk", id: "RU" },
            { text: "Sovetskaya Gavan'", id: "RU" },
            { text: "Kirovsk", id: "RU" },
            { text: "Sosnogorsk", id: "RU" },
            { text: "Karasuk", id: "RU" },
            { text: "Kartaly", id: "RU" },
            { text: "Zheleznogorsk-Ilimskiy", id: "RU" },
            { text: "Kotel'nich", id: "RU" },
            { text: "Dal'nerechensk", id: "RU" },
            { text: "Nev'yansk", id: "RU" },
            { text: "Aleysk", id: "RU" },
            { text: "Kolpashevo", id: "RU" },
            { text: "Atkarsk", id: "RU" },
            { text: "Sol'-Iletsk", id: "RU" },
            { text: "Nikolayevsk-na-Amure", id: "RU" },
            { text: "Asino", id: "RU" },
            { text: "Zeya", id: "RU" },
            { text: "Tara", id: "RU" },
            { text: "Pugachev", id: "RU" },
            { text: "Okha", id: "RU" },
            { text: "Bakal", id: "RU" },
            { text: "Buy", id: "RU" },
            { text: "Vel'sk", id: "RU" },
            { text: "Krasnoarmeysk", id: "RU" },
            { text: "Severobaykal'sk", id: "RU" },
            { text: "Lensk", id: "RU" },
            { text: "Ust'-Kut", id: "RU" },
            { text: "Nelidovka", id: "RU" },
            { text: "Tatarsk", id: "RU" },
            { text: "Bologoye", id: "RU" },
            { text: "Topki", id: "RU" },
            { text: "Aldan", id: "RU" },
            { text: "Gusinoozërsk", id: "RU" },
            { text: "Kalachinsk", id: "RU" },
            { text: "Bogotol", id: "RU" },
            { text: "Dudinka", id: "RU" },
            { text: "L'gov", id: "RU" },
            { text: "Inta", id: "RU" },
            { text: "Tashtagol", id: "RU" },
            { text: "Onega", id: "RU" },
            { text: "Kizel", id: "RU" },
            { text: "Toguchin", id: "RU" },
            { text: "Nar'yan-Mar", id: "RU" },
            { text: "Shimanovsk", id: "RU" },
            { text: "Palatka", id: "RU" },
            { text: "Isil'kul'", id: "RU" },
            { text: "Petrovsk-Zabaykal'skiy", id: "RU" },
            { text: "Krasnoural'sk", id: "RU" },
            { text: "Cherepanovo", id: "RU" },
            { text: "Rayevskiy", id: "RU" },
            { text: "Yeniseysk", id: "RU" },
            { text: "Bikin", id: "RU" },
            { text: "Ivdel'", id: "RU" },
            { text: "Uzhur", id: "RU" },
            { text: "Polyarnyy", id: "RU" },
            { text: "Slyudyanka", id: "RU" },
            { text: "Kavalerovo", id: "RU" },
            { text: "Vanino", id: "RU" },
            { text: "Kyakhta", id: "RU" },
            { text: "Abaza", id: "RU" },
            { text: "Kirsanov", id: "RU" },
            { text: "Kurtamysh", id: "RU" },
            { text: "Sovetsk", id: "RU" },
            { text: "Pallasovka", id: "RU" },
            { text: "Plast", id: "RU" },
            { text: "Severo-Nevel'sk", id: "RU" },
            { text: "Poronaysk", id: "RU" },
            { text: "Kamenka", id: "RU" },
            { text: "Kupino", id: "RU" },
            { text: "Nikolayevsk", id: "RU" },
            { text: "Bodaybo", id: "RU" },
            { text: "Nikel'", id: "RU" },
            { text: "Kodinsk", id: "RU" },
            { text: "Gornyak", id: "RU" },
            { text: "Nerchinsk", id: "RU" },
            { text: "Kulunda", id: "RU" },
            { text: "Udachnyy", id: "RU" },
            { text: "Vyazemskiy", id: "RU" },
            { text: "Chegdomyn", id: "RU" },
            { text: "Ust'-Ordynskiy", id: "RU" },
            { text: "Shilka", id: "RU" },
            { text: "Kem'", id: "RU" },
            { text: "Golyshmanovo", id: "RU" },
            { text: "Kirensk", id: "RU" },
            { text: "Uyar", id: "RU" },
            { text: "Uglegorsk", id: "RU" },
            { text: "Mogocha", id: "RU" },
            { text: "Nazyvayevsk", id: "RU" },
            { text: "Belomorsk", id: "RU" },
            { text: "Cherlak", id: "RU" },
            { text: "Aleksandrovsk-Sakhalinskiy", id: "RU" },
            { text: "Dolinsk", id: "RU" },
            { text: "Magdagachi", id: "RU" },
            { text: "Severnyy", id: "RU" },
            { text: "Zmeinogorsk", id: "RU" },
            { text: "Aginskoye", id: "RU" },
            { text: "Kirs", id: "RU" },
            { text: "Kargat", id: "RU" },
            { text: "Khilok", id: "RU" },
            { text: "Taksimo", id: "RU" },
            { text: "Anadyr'", id: "RU" },
            { text: "Nogliki", id: "RU" },
            { text: "Skovorodino", id: "RU" },
            { text: "Obluch'ye", id: "RU" },
            { text: "Vilyuysk", id: "RU" },
            { text: "Pokrovsk", id: "RU" },
            { text: "Biryusinsk", id: "RU" },
            { text: "Dombarovskiy", id: "RU" },
            { text: "Igrim", id: "RU" },
            { text: "Shira", id: "RU" },
            { text: "Ust'-Nera", id: "RU" },
            { text: "Suntar", id: "RU" },
            { text: "Olovyannaya", id: "RU" },
            { text: "Dal'negorsk", id: "RU" },
            { text: "Igarka", id: "RU" },
            { text: "Susuman", id: "RU" },
            { text: "Khandyga", id: "RU" },
            { text: "Makarov", id: "RU" },
            { text: "Verkhnevilyuysk", id: "RU" },
            { text: "Umba", id: "RU" },
            { text: "Tazovskiy", id: "RU" },
            { text: "Mundybash", id: "RU" },
            { text: "Bilibino", id: "RU" },
            { text: "Tiksi", id: "RU" },
            { text: "Okhotsk", id: "RU" },
            { text: "Tura", id: "RU" },
            { text: "Chernyshevskiy", id: "RU" },
            { text: "Artëmovsk", id: "RU" },
            { text: "Ust'-Kamchatsk", id: "RU" },
            { text: "Pevek", id: "RU" },
            { text: "Turukhansk", id: "RU" },
            { text: "Bagdarin", id: "RU" },
            { text: "Sangar", id: "RU" },
            { text: "Batagay", id: "RU" },
            { text: "Omsukchan", id: "RU" },
            { text: "Novyy Uoyan", id: "RU" },
            { text: "Vitim", id: "RU" },
            { text: "Teeli", id: "RU" },
            { text: "Cherskiy", id: "RU" },
            { text: "Mezen'", id: "RU" },
            { text: "Palana", id: "RU" },
            { text: "Zyryanka", id: "RU" },
            { text: "De-Kastri", id: "RU" },
            { text: "Srednekolymsk", id: "RU" },
            { text: "Bukachacha", id: "RU" },
            { text: "Ugol'nyye Kopi", id: "RU" },
            { text: "Krasnogorsk", id: "RU" },
            { text: "Zhigansk", id: "RU" },
            { text: "Khatanga", id: "RU" },
            { text: "Ust'-Maya", id: "RU" },
            { text: "Saranpaul'", id: "RU" },
            { text: "Provideniya", id: "RU" },
            { text: "Chokurdakh", id: "RU" },
            { text: "Severo-Kuril'sk", id: "RU" },
            { text: "Egvekinot", id: "RU" },
            { text: "Evensk", id: "RU" },
            { text: "Saskylakh", id: "RU" },
            { text: "Beringovskiy", id: "RU" },
            { text: "Novyy Port", id: "RU" },
            { text: "Ust'-Kuyga", id: "RU" },
            { text: "El'dikan", id: "RU" },
            { text: "Verkhoyansk", id: "RU" },
            { text: "Chumikan", id: "RU" },
            { text: "Ayan", id: "RU" },
            { text: "Lavrentiya", id: "RU" },
            { text: "Dikson", id: "RU" },
            { text: "Klyuchi", id: "RU" },
            { text: "Omolon", id: "RU" },
            { text: "Uelen", id: "RU" },
            { text: "Yerëma", id: "RU" },
            { text: "Mikhalkino", id: "RU" },
            { text: "Sherlovaya Gora", id: "RU" },
            { text: "Nizhneyansk", id: "RU" },
            { text: "Korf", id: "RU" },
            { text: "Bugrino", id: "RU" },
            { text: "Shoyna", id: "RU" },
            { text: "Put' Lenina", id: "RU" },
            { text: "Enurmino", id: "RU" },
            { text: "Amderma", id: "RU" },
            { text: "Gubkin", id: "RU" },
            { text: "Kuznetsova-Vikhoreva", id: "RU" },
            { text: "Progress", id: "RU" },
            { text: "Mukhomornoye", id: "RU" },
            { text: "Vorontsovo", id: "RU" },
            { text: "Kovda", id: "RU" },
            { text: "Bol'sheretsk", id: "RU" },
            { text: "Yessey", id: "RU" },
            { text: "Khorgo", id: "RU" },
            { text: "Tunguskhaya", id: "RU" },
            { text: "Chagda", id: "RU" },
            { text: "Siglan", id: "RU" },
            { text: "Gyda", id: "RU" },
            { text: "Khakhar'", id: "RU" },
            { text: "Menkerya", id: "RU" },
            { text: "Lar'yak", id: "RU" },
            { text: "Starorybnoye", id: "RU" },
            { text: "Il'pyrskiy", id: "RU" },
            { text: "Zhilinda", id: "RU" },
            { text: "Olenëk", id: "RU" },
            { text: "Manily", id: "RU" },
            { text: "Karamken", id: "RU" },
            { text: "Ust'-Olenëk", id: "RU" },
            { text: "Varnek", id: "RU" },
            { text: "Shalaurova", id: "RU" },
            { text: "Agapa", id: "RU" },
            { text: "Numto", id: "RU" },
            { text: "Omchak", id: "RU" },
            { text: "Podkamennaya Tunguska", id: "RU" },
            { text: "Zemlya Bunge", id: "RU" },
            { text: "Indiga", id: "RU" },
            { text: "Strelka", id: "RU" },
            { text: "Pakhachi", id: "RU" },
            { text: "Tiyerbes", id: "RU" },
            { text: "Zvëzdnyy", id: "RU" },
            { text: "Ul'kan", id: "RU" },
            { text: "Sagastyr", id: "RU" },
            { text: "Matochkin Shar", id: "RU" },
            { text: "Utkholok", id: "RU" },
            { text: "Peregrebnoye", id: "RU" },
            { text: "Tukchi", id: "RU" },
            { text: "Nyukzha", id: "RU" },
            { text: "Trofimovsk", id: "RU" },
            { text: "Komsa", id: "RU" },
            { text: "Magas", id: "RU" },
            { text: "Temryuk", id: "RU" },
            { text: "Kamenolomni", id: "RU" },
            { text: "Severskaya", id: "RU" },
            { text: "Baltiysk", id: "RU" },
            { text: "Yegorlykskaya", id: "RU" },
            { text: "Ozërsk", id: "RU" },
            { text: "Vesëlyy", id: "RU" },
            { text: "Kantemirovka", id: "RU" },
            { text: "Adygeysk", id: "RU" },
            { text: "Gur'yevsk", id: "RU" },
            { text: "Slavsk", id: "RU" },
            { text: "Pionerskiy", id: "RU" },
            { text: "Mayskiy", id: "RU" },
            { text: "Svetlyy", id: "RU" },
            { text: "Kalininskaya", id: "RU" },
            { text: "Oblivskaya", id: "RU" },
            { text: "Abinsk", id: "RU" },
            { text: "Kurganinsk", id: "RU" },
            { text: "Gorod Maykop", id: "RU" },
            { text: "Gul'kevichi", id: "RU" },
            { text: "Shovgenovskiy", id: "RU" },
            { text: "Takhtamukay", id: "RU" },
            { text: "Kagal'nitskaya", id: "RU" },
            { text: "Belorechensk", id: "RU" },
            { text: "Tul'skiy", id: "RU" },
            { text: "Tarasovskiy", id: "RU" },
            { text: "Krasnoarmeyskaya", id: "RU" },
            { text: "Otradnaya", id: "RU" },
            { text: "Bryukhovetskaya", id: "RU" },
            { text: "Staroshcherbinovskaya", id: "RU" },
            { text: "Kazanskaya", id: "RU" },
            { text: "Krasnoznamensk", id: "RU" },
            { text: "Okhansk", id: "RU" },
            { text: "Zimovniki", id: "RU" },
            { text: "Ivanovo", id: "RU" },
            { text: "Krasnogvardeyskoye", id: "RU" },
            { text: "Chertkovo", id: "RU" },
            { text: "Kizlyar", id: "RU" },
            { text: "Tselina", id: "RU" },
            { text: "Perm'", id: "RU" },
            { text: "Pokrovskoye", id: "RU" },
            { text: "Alagir", id: "RU" },
            { text: "Konstantinovsk", id: "RU" },
            { text: "Rodionovo-Nesvetayskaya", id: "RU" },
            { text: "Slavyansk-na-Kubani", id: "RU" },
            { text: "Krasnyy Sulin", id: "RU" },
            { text: "Dinskaya", id: "RU" },
            { text: "Igra", id: "RU" },
            { text: "Svetlogorsk", id: "RU" },
            { text: "Mostovskoy", id: "RU" },
            { text: "Gvardeysk", id: "RU" },
            { text: "Vyselki", id: "RU" },
            { text: "Chaltyr'", id: "RU" },
            { text: "Ust'-Labinsk", id: "RU" },
            { text: "Milyutinskaya", id: "RU" },
            { text: "Belaya Glina", id: "RU" },
            { text: "Uni", id: "RU" },
            { text: "Proletarsk", id: "RU" },
            { text: "Ust'-Donetskiy", id: "RU" },
            { text: "Bol'shaya Martynovka", id: "RU" },
            { text: "Veshenskaya", id: "RU" },
            { text: "Aksay", id: "RU" },
            { text: "Krylovskaya", id: "RU" },
            { text: "Azov", id: "RU" },
            { text: "Polessk", id: "RU" },
            { text: "Koshekhabl'", id: "RU" },
            { text: "Tbilisskaya", id: "RU" },
            { text: "Grayvoron", id: "RU" },
            { text: "Bagrationovsk", id: "RU" },
            { text: "Anapa", id: "RU" },
            { text: "Gusev", id: "RU" },
            { text: "Kashary", id: "RU" },
            { text: "Matveyev Kurgan", id: "RU" },
            { text: "Zelenogradsk", id: "RU" },
            { text: "Khasavyurt", id: "RU" },
            { text: "Neman", id: "RU" },
            { text: "Krymsk", id: "RU" },
            { text: "Debesy", id: "RU" },
            { text: "Bagayevskaya", id: "RU" },
            { text: "Semikarakorsk", id: "RU" },
            { text: "Oktyabr'skiy", id: "RU" },
            { text: "Kez", id: "RU" },
            { text: "Logashkino", id: "RU" },
            { text: "Uspenskoye", id: "RU" },
            { text: "Zavetnoye", id: "RU" },
            { text: "Kanevskaya", id: "RU" },
            { text: "Nytva", id: "RU" },
            { text: "Primorsko-Akhtarsk", id: "RU" },
            { text: "Kizilyurt", id: "RU" },
            { text: "Bokovskaya", id: "RU" },
            { text: "Kavkazskaya", id: "RU" },
            { text: "Tsimlyansk", id: "RU" },
            { text: "Novokubansk", id: "RU" },
            { text: "Morozovsk", id: "RU" },
            { text: "Nordvik", id: "RU" },
            { text: "Peschanokopskoye", id: "RU" },
            { text: "Zernograd", id: "RU" },
            { text: "Remontnoye", id: "RU" },
            { text: "Dubovskoye", id: "RU" },
            { text: "Novopokrovskaya", id: "RU" },
            { text: "Giaginskaya", id: "RU" },
            { text: "Kushchëvskaya", id: "RU" },
            { text: "Nesterov", id: "RU" },
            { text: "Starominskaya", id: "RU" },
            { text: "Sovetskoye", id: "RU" },
            { text: "Kuybyshevo", id: "RU" },
            { text: "Leningradskaya", id: "RU" },
            { text: "Ambarchik", id: "RU" },
            { text: "Korenovsk", id: "RU" },
            { text: "Balezino", id: "RU" },
            { text: "Pavlovskaya", id: "RU" },
            { text: "Pravdinsk", id: "RU" },
            { text: "Prokhladnyy", id: "RU" },
            { text: "Romanovskaya", id: "RU" },
            { text: "Kazach'ye", id: "RU", }
        ];

        function formatCity (city) {
            if (!city.id) { return city.text; }
            var $city = $(
                '<span class="flag-icon flag-icon-'+ city.id.toLowerCase() +' flag-icon-squared"></span>' +
                '<span class="flag-text">'+ city.text+"</span>"
            );
            return $city;
        }

        $("[name='city']").select2({
            templateSelection: formatCity,
            templateResult: formatCity,
            data: isoRussiaCities
        });
    });
}

function setTelInputWithLibrary() {
    var input = document.querySelector("#phone");
    window.intlTelInput(input, {
        separateDialCode: "true",
        preferredCountries: ["fr"],
        initialCountry: "fr"// Put "auto" and uncomment following code when will be on server to determine country automatically
        /*geoIpLookup: function(callback) {
            $.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
                var countryCode = (resp && resp.country) ? resp.country : "";
                callback(countryCode);
            });
        },
        utilsScript: "../dist/intl-tel-input-16.0.0/build/js/utils.js" // just for formatting/placeholders etc*/
    });
}
function setTelInputWithLibraryMobile() {
    var input = document.querySelector("#telephone");
    window.intlTelInput(input, {
        separateDialCode: "true",
        preferredCountries: ["fr"],
        initialCountry: "fr"// Put "auto" and uncomment following code when will be on server to determine country automatically
        /*geoIpLookup: function(callback) {
            $.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
                var countryCode = (resp && resp.country) ? resp.country : "";
                callback(countryCode);
            });
        },
        utilsScript: "../dist/intl-tel-input-16.0.0/build/js/utils.js" // just for formatting/placeholders etc*/
    });
}
function goToNextScreen() {
    var currentStepNb = getCurrentStepNb();
    var nextStepNb = currentStepNb +1;
    var totalStepsNb = progressSteps.length;
    var currentStepForm = $('.form-step-' + currentStepNb);
    var nextStepForm = $('.form-step-' + nextStepNb);

    if(currentStepNb < totalStepsNb){
        currentStepForm.hide();
        nextStepForm.show();
        setOrderRecap(nextStepNb);
        setProgressBar(nextStepNb);
        setStepsProgress(nextStepNb);
        if(currentStepNb === 1){
            toggleReviewsBlock();
            toggleTabsBlock();
            $('.previous-arrow').show();
        }
    }
}

function goToLastScreen(){
    var currentStepNb = getCurrentStepNb();
    var previousStepNb = currentStepNb - 1;
    var currentStepForm = $('.form-step-' + currentStepNb);
    var previousStepForm = $('.form-step-' + previousStepNb);

    if(currentStepNb > 1){
        currentStepForm.hide();
        previousStepForm.show();
        setPreviousOrderRecap(getCurrentStepNb());
        setProgressBar(previousStepNb);
        setStepsProgress(previousStepNb);
        if(previousStepNb === 1){
            toggleReviewsBlock();
            toggleTabsBlock();
            $('.previous-arrow').hide();
        }
    }
}

function setProgressBar(stepNbToSet) {
    var stepNbToSet = stepNbToSet || getCurrentStepNb();
    var totalStepsNb = progressSteps.length;
    var oneStepPercent = 100/totalStepsNb;
    var currentStepPercent = Number((stepNbToSet * oneStepPercent).toFixed(1));

    if (currentStepPercent <= 100.0) {
        setAriaValueNow(currentStepPercent);
    }
}

function setStepsProgress(stepToSet) {
    var stepNbToSet = stepToSet || getCurrentStepNb();

    progressSteps.each(function () {
        $(this).removeClass('active');
    });
    $('.progress-steps .step:nth-of-type(' + stepNbToSet + ')').addClass('active');
}

function getCurrentStepNb(){
    var currentStepNb;

    progressSteps.each(function (index) {
        currentStepNb = index + 1;
        if($(this).hasClass('active'))
            return false;
    });
    return currentStepNb;
}

function setOrderRecap(stepToSet) {
    var panelRightUnits = $('.panel-right .tab-contents .label-wrapper');

    panelRightUnits.each(function () {
        if($(this).hasClass('step-' + stepToSet)){
            $(this).show();
        }
        $(this).children().each(function () {
            if($(this).hasClass('step-' + stepToSet)){
                $(this).show();
            }
        });
    });
}

function setPreviousOrderRecap(actualStep) {
    var panelRightUnits = $('.panel-right .tab-contents .label-wrapper');

    panelRightUnits.each(function () {
        if($(this).hasClass('step-' + actualStep)){
            $(this).hide();
        }
        $(this).children().each(function () {
            if($(this).hasClass('step-' + actualStep)){
                $(this).hide();
            }
        });
    });

    setOrderRecap(actualStep - 1);
}

function setAriaValueNow(stepPercent) {
    var progressBar =  $('.progress-bar');

    progressBar.attr('aria-valuenow', Math.round(stepPercent));
    progressBar.css('width', Math.round(stepPercent) + '%'); //Math.round(percent) + '%');
    $('.progress-bar-circle').text( Math.round(stepPercent) + '%');
}

function toggleReviewsBlock() {
    $('.bloc-avis').toggle();
}

function toggleTabsBlock() {
    $('.tabs-with-icon.tabs-center').toggle();
}

function addSelectCountryBelow(button) {
    button.before(`<select class="classic-select input-width selectpicker countrypicker" name="country"></select>`);
    populateCountrySelect();
}

function addSelectCityBelow(button) {
    button.before($('.russia-cities-form:first-child').clone());
}

function changeQuantity() {
    setTimeout(function() {
        $('.label-quantity').text('x' + $('.range-box input').val());
    }, 100);
}

    