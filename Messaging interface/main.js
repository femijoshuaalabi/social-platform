let messages = [
    { id: "1", img: 1, name: "Audrey Malik" },
    { id: "2", img: 2, name: "George Owen" },
    { id: "3", img: 3, name: "Mikey Ross" },
    { id: "4", img: 4, name: "Rose Dawen" },
    { id: "5", img: 5, name: "Bob Patrick" },
    { id: "6", img: 6, name: "George Owen" },
    { id: "7", img: 7, name: "Mikey Ross" },
    { id: "8", img: 8, name: "Rose Dawen" },
    { id: "9", img: 9, name: "Bob Patrick" },
    { id: "10", img: 10, name: "Andrew Malik" },
    { id: "11", img: 11, name: "Jane Adney" },
]


window.addEventListener('load', msgBoxContent, false)
let msgBox = document.getElementById('msgBox')
function msgBoxContent() {
    for (let i = 0; i < messages.length; i++)
    {
        msgBox.innerHTML += `
                        <div id="msgList" key="${messages[i].id }" class="row no-gutters flex-nowrap align-items-center p-1">
                            <div>
                                <img src="../assets/img/pexels-photo-${ messages[i].img }.jpeg" alt="user image" class="rounded mt-4">
                            </div>
                            <div class="py-1 pl-3" style="max-width:82%;">
                                <p class="text-right my-0 mr-3"><span class="small "><small>Jan 23, 02:25PM</small></span></p>
                                <h6 class="my-0 font-weight-bolder">${ messages[i].name }</h6>
                                <p class="small my-0 text-muted text-truncate pr-2">
                                Lorem ipsum dolor sit, amet consectetur adipisicing elit.
                                Lorem ipsum dolor sit, amet consectetur adipisicing elit.
                                </p>
                            </div>
                        </div>
                        <hr>
        `
    }

    let msgColumn = document.getElementById("msgColumn")
    let chatColumn = document.getElementById("chatColumn")
    let returnBtn = document.querySelector("#chatColumn #return")
    let sendBtn = document.querySelector("#chatColumn .send")
    let msgList = document.querySelectorAll("#msgList")
    let currentChatImage = document.querySelector("#chatHead img")
    let currentChatName = document.querySelector("#chatHead h6")

    for (msg of msgList)
    {
        msg.addEventListener("click", getUserMessage, false)
        function getUserMessage(e) {
            let currentUser = messages.find(item => {
                if (item.id === e.currentTarget.getAttribute('key'))
                {
                    return item
                }
            })
            currentChatImage.setAttribute("src", "../assets/img/pexels-photo-" + currentUser.id + ".jpeg")
            currentChatName.textContent = currentUser.name

            if (window.matchMedia("(max-width: 768px)").matches)
            {
                msgColumn.classList.add("hide-sm-and-down")
                chatColumn.classList.remove("hide-sm-and-down")
            }
        }
    }

    returnBtn.onclick = function () {
        msgColumn.classList.remove("hide-sm-and-down")
        chatColumn.classList.add("hide-sm-and-down")
    }

    sendBtn.onclick = function (e) {
        e.preventDefault()

    }
}
