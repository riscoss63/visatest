// This script permits to display the travel duration items that do not fit in the page (those after 3 elements)
// Cf. Page assurance - assurance 120 jours, assurance 150 jours, etc.

$(document).ready(function() {
    let pageContent = $('.infos-container');
    let tableLines = $('.infos-container .info-tabs .tab-content .table-price tr:gt(2)');
    let tableContainer = $('.table-price').parent();
    let moreButton = `<a href="#" data-toggle="modal" data-target="#travelDurationModal" class="text-primary display-invits">Afficher toutes les durées<img src="images/plus-circle-colored.svg" alt="icône afficher toutes les invitations" class="icon"></a>`;
    let modal = $('#travelDurationModal .modal-body .country-infos');

    tableLines.hide(function () {
        // Add more button
        tableContainer.prepend(moreButton);
        //Clone content in modal and adapt it
        modal.append(pageContent.clone());
        $('#travelDurationModal .modal-body div:first-child').removeClass('col-md-6');
        $('.modal-body .infos-container .info-tabs .tab-content a.display-invits').remove();
        $('.modal-body .infos-container .info-tabs .table-price tr').show();
        $('.modal-body .tabs-with-icon-nav a.nav-link').each(function() {
            if ($(this).attr('href')) {
                let oldHref = $(this).attr('href');
                let newHref = oldHref + '-modal'
                $(this).attr('href', newHref);
            }
        });
        $('.modal-body .tab-content div.tab-pane').each(function() {
            if (this.id) {
                this.id = this.id + "-modal";
            }
        });
    });
});