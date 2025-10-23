let firstValue = document.getElementById("num1");
let secondValue = document.getElementById("num2");
let resultField = document.getElementById("result");
let operation = document.getElementById("operation");
let calculateButton = document.getElementById("calculateBtn");

function addValues(n1, n2){
    return n1 + n2;
}
function subtractValues(n1, n2){
    return n1 - n2;
}
function multiplyValues(n1, n2){
    return n1 * n2;
}   
function divideValues(n1, n2){
    return n1 / n2;
}

calculateButton.addEventListener("click", function() {
    let n1 = Number(firstValue.value);
    let n2 = Number(secondValue.value);
    let result;

    if (operation.value === 'add') {
        result = addValues(n1, n2);
    } else if (operation.value === 'subtract') {
        result = subtractValues(n1, n2);
    } else if (operation.value === 'multiply') {
        result = multiplyValues(n1, n2);
    } else if (operation.value === 'divide') {
        result = divideValues(n1, n2);
    } else {
        alert('Operação inválida!');
        return;
    }

    if (result > 0){
        resultField.classList.remove("negative-result", "zero-result");
        resultField.classList.add("positive-result");
    } else if (result < 0){
        resultField.classList.remove("positive-result", "zero-result");
        resultField.classList.add("negative-result");
    } else {
        resultField.classList.remove("positive-result", "negative-result");
        resultField.classList.add("zero-result");
    }

    resultField.value = result;
});
