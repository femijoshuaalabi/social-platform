
const service = document.getElementById("corp-select")
const serviceActive = document.getElementById("active-select")
const serviceYear = document.getElementById("year-input")

const corp = document.getElementById("corp")
const active = document.getElementById("active")
const year = document.getElementById("year")

const text =  document.getElementById('text')
const buttonOne =  document.getElementById('button1')
const buttonTwo =  document.getElementById('button2')

function nysc() {
    if (service.value === "Yes") {
        active.style.display="flex"
        active.style.padding="30px"
        active.style.marginTop="4%"
        active.style.height="200px"
        corp.style.display="none"
        
    } else {
        text.style.display="flex"
        corp.style.display="none"
    }
}
function serviceAction() {
    if (serviceActive.value === "Alumni") {
       year.style.display="block"
       year.style.padding="30px"
       year.style.marginTop="4%"
       year.style.height="200px"
       active.style.display="none"
    } else if(serviceActive.value === "Current") {
        alert(`You are selecting the current year ${new Date().getFullYear()}`)
        text.style.display="flex"
        active.style.display="none"
    }
}

function proceed() {
    alert("Are you sure you want to proceed")
    year.style.display="none"
    text.style.display="block"
}

function back() {
    year.style.display="none"
    active.style.display="flex"
    
}