

function toggleLoading(toggle) {

    const tableTarget = document.querySelector('table');
    const spinnerTarget = document.getElementById('spinner');

    if (toggle){
        tableTarget.classList.add('loading');
        spinnerTarget.classList.remove('hidden');
    }
    else{
        tableTarget.classList.remove('loading');
        spinnerTarget.classList.add('hidden');
    }
}

document.addEventListener('turbo:before-prefetch', (event) => {
    event.preventDefault();
    Turbo.cache.clear();
});

document.addEventListener('turbo:before-visit', (event) => {
    toggleLoading(true);
    console.log('load')
});

document.addEventListener('turbo:before-visit', (event) => {
    toggleLoading(false);
    console.log('unload')
});