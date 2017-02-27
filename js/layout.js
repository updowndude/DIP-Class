/*
function checkValues (elmName) {
    alert(elmName);
}

document.querySelectorAll('#searchPerson input').forEach((cur) => {
    cur.addEventListener('input', checkValues('#searchPerson'));
});*/
import bsn from 'bootstrap.native';

if(document.body.id == 'findPersonBody') {
    let blnRemoveSumbit = true;
    const elmInputs = document.querySelectorAll('#searchPerson input');
    const btnSumbit = document.querySelector("#findPerson");
    const btnFindPerson = document.querySelector('#searchPhone');

    elmInputs.forEach((cur2) => {
        if((cur2.value.trim().length == 0) && ((cur2.name == 'last-name') || (cur2.name == 'first-name'))) {
            blnRemoveSumbit = false;
        }
    });

    blnRemoveSumbit === false ? btnSumbit.setAttribute('disabled','disabled') : null;

    elmInputs.forEach((cur) => {
        cur.addEventListener('input', () => {
            let blnSumbit = true;

            elmInputs.forEach((curPlaced) => {
                if((curPlaced.value.trim().length == 0) && ((curPlaced.name == 'last-name') || (curPlaced.name == 'first-name'))) {
                    if((elmInputs[0].value.trim().length < 8) || (elmInputs[0].name != 'phone-number')) {
                        blnSumbit = false;
                        curPlaced.classList.add('myError');
                        btnFindPerson.setAttribute('disabled','disabled');
                    } else {
                        blnSumbit = true;
                        curPlaced.classList.remove('myError');
                        btnFindPerson.removeAttribute('disabled');
                    }
                } else {
                    curPlaced.classList.remove('myError');
                }
            });

            blnSumbit === true ? btnSumbit.removeAttribute('disabled') : btnSumbit.setAttribute('disabled','disabled');
        });
    });

    btnFindPerson.addEventListener('click', (event) => {
        document.querySelector('#action').value = "searchByPhone";
    });

    document.querySelector('#btnClear').addEventListener('click', (event) => {
        elmInputs.forEach((cur) => {
            cur.value = '';
        });
        event.preventDefault();
    });
}
