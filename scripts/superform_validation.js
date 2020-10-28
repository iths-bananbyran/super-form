const surname = document.querySelector("#surname")
const lastname = document.querySelector("#lastname")
const email = document.querySelector("#email")

const submit = document.querySelector("#submit")

surname.addEventListener("blur", (event) => {
    validateText(event, "surname")
    validateCss(surnameValidated, surname)
})

lastname.addEventListener("blur", (event) => {
    validateText(event, "lastname")
})

email.addEventListener("blur", (event) => {
    validateEmail(event)
})

submit.addEventListener("blur", (event) => {
    validateSubmit(event)
})

let surnameValidated = false
let lastnameValidated = false
let emailValidated = false

function validateText(event, input) {

    const textRegex = /[a-zA-Z]+/g

    if(event.target.value.match(textRegex)) {
        
        if(input === "surname"){
            surnameValidated = true
            console.log("surname is Good");
        } else if(input === "lastname") {
            lastnameValidated = true
            console.log("Lastname is Good");
        }
    } else {
        if(input === "surname"){
            surnameValidated = false
            console.log("surname Error");
        } else if(input === "lastname") {
            lastnameValidated = false
            console.log("Lastname Error");
        }
        
    }
}

function validateEmail(event) {
    
    const emailRegex = /^[a-z0-9](?!.*?[^\na-z0-9]{​​2}​​)[^\s@]+@[^\s@]+\.[^\s@]+[a-z0-9]$/
    
    if(emailRegex.test(event.target.value)) {
        console.log("Good");
    } else {
        console.log("Error");
    }

}

function validateSubmit(event) {
    // inget här just nu
}

function validateCss(result, element) {
    if(result) {
        element.classList.add("valid")
    } else {
        element.classList.add("invalid")
    }
}