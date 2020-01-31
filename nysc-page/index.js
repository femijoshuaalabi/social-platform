
const service = document.getElementById("corp-select")
const serviceActive = document.getElementById("active-input")
const serviceYear = document.getElementById("year-input")
const stateActive = document.getElementById("state-input")

const corp = document.getElementById("corp")
const active = document.getElementById("active")
const year = document.getElementById("year")
const state = document.getElementById("state")

const text =  document.getElementById('text')
const formText =  document.getElementById('form-text')
const buttonOne =  document.getElementById('button1')
const buttonTwo =  document.getElementById('button2')

function nysc() {
    if (service.value === "Current") {
        active.style.display="flex"
        active.style.padding="30px"
        active.style.marginTop="4%"
        active.style.height="200px"
        serviceActive.style.padding="10px"
        serviceActive.style.borderRadius="5px"
        serviceActive.style.width="300px"
        serviceActive.style.border="1px solid grey"
        serviceActive.style.marginTop="10px"
        corp.style.display="none"
        
    } else if(service.value === "Alumnus") {
        state.style.display="flex"
        state.style.padding="30px"
        state.style.marginTop="4%"
        state.style.height="200px"
        stateActive.style.padding="10px"
        stateActive.style.borderRadius="5px"
        stateActive.style.width="300px"
        stateActive.style.border="1px solid grey"
        stateActive.style.marginTop="10px"
        corp.style.display="none"
    } else {
        text.style.display="flex"
        corp.style.display="none"
        formText.style.display="none"
    }
}


function proceed() {
    if(serviceYear.value === "") {
        alert("please fill out the form")
    } else {
        alert("Are you sure you want to proceed")
        year.style.display="none"
        text.style.display="block"
        formText.style.display="none"
    }
    
}

function back() {
    year.style.display="none"
    active.style.display="flex"
    
}

function activeProceed() {
    if(serviceActive.value === '') {
        alert("please fill out the form")
    } else {
        alert(`You are currently serving at ${serviceActive.value} state, ${new Date().getFullYear() - 1}/${new Date().getFullYear()}`)
        year.style.display="none"
        active.style.display="none"
        text.style.display="block"
        formText.style.display="none"
    }
    
}
function activeProceedState() {
    if(stateActive.value === "") {
        alert("please fill out the form")
    } else {
        alert("Are you sure you want to proceed")
        year.style.display="flex"
        state.style.display="none"
    }
    
}

function activeBack() {
    active.style.display="none"
    corp.style.display="flex"
    state.style.display="none"
    
}