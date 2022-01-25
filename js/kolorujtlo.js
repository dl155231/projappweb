let computed = false
let decimal = 0


function clear(form) {
    form.input.value = 0
    form.display.value = 0
    decimal = 0
}

function changeBackground() {
    window.onclick = e => {
        let element = document.getElementById('content')
        element.style.background = e.target.name
    }
}

