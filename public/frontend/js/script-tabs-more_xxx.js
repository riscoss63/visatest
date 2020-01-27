// This script permits to dynamically display tabs when window is resized and/or to adapt to every screen
// Cf. Page visa classique - tabs 'Tourisme, affaires, stage, études, etc.'
//Note: the onclick function is used with document to make it work for modal as well

// Btn "more" on mobile for the tabs with icon
const container = document.querySelector('.tabs-with-icon-container')//$('.tabs-with-icon-container')
const primary = container.querySelector('.tabs-with-icon-nav')//$('.tabs-with-icon-container .tabs-with-icon-nav')
const primaryItems = container.querySelectorAll('.tabs-with-icon-nav > *:not(.-more)')//$('.tabs-with-icon-container .tabs-with-icon-nav > *:not(.-more)')
container.classList.add('--jsfied')

var windowsize = $(window).width();


// Insert "more" button and duplicate the list
primary.insertAdjacentHTML('beforeend', `
<div class="-more">
    <button type="button" aria-haspopup="true" aria-expanded="false"> 
    <span id="text">Autre catégorie</span>
    <img src="images/arrow-down.svg" class="icon" alt="icône voir plus d'options">
    </button>
    <div class="-secondary">
        ${primary.innerHTML}
    </div>
</div>
`)
const secondary = container.querySelector('.-secondary')//$('.tabs-with-icon-container .-secondary')
const secondaryItems = secondary.querySelectorAll('a')//$('.tabs-with-icon-container .-secondary a')
const allItems = primary.querySelectorAll('a')//$('.tabs-with-icon-container .tabs-with-icon-nav a')
const moreLi = primary.querySelector('.-more')//$('.tabs-with-icon-container .tabs-with-icon-nav .-more')
const moreBtn = moreLi.querySelector('button')//$('.tabs-with-icon-container .tabs-with-icon-nav .-more button')
//const moreBtn2 = $('.-more button')
/*moreBtn.addEventListener('click', (e) => {
    console.log("click on more button")
    container.classList.toggle('--show-secondary')
    moreBtn.setAttribute('aria-expanded', container.classList.contains('--show-secondary'))
})*/
$(document).on('click', '.-more button', function() {
    $('.-more button').parent().parent().parent().toggleClass('--show-secondary');
    $('.-more button').attr('aria-expanded',
        $('.-more button').attr('aria-expanded')=='false' ? 'true' : 'false'
    );
});

function doAdapt() {
    // Reveal all items for the calculation
    $('.tabs-with-icon-container .tabs-with-icon-nav a').each(function(){
        $(this).removeClass('--hidden');
    });

    // Hide items that won't fit in the Primary
    let stopWidth = $('.tabs-with-icon-container .tabs-with-icon-nav .-more button').width();
    let hiddenItems = [];
    //let primaryWidth = $('.tabs-with-icon-container .tabs-with-icon-nav').width();
    const primaryWidth = primary.offsetWidth;//jQuery .width() returns 0, so I use vanillaJS
    $('.tabs-with-icon-container .tabs-with-icon-nav > *:not(.-more)').each(function(index){
        if(primaryWidth >= stopWidth + $(this).width()) {
            stopWidth += $(this).width();
        } else {
            $(this).addClass('--hidden');
            hiddenItems.push(index);
        }
    });

    // Toggle the visibility of More button and items in Secondary
    if(!hiddenItems.length) {
        $('.country-infos .tabs-with-icon-container .tabs-with-icon-nav .-more').addClass('--hidden');
        $('.country-infos .tabs-with-icon-container').removeClass('--show-secondary')
        $('.country-infos .tabs-with-icon-container .tabs-with-icon-nav .-more button').attr('aria-expanded','false');
    }
    else {
        $('.tabs-with-icon-container .-secondary a').each(function(index){
            if(!hiddenItems.includes(index)) {
                $(this).addClass('--hidden');
            }
        });
    }
    // Adapt size of secondary for better design
    var newWidth = moreBtn.offsetWidth;
    $(".-secondary").width(newWidth);
}
// Adapt tabs function (vanillaJS version)
/*const doAdapt = () => {
    // Reveal all items for the calculation
    allItems.forEach((item) => {
        item.classList.remove('--hidden')
    })

    // Hide items that won't fit in the Primary
    let stopWidth = moreBtn.offsetWidth
    let hiddenItems = []
    const primaryWidth = primary.offsetWidth
    primaryItems.forEach((item, i) => {
        if(primaryWidth >= stopWidth + item.offsetWidth) {
            stopWidth += item.offsetWidth
        } else {
            item.classList.add('--hidden')
            hiddenItems.push(i)
        }
    })

    // Toggle the visibility of More button and items in Secondary
    if(!hiddenItems.length) {
        moreLi.classList.add('--hidden')
        container.classList.remove('--show-secondary')
        moreBtn.setAttribute('aria-expanded', false)
    }
    else {
        secondaryItems.forEach((item, i) => {
            if(!hiddenItems.includes(i)) {
                item.classList.add('--hidden')
            }
        })
    }
}*/

doAdapt(); // Adapt immediately on load
window.addEventListener('resize', doAdapt); // Adapt on window resize

// Hide Secondary on the outside click
document.addEventListener('click', (e) => {
    let el = e.target
    while(el) {
        if(el === secondary || el === moreBtn || el === moreLi || el === secondaryItems) {
            return;
        }
        el = el.parentNode
    }
    container.classList.remove('--show-secondary')
    moreBtn.setAttribute('aria-expanded', false)
});

// Change More text on click. It displays the name of the child selected.
$(document).on('click', '.-secondary > a', function() {
    var oldText = $(".-more button span").first().text();
    $('.-secondary a:contains(' + oldText +')').removeClass('--hidden');
    $(".-more button span").text($(this).text());
    $('.active2 button .img').remove();
    $('.-more button span').after($("img", this).clone());
    // Make it active
    //doAdapt();
    $(".-secondary > a").removeClass("active");
    //moreLi.classList.add('active2')
    $('.-more').addClass('active2');
    $(this).addClass("--hidden");
    // Hide secondary
    /*container.classList.remove('--show-secondary')
    moreBtn.setAttribute('aria-expanded', false)*/
    $('.-more button').parent().parent().parent().toggleClass('--show-secondary');
    $('.-more button').attr('aria-expanded','false');
    // Adapt size of secondary for better design
    var newWidth = moreBtn.offsetWidth;
    $(".-secondary").width(newWidth - 10);
});

// When user clicks on other tab, the More is set as unactive (removes green border + changes text color + removes image)
$(document).on('click', '.tabs-with-icon-nav > a', function() {
    //moreLi.classList.remove('active2')
    $('.-more').removeClass('active2');
    $('.-more button .img').remove();
    // Adapt size of secondary for better design
    var newWidth = moreBtn.offsetWidth;
    $(".-secondary").width(newWidth);
});
