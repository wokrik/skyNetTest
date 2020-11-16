const app = document.getElementById('app');
const groups = document.querySelectorAll('[data-content="group"]');
const tarifs = document.querySelectorAll('.tarif');
const periods = document.querySelectorAll('.period');
const periodsField = document.querySelectorAll('.periods');
const detailsFields = document.querySelectorAll('.detailsField');
const details = document.querySelectorAll('[data-content="details"]');
const showPeriodsLaunchers = document.querySelectorAll('[data-action="show-periods"]');
const showTarifsLaunchers = document.querySelectorAll('[data-action="show-tarifs"]');
const showDetailsLaunchers = document.querySelectorAll('[data-action="show-details"]');

// hides all children of each group
function hideGroupsChildren(){
    groups.forEach(function(group){
        for(let element of group.children) {
            element.classList.add('hidden');
        }
    });
}

// shows all tarifs
function showTarifs() {
    groups.forEach(function(group){
        group.classList.remove('hidden');
    })
    hideGroupsChildren();
    tarifs.forEach(function(tarif){
        tarif.classList.remove('hidden');
    });
    app.dataset.mode = 'tarifs';
}

// shows all periods related to clicked element
function showPeriods() {
    hideGroupsChildren();
    groups.forEach(function(group){
        group.classList.add('hidden');
    })
    const closestGroup = this.closest('[data-content="group"]');
    closestGroup.classList.remove('hidden');
    // show periods
    closestGroup.querySelector('[data-content="periods"]').classList.remove('hidden');
    app.dataset.mode = 'periods';
}

// shows details related to clicked period
function showDetails(){
    hideGroupsChildren();
    
    // show details field
    this.closest('[data-content="group"]').querySelector('[data-content="details_field"]').classList.remove('hidden');
    
    // hide all details and show just related
    this.closest('[data-content="group"]').querySelectorAll('[data-content="details"]').forEach(function(el){
        el.classList.add('hidden');
    });
    const id = this.dataset.period_id;
    const relatedDetails = this.closest('[data-content="group"]').querySelector(`[data-details_id="${id}"]`);
    relatedDetails.classList.remove('hidden');
    app.dataset.mode = 'details';
}

// adding event listeners
showPeriodsLaunchers.forEach(function(launcher){
    launcher.addEventListener('click', showPeriods);
});

showTarifsLaunchers.forEach(function(launcher){
    launcher.addEventListener('click', showTarifs);
});

showDetailsLaunchers.forEach(function(period){
    period.addEventListener('click', showDetails);
});