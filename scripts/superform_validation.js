window.addEventListener('load', ()=>{
    
    const firstname = document.querySelector("#firstname")
    const lastname = document.querySelector("#lastname")
    const email = document.querySelector("#email")
    
    let firstnameValidated = false
    let lastnameValidated = false
    let emailValidated = false

    if (firstname && lastname && email) {

        firstname.addEventListener("blur", (event) => {
            validateText(event, "firstname")
            addCss(firstnameValidated, firstname)
        })
        
        lastname.addEventListener("blur", (event) => {
            validateText(event, "lastname")
            addCss(lastnameValidated, lastname)
        })
        
        email.addEventListener("blur", (event) => {
            validateEmail(event)
            addCss(emailValidated, email)
        })
    }
    
      
    function validateText(event, input) {
        const textRegex = /[a-zA-Z]+$/g
        let inputElem;
        if(event.target.value.match(textRegex)) {
            if(input === "firstname"){
                firstnameValidated = true
                inputElem = document.querySelector('#firstname-message')
                inputElem.classList.remove('hidden')
                inputElem.innerHTML = "Good!"
               
            } else if(input === "lastname") {
                lastnameValidated = true
                inputElem = document.querySelector('#lastname-message')
                inputElem.classList.remove('hidden')
                inputElem.innerHTML = "Good!"
               
            }
        } else {
            if(input === "firstname"){
                firstnameValidated = false
                if (event.target.value === "") {
                    inputElem = document.querySelector('#firstname-message')
                    inputElem.classList.remove('hidden')
                    inputElem.innerHTML = "Please fill in a valid name"
                   
                } else if (!event.target.value.match(textRegex)) {
                    inputElem = document.querySelector('#firstname-message')
                    inputElem.classList.remove('hidden')
                    inputElem.innerHTML = "Please only use letters"
                   
                } 
            } else if(input === "lastname") {
                lastnameValidated = false
                if (event.target.value === "") {
                    inputElem = document.querySelector('#lastname-message')
                    inputElem.classList.remove('hidden')
                    inputElem.innerHTML = "Please fill in a valid name"
                   
                } else if (!event.target.value.match(textRegex)) {
                    inputElem = document.querySelector('#lastname-message')
                    inputElem.classList.remove('hidden')
                    inputElem.innerHTML = "Please only use letters"
                   
                } 
            }
        }
    }
    
    function validateEmail(event) {
        const emailRegex = /^[a-z0-9](?!.*?[^\na-z0-9]{​​2}​​)[^\s@]+@[^\s@]+\.[^\s@]+[a-z0-9]$/
        let msg = document.querySelector('#email-message')
        if(emailRegex.test(event.target.value)) {
            emailValidated = true
            msg.classList.remove('hidden')
            msg.innerHTML = "Looking good"
        } else {
            // if left empty
            msg.classList.remove('hidden')
            msg.innerHTML = "Please fill in a valid email"
    
            emailValidated = false
        }
    }
    
    function addCss(result, element) {
        if(result) {
            element.classList.remove("invalid")
            element.classList.add("valid")
        } else {
            element.classList.remove("valid")
            element.classList.add("invalid")
        }
    }
})
