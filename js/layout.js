// copyright 2017 DipFestival, LLC

import Chart from 'chart.js';
import Bootstrap from 'bootstrap';
import Material from 'bootstrap-material-design';

// see if the broswer support service workers
if('serviceWorker' in navigator) {
    // register the service and scoope it to the page
    navigator.serviceWorker.register('/maingate/service-worker.js', {scope: 'maingate/*'}).catch((err) => {
        console.log(err);
    });
}

$.material.init();

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
                label: "Expected",
                backgroundColor: "rgba(91,209,243, 0.2)",
                borderColor: 'rgba(91,209,243, 1)',
                data: [pAVGJMO.Expected,pAVGJTU.Expected,pAVGJWE.Expected,pAVGJTH.Expected,pAVGJFR.Expected,pAVGJSA.Expected,pAVGJSU.Expected,pAVGJW.Expected]
            },{
                label: "Arrived",
                backgroundColor: "rgba(255, 99, 132, 0.2)",
                borderColor: 'rgba(255, 99, 132, 1)',
                data: [pAVGJMO.Arrived,pAVGJTU.Arrived,pAVGJWE.Arrived,pAVGJTH.Arrived,pAVGJFR.Arrived,pAVGJSA.Arrived,pAVGJSU.Arrived,pAVGJW.Arrived]
            },{
                label: "NoShows",
                backgroundColor: "rgba(91, 255, 132, 0.2)",
                borderColor: 'rgba(91, 255, 132, 1)',
                data: [pAVGJMO.NoShows,pAVGJTU.NoShows,pAVGJWE.NoShows,pAVGJTH.NoShows,pAVGJFR.NoShows,pAVGJSA.NoShows,pAVGJSU.NoShows,pAVGJW.NoShows]
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
                label: "Expected",
                backgroundColor: "rgba(91,209,243, 0.2)",
                borderColor: 'rgba(91,209,243, 1)',
                data: [pCampingJMO.Expected,pCampingJTU.Expected,pCampingJWE.Expected,pCampingJTH.Expected,pCampingJFR.Expected,pCampingJSA.Expected,pCampingJSU.Expected,pCampingJW.Expected]
            },{
                label: "Arrived",
                backgroundColor: "rgba(255, 99, 132, 0.2)",
                borderColor: 'rgba(255, 99, 132, 1)',
                data: [pCampingJMO.Arrived,pCampingJTU.Arrived,pCampingJWE.Arrived,pCampingJTH.Arrived,pCampingJFR.Arrived,pCampingJSA.Arrived,pCampingJSU.Arrived,pCampingJW.Arrived]
            },{
                label: "NoShows",
                backgroundColor: "rgba(91, 255, 132, 0.2)",
                borderColor: 'rgba(91, 255, 132, 1)',
                data: [pCampingJMO.NoShows,pCampingJTU.NoShows,pCampingJWE.NoShows,pCampingJTH.NoShows,pCampingJFR.NoShows,pCampingJSA.NoShows,pCampingJSU.NoShows,pCampingJW.NoShows]
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
            labels: ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday","Week", "Total"],
            datasets: [{
                data: [pUARJMO.DailyTotal, pUARJTU.DailyTotal, pUARJWE.DailyTotal, pUARJTH.DailyTotal, pUARJFR.DailyTotal, pUARJSA.DailyTotal, pUARJSU.DailyTotal, pUARJW.WeeklyTotal, pUARJT.TotalSales],
                backgroundColor: [
                    'rgba(91,209,243, 0.2)',
                    'rgba(91,209,243, 0.2)',
                    'rgba(91,209,243, 0.2)',
                    'rgba(91,209,243, 0.2)',
                    'rgba(91,209,243, 0.2)',
                    'rgba(91,209,243, 0.2)',
                    'rgba(91,209,243, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(91, 255, 132, 0.2)'
                ],
                borderColor: [
                    'rgba(91,209,243, 1)',
                    'rgba(91,209,243, 1)',
                    'rgba(91,209,243, 1)',
                    'rgba(91,209,243, 1)',
                    'rgba(91,209,243, 1)',
                    'rgba(91,209,243, 1)',
                    'rgba(91,209,243, 1)',
                    'rgba(255,99,132,1)',
                    'rgba(91, 255, 132, 1)'
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
