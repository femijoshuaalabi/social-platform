
if (!Array.prototype.find)
{
    Object.defineProperty(Array.prototype, 'find', {
        value: function (predicate) {
            if (this == null)
            {
                throw TypeError('"this" is null or not defined')
            }
            var o = Object(this)
            var len = o.length >>> 0
            if (typeof predicate !== 'function')
            {
                throw TypeError('predicate must be a function')
            }
            var thisArg = arguments[1]
            var k = 0
            while (k < len)
            {
                var kValue = o[k]
                if (predicate.call(thisArg, kValue, k, o))
                {
                    return kValue
                }
                k++
            }
            return undefined
        },
        configurable: true,
        writable: true
    })
}
var messages = [
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
function msgBoxContent() {
    var msgBox = document.getElementById('msgBox')
    for (var i = 0; i < messages.length; i++)
    {
        msgBox.innerHTML += "\n<div id=\"msgList\" key=\"" + messages[i].id + "\" class=\"row no-gutters flex-nowrap align-items-center p-1\">\n                            <div>\n                                <img src=\"../assets/img/pexels-photo-" + messages[i].img + ".jpeg\" alt=\"user image\" class=\"rounded mt-4\">\n                            </div>\n                            <div class=\"py-1 pl-3\" style=\"max-width:82%;\">\n                                <p class=\"text-right my-0 mr-3\"><span class=\"small \"><small>Jan 23, 02:25PM</small></span></p>\n                                <h6 class=\"my-0 font-weight-bolder\">" + messages[i].name + "</h6>\n                                <p class=\"small my-0 text-muted text-truncate pr-2\">\n                                Lorem ipsum dolor sit, amet consectetur adipisicing elit.\n                                Lorem ipsum dolor sit, amet consectetur adipisicing elit.\n                                </p>\n                            </div>\n                        </div>\n                        <hr>\n        "
    }
    var msgColumn = document.getElementById("msgColumn")
    var chatColumn = document.getElementById("chatColumn")
    var returnBtn = document.querySelector("#chatColumn #return")
    var sendBtn = document.querySelector("#chatColumn .send")
    var msgList = document.querySelectorAll("#msgList")
    var currentChatImage = document.querySelector("#chatHead img")
    var currentChatName = document.querySelector("#chatHead h6")
    var html = document.querySelector("html")
    var chatBox = document.querySelector("#chatBox .conversation-container")
    msgBox.addEventListener("click", getUserMessage, false)
    function getUserMessage(e) {
        var currentUser = messages.find(function (item) {
            var neededTarget = e.target.closest('#msgList')
            if (item.id === neededTarget.getAttribute('key'))
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
    returnBtn.onclick = function () {
        msgColumn.classList.remove("hide-sm-and-down")
        chatColumn.classList.add("hide-sm-and-down")
    }
    sendBtn.onclick = function (e) {
        e.preventDefault()
    }
}


console.log(ConversationLists)