// copyright 2017 DipFestival, LLC

import bsn from 'bootstrap.native';
import Chart from 'chart.js';

// see if the broswer support service workers
if('serviceWorker' in navigator) {
    // register the service and scoope it to the page
    navigator.serviceWorker.register('/DIP-Class/sWorker.js', {scope: 'DIP-Class/*'}).catch((err) => {
        console.log(err);
    });
}

// check to see what page  is being display
if(document.body.id == 'findPersonBody') {
    // remove the sumbit disable
    let blnRemoveSumbit = true;
    // gets input input in main form
    const elmInputs = document.querySelectorAll('#searchPerson input');
    // gets the sumbit button
    const btnSumbit = document.querySelector("#findPerson");
    // gets the search all fields button
    const btnFindPerson = document.querySelector('#searchPhone');

    // loops through inputs
    elmInputs.forEach((cur2) => {
        // check to see if there a value for required fileds
        if((cur2.value.trim().length == 0) && ((cur2.name == 'LName') || (cur2.name == 'FName'))) {
            // dons't disable the sumbit
            blnRemoveSumbit = false;
        }
    });

    // set disable attribute for button if need to
    blnRemoveSumbit === false ? btnSumbit.setAttribute('disabled','disabled') : null;

    // loops through inputs
    elmInputs.forEach((cur) => {
        // adds event to every input
        cur.addEventListener('input', () => {
            // same as blnRemoveSumbit
            let blnSumbit = true;
            // number for require feilds have a value
            let intRight = 0;

            elmInputs.forEach((curPlaced) => {
                // check to see if there value
                (curPlaced.value.trim().length != 0) && ((curPlaced.name == 'LName') || (curPlaced.name == 'FName')) ? intRight++ : null;

                if(intRight === 2) {
                    // remove disable from the submit button
                    blnSumbit = true;
                    btnFindPerson.removeAttribute('disabled');

                    // remove the error class from the inputs
                    elmInputs.forEach((element, index, array) => {
                        if(index <= 2) {
                            element.classList.remove('myError');
                        }
                    });
                } else {
                    // set the erros
                    blnSumbit = false;
                    elmInputs.forEach((element, index, array) => {
                        if(index <= 2) {
                            element.classList.add('myError');
                        }
                    });
                    btnFindPerson.setAttribute('disabled','disabled');
                }
            });

            // set or unsets the disable button
            blnSumbit === true ? btnSumbit.removeAttribute('disabled') : btnSumbit.setAttribute('disabled','disabled');
        });
    });

    // search all fields button click
    btnFindPerson.addEventListener('click', () => {
        // change action in the form
        document.querySelector('#action').value = "searchByPhone";
    });

    // clear all fields button is click
    document.querySelector('#btnClear').addEventListener('click', (event) => {
        elmInputs.forEach((cur) => {
            // set the new value to inputs
            cur.value = '';
        });
        // prevent form to sumbit to the sever
        event.preventDefault();
    });
} else if (document.body.id === 'adimPage'){
    new Chart(document.getElementById('pAVGC'), {
        type: 'bar',
        data: {
            labels: ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday","Week"],
            datasets: [{
                data: [pNGGCJMO.numberOfGuest, pNGGCJTU.numberOfGuest, pNGGCJWE.numberOfGuest, pNGGCJTU.numberOfGuest, pNGGCJFR.numberOfGuest, pNGGCJSA.numberOfGuest, pNGGCJSU.numberOfGuest, pNGGCJW.numberOfGuest],
                backgroundColor: [
                    'rgba(91,209,243, 0.2)',
                    'rgba(91,209,243, 0.2)',
                    'rgba(91,209,243, 0.2)',
                    'rgba(91,209,243, 0.2)',
                    'rgba(91,209,243, 0.2)',
                    'rgba(91,209,243, 0.2)',
                    'rgba(91,209,243, 0.2)',
                    'rgba(255, 99, 132, 0.2)'
                ],
                borderColor: [
                    'rgba(91,209,243, 1)',
                    'rgba(91,209,243, 1)',
                    'rgba(91,209,243, 1)',
                    'rgba(91,209,243, 1)',
                    'rgba(91,209,243, 1)',
                    'rgba(91,209,243, 1)',
                    'rgba(91,209,243, 1)',
                    'rgba(255,99,132,1)'
                ],
                borderWidth: 2
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            },
            legend: {
                display: false
            }
        }
    });
    new Chart(document.getElementById('pCampingC'), {
        type: 'bar',
        data: {
            labels: ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday","Week"],
            datasets: [{
                data: [pNGGCJMO.numberOfGuest, pNGGCJTU.numberOfGuest, pNGGCJWE.numberOfGuest, pNGGCJTU.numberOfGuest, pNGGCJFR.numberOfGuest, pNGGCJSA.numberOfGuest, pNGGCJSU.numberOfGuest, pNGGCJW.numberOfGuest],
                backgroundColor: [
                    'rgba(91,209,243, 0.2)',
                    'rgba(91,209,243, 0.2)',
                    'rgba(91,209,243, 0.2)',
                    'rgba(91,209,243, 0.2)',
                    'rgba(91,209,243, 0.2)',
                    'rgba(91,209,243, 0.2)',
                    'rgba(91,209,243, 0.2)',
                    'rgba(255, 99, 132, 0.2)'
                ],
                borderColor: [
                    'rgba(91,209,243, 1)',
                    'rgba(91,209,243, 1)',
                    'rgba(91,209,243, 1)',
                    'rgba(91,209,243, 1)',
                    'rgba(91,209,243, 1)',
                    'rgba(91,209,243, 1)',
                    'rgba(91,209,243, 1)',
                    'rgba(255,99,132,1)'
                ],
                borderWidth: 2
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            },
            legend: {
                display: false
            }
        }
    });
    new Chart(document.getElementById('pUARC'), {
        type: 'bar',
        data: {
            labels: ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday","Week"],
            datasets: [{
                data: [pNGGCJMO.numberOfGuest, pNGGCJTU.numberOfGuest, pNGGCJWE.numberOfGuest, pNGGCJTU.numberOfGuest, pNGGCJFR.numberOfGuest, pNGGCJSA.numberOfGuest, pNGGCJSU.numberOfGuest, pNGGCJW.numberOfGuest],
                backgroundColor: [
                    'rgba(91,209,243, 0.2)',
                    'rgba(91,209,243, 0.2)',
                    'rgba(91,209,243, 0.2)',
                    'rgba(91,209,243, 0.2)',
                    'rgba(91,209,243, 0.2)',
                    'rgba(91,209,243, 0.2)',
                    'rgba(91,209,243, 0.2)',
                    'rgba(255, 99, 132, 0.2)'
                ],
                borderColor: [
                    'rgba(91,209,243, 1)',
                    'rgba(91,209,243, 1)',
                    'rgba(91,209,243, 1)',
                    'rgba(91,209,243, 1)',
                    'rgba(91,209,243, 1)',
                    'rgba(91,209,243, 1)',
                    'rgba(91,209,243, 1)',
                    'rgba(255,99,132,1)'
                ],
                borderWidth: 2
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            },
            legend: {
                display: false
            }
        }
    });
    new Chart(document.getElementById('pNGGC'), {
        type: 'bar',
        data: {
            labels: ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday","Week"],
            datasets: [{
                data: [pNGGCJMO.numberOfGuest, pNGGCJTU.numberOfGuest, pNGGCJWE.numberOfGuest, pNGGCJTU.numberOfGuest, pNGGCJFR.numberOfGuest, pNGGCJSA.numberOfGuest, pNGGCJSU.numberOfGuest, pNGGCJW.numberOfGuest],
                backgroundColor: [
                    'rgba(91,209,243, 0.2)',
                    'rgba(91,209,243, 0.2)',
                    'rgba(91,209,243, 0.2)',
                    'rgba(91,209,243, 0.2)',
                    'rgba(91,209,243, 0.2)',
                    'rgba(91,209,243, 0.2)',
                    'rgba(91,209,243, 0.2)',
                    'rgba(255, 99, 132, 0.2)'
                ],
                borderColor: [
                    'rgba(91,209,243, 1)',
                    'rgba(91,209,243, 1)',
                    'rgba(91,209,243, 1)',
                    'rgba(91,209,243, 1)',
                    'rgba(91,209,243, 1)',
                    'rgba(91,209,243, 1)',
                    'rgba(91,209,243, 1)',
                    'rgba(255,99,132,1)'
                ],
                borderWidth: 2
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            },
            legend: {
                display: false
            }
        }
    });
}
