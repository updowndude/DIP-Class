function checkValues (elmName) {
    // alert(elmName);
}

document.querySelectorAll('#searchPerson').forEach((cur) => {
    cur.addEventListener("input", checkValues('#searchPerson'));
});