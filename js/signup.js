// javascript for form validation
// create reference to form
const form = document.querySelector("#signup")
// create reference to signup button
const btn = document.querySelector("#signup-button")
// store form values in an object (for reference)
let formValues = {
    username: "",
    email: "",
    password: "",
    confirmpassword: ""
}
// function to change classes from valid to invalid
function toggleValid( element, state ) {
    if( state ) {
        element.classList.remove("is-invalid")
        element.classList.add("is-valid")
    }
    else {
        element.classList.remove("is-valid")
        element.classList.add("is-invalid")
    }
}

// listen for changes in the form
form.addEventListener('input', function (event) {
    const element = event.target
    const name = event.target.name
    const val = event.target.value
    // check if name is 'username'
    switch (name) {
        case "username":
            if (val.length < 3 || val.length > 16) {
                toggleValid( element, false )
            }
            else {
                toggleValid( element, true )
                formValues.username = val
            }
            break
        case "email":
            if (
                val.indexOf('@') == 0 ||
                val.indexOf('@') == val.length - 1 ||
                val.indexOf('@') == -1) 
            {
                toggleValid( element, false )
            }
            else {
                toggleValid( element, true )
                formValues.email = val
            }
            break
        case "password":
            if (val.length < 8) {
                toggleValid( element, false )
            }
            else {
                toggleValid( element, true )
                formValues.password = val
            }
            break
        case "confirm-password":
            // get value of password
            if( val != formValues.password ) {
                toggleValid( element, false )
            }
            else {
                toggleValid( element, true )
                formValues.confirmpassword = val
            }
            break
        default:
            break
    }
    // check that all values have been entered
    if( formValues.username != "" && 
        formValues.email != "" &&
        formValues.password != "" &&
        formValues.confirmpassword == formValues.password
    )
    {
        // enable the submit button by removing the disabled attribute
        btn.removeAttribute("disabled")
    }
})
