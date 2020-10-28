const surename = document.querySelector("#surename")
const lastname = document.querySelector("#lastname")
const idnumber = document.querySelector("#idnumber")
const email = document.querySelector("#email")
const telephone = document.querySelector("#telephone")
const address = document.querySelector("#address")
const address2 = document.querySelector("#address2")
const zipcode = document.querySelector("#zipcode")
const city = document.querySelector("#city")
const submit = document.querySelector("#submit")

surename.addEventListener("blur", (event) {
    validateText(event)
})

lastname.addEventListener("blur", (event) {
    validateText(event)
})

idnumber.addEventListener("blur", (event) {
    validateText(event)
})

email.addEventListener("blur", (event) {
    validateText(event)
})

telephone.addEventListener("blur", (event) {
    validateText(event)
})

address.addEventListener("blur", (event) {
    validateText(event)
})

address2.addEventListener("blur", (event) {
    validateText(event)
})

zipcode.addEventListener("blur", (event) {
    validateText(event)
})

city.addEventListener("blur", (event) {
    validateText(event)
})

submit.addEventListener("blur", (event) {
    validateText(event)
})


function validateText(event) {
    // inget här just nu
}