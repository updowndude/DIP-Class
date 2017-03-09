/*
function checkValues (elmName) {
    alert(elmName);
}

document.querySelectorAll('#searchPerson input').forEach((cur) => {
    cur.addEventListener('input', checkValues('#searchPerson'));
});*/
import bsn from 'bootstrap.native';

if('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/DIP-Class/sWorker.js', {scope: 'DIP-Class/*'}).then((reg) => {
        console.log('worked');
    }).catch((err) => {
        console.log(err);
    });3
}

if(document.body.id == 'findPersonBody') {
    let blnRemoveSumbit = true;
    const elmInputs = document.querySelectorAll('#searchPerson input');
    const btnSumbit = document.querySelector("#findPerson");
    const btnFindPerson = document.querySelector('#searchPhone');

    elmInputs.forEach((cur2) => {
        if((cur2.value.trim().length == 0) && ((cur2.name == 'LName') || (cur2.name == 'FName'))) {
            blnRemoveSumbit = false;
        }
    });

    blnRemoveSumbit === false ? btnSumbit.setAttribute('disabled','disabled') : null;

    elmInputs.forEach((cur) => {
        cur.addEventListener('input', () => {
            let blnSumbit = true;
            let intRight = 0;

            elmInputs.forEach((curPlaced) => {
                (curPlaced.value.trim().length != 0) && ((curPlaced.name == 'LName') || (curPlaced.name == 'FName')) ? intRight++ : null;

                (/^[1-9]{1}\d{3}-\d{2}-\d{2}$/.test(curPlaced.value.trim()) == true) && ((curPlaced.name == 'DOB')) ? intRight++ : null;

                if(intRight === 3) {
                    blnSumbit = true;
                    btnFindPerson.removeAttribute('disabled');

                    elmInputs.forEach((element, index, array) => {
                       if(index <= 2) {
                           element.classList.remove('myError');
                       }
                    });
                } else {
                    blnSumbit = false;
                    elmInputs.forEach((element, index, array) => {
                        if(index <= 2) {
                            element.classList.add('myError');
                        }
                    });
                    btnFindPerson.setAttribute('disabled','disabled');
                }
            });

            blnSumbit === true ? btnSumbit.removeAttribute('disabled') : btnSumbit.setAttribute('disabled','disabled');
        });
    });

    document.querySelector('#btnLogout').addEventListener('click', (event) => {

    });

    btnFindPerson.addEventListener('click', () => {
        document.querySelector('#action').value = "searchByPhone";
    });

    document.querySelector('#btnClear').addEventListener('click', (event) => {
        elmInputs.forEach((cur) => {
            cur.value = '';
        });
        event.preventDefault();
    });
}
