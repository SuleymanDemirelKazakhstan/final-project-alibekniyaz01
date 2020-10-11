/* Write your code here */


function removeText(event) {
    let text = event.currentTarget;
    if (text.parentNode.hasAttribute('data-status')) {
        text.parentNode.removeAttribute('data-status', '');
        text.innerHTML = 'Finish';

    }
    else {
        text.parentNode.setAttribute('data-status', 'done');
        text.innerHTML = 'Start';
    }

}

let finishes = document.querySelectorAll("button");

for (let finish of finishes) {
    finish.addEventListener('click', removeText);
}