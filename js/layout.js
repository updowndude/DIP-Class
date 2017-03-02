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
            let intRight = 0;

            elmInputs.forEach((curPlaced) => {
                (curPlaced.value.trim().length != 0) && ((curPlaced.name == 'last-name') || (curPlaced.name == 'DOB') || (curPlaced.name == 'first-name')) ? intRight++ : null;

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
