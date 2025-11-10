// javascript for form validation
// create reference to form
const form = document.querySelector("#signup")
let password = null
// function to show valid or invalid fields. 
// element = input, state = boolean
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
    const val = event.target.value
    const name = event.target.name
    
    //console.log( element, val )
    // check which element and which value is being interacted with
    switch( name ) {
        case "username" :
            if( val.length < 3 || val.length > 16 ) {
                // invalid
                toggleValid( element, false )
            }
            else {
                // valid
                toggleValid( element, true )
            }
            break
        case "email" :
            if( val.indexOf("@") == 0 || // if @ is the first character
                val.indexOf("@") == val.length -1 || // if @ is the last character
                val.indexOf("@") == -1 // if there is no @ in the input
            ) {
                toggleValid( element, false )
            }
            else {
                toggleValid( element, true )
            }
            break
        case "password" :
            if( val.length < 8 ) {
                toggleValid( element, false )
            }
            else {
                toggleValid( element, true )
            }
            password = val
            break
        case "confirm-password" :
            console.log( password, val )
            if( val != password ) {
                toggleValid( element, false )
            }
            else {
                toggleValid( element, true )
            }
            break
        default:
            break

    }
})
// when form is submitted
form.addEventListener('submit', function (event) {
    // event.preventDefault()
    // // a number of errors
    // let errors = { username: 0, email: 0, password1: 0, password2: 0 }
    // const data = new FormData(form)
    // // check if first password is at least 8 characters
    // const password1 = data.get("password")
    // if (password1.length < 8) {
    //     document.querySelector("#password").classList.add("is-invalid")
    //     errors.password1 = 1
    // }
    // else {
    //     document.querySelector("#password").classList.remove("is-invalid")
    //     document.querySelector("#password").classList.add("is-valid")
    //     errors.password1 = 0
    // }
    // // check if first and second password fields are the same
    // const password2 = data.get("confirm-password")
    // if (password2 != password1) {
    //     document.querySelector("#confirm-password").classList.add("is-invalid")
    //     errors.password2 = 1
    // }
    // else {
    //     document.querySelector("#confirm-password").classList.remove("is-invalid")
    //     document.querySelector("#confirm-password").classList.add("is-valid")
    //     errors.password2 = 0
    // }
    // // check if email contains errors
    // const email = data.get("email")
    // if (email.indexOf('@') == 0 ||
    //     email.indexOf('@') == email.length - 1 ||
    //     email.indexOf('@') == -1) {
    //     document.querySelector("#email").classList.add("is-invalid")
    //     errors.email = 1
    // }
    // else {
    //     document.querySelector("#email").classList.remove("is-invalid")
    //     document.querySelector("#email").classList.add("is-valid")
    //     errors.email = 0
    // }
    // // check if username has value of more than 3 characters and less than 16
    // const username = data.get("username")
    // if (username.length < 3 || username.length > 16) {
    //     document.querySelector("#username").classList.add("is-invalid")
    //     errors.username = 1
    // }
    // else {
    //     document.querySelector("#username").classList.remove("is-invalid")
    //     document.querySelector("#username").classList.add("is-valid")
    //     errors.username = 0
    // }
    // // submit if there are no errors
    // if (
    //     errors.username == 0 &&
    //     errors.password1 == 0 &&
    //     errors.password2 == 0 &&
    //     errors.email == 0
    // ) {
    //     // form.submit()
    //     const url = "/signup.php"
    //     const request = fetch(url, { method: "POST" })
    // }
})