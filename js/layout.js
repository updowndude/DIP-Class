/*
function checkValues (elmName) {
    alert(elmName);
}

document.querySelectorAll('#searchPerson input').forEach((cur) => {
    cur.addEventListener('input', checkValues('#searchPerson'));
});*/
import bsn from 'bootstrap.native';

if(document.body.id == 'findPerson') {
    let blnRemoveSumbit = true;
    const elmInputs = document.querySelectorAll('#searchPerson input');
    const btnSumbit = document.querySelector("#findPerson");

    elmInputs.forEach((cur) => {
        if((cur.value.trim().length == 0) && ((cur.name == 'last-name') || (cur.name == 'first-name'))) {
            blnRemoveSumbit = false;
        }
    });

    blnRemoveSumbit == false ? btnSumbit.setAttribute('disabled','disabled') : null;

    elmInputs.forEach((cur) => {
        cur.addEventListener('input', () => {
            let blnSumbit = true;

            elmInputs.forEach((curPlaced) => {
                if((curPlaced.value.trim().length == 0) && ((curPlaced.name == 'last-name') || (curPlaced.name == 'first-name'))) {
                    blnSumbit = false;
                    curPlaced.classList.add('myError');
                } else {
                    curPlaced.classList.remove('myError');
                }
            });

            blnSumbit === true ? btnSumbit.removeAttribute('disabled') : null;
        });
    });
}