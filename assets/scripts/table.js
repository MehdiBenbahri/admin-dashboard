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

document.addEventListener('turbo:before-prefetch', (event) => {
    event.preventDefault();
    Turbo.cache.clear();
});

document.addEventListener('turbo:before-fetch-response', (event) => {
    toggleLoading(true);
});

document.addEventListener('turbo:visit', (event) => {
    toggleLoading(false);
});