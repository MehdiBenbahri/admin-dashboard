const tableTarget = document.querySelector('table');
const spinnerTarget = document.getElementById('spinner');

function toggleLoading(toggle) {
    if (toggle){
        tableTarget.classList.add('loading');
        spinnerTarget.classList.remove('hidden');
    }
    else{
        tableTarget.classList.remove('loading');
        spinnerTarget.classList.add('hidden');
    }
}

document.addEventListener('turbo:before-visit', (event) => {
    toggleLoading(true);
    console.log('load')
});

document.addEventListener('turbo:before-visit', (event) => {
    toggleLoading(false);
    console.log('unload')
});