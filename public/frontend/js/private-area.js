// Cette fonction permet d'inclure des éléments qui se répètent dans les pages (Navbar, footer)
// Cette fonction est à enlever lors de la dynamisation des pages HTML
/*$(function(){
    var includes = $('[data-include]');
    $.each(includes, function(){
        if($('[data-url]').length){
            var file = $(this).data('url') + $(this).data('include') + '.html';
        }else{
            var file = 'includes/' + $(this).data('include') + '.html';
        }
        $(this).load(file, function() {
            checkTitle();
        });
    });
});*/

// Lorsque la précédente fonction sera retirée, il faudra juste remplacer la signature de la fonction ci-dessous par $(document).ready(function(){
// This function allows to set the tab corresponding to the current page to 'active'
function checkTitle(){
    if ( $('title:contains("factures")').length > 0 ) {
        setMenuItemActive('mes-factures.html');
    } else if ( $('title:contains("commandes")').length > 0 ) {
        setMenuItemActive('mes-commandes.html');
    } else if ( $('title:contains("Coordonnées")').length > 0 ) {
        setMenuItemActive('coordonnees.html');
    } else if ( $('title:contains("accès")').length > 0 ) {
        setMenuItemActive('code-dacces.html');
    }
}

function setMenuItemActive(fileName){
    $('.navbar-espace-reserve ul li').removeClass('active');

    $('.navbar-espace-reserve ul > li a').each(function () {
        if( $(this).attr('href') == fileName){
            $(this).parent().addClass('active');
        }
    })
}
