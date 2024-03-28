function toggleLoading(toggle) {
    const tableTarget = document.querySelector('table');
    const spinnerTarget = document.getElementById('spinner');
    const coverTarget = document.getElementById('cover');

    if (toggle){
        tableTarget.classList.add('loading');
        spinnerTarget.classList.remove('hidden');
        coverTarget.classList.add('cover');
    }
    else{
        tableTarget.classList.remove('loading');
        spinnerTarget.classList.add('hidden');
        coverTarget.classList.remove('cover');
    }
}

function preparePageSize(){
    //Gestion des select pour la taille de la page
    const pageSizeSelectors = Array.from(document.querySelectorAll('.select-page-size'));

    //on parcours les select box
    pageSizeSelectors.map((el) => {
        // on leurs ajoute à chacun l'event
        el.addEventListener('change', (event) => {
            const newValue = event.target.value;
            //on les mets à jours cotés client le temps que le Ajax fais son oeuvres
            pageSizeSelectors.map((select) => {
                select.value = newValue;
            });
            //on dit a turbo de reload
            Turbo.visit('/user?' + new URLSearchParams({page: event.target.dataset.page, size: newValue}));
        })
    })
}

document.addEventListener('turbo:before-prefetch', (event) => {
    event.preventDefault();
    Turbo.cache.clear();
});

document.addEventListener('turbo:before-fetch-response', () => {
    toggleLoading(true);
    //remove des events
    const pageSizeSelectors = Array.from(document.querySelectorAll('.select-page-size'));
    pageSizeSelectors.map((el) => {
        el.removeEventListener('change', el);
    });
});

document.addEventListener('turbo:visit', () => {
    toggleLoading(false);
    preparePageSize();
});

preparePageSize();
document.addEventListener('turbo:render', () => {
    preparePageSize();
})