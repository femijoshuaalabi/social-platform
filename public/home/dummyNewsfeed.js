
let people = [
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
let dummyTopics = [
    { img: 1, title: "Technology" },
    { img: 2, title: "Management" },
    { img: 3, title: "Softwares" },
    { img: 4, title: "Business" },
    { img: 5, title: "Entertainment" },
]

window.addEventListener('load', loadDynamicItems, false)
function loadDynamicItems() {
    let addNewFriends = document.getElementById('addNewFriends')

    for (let i = 0; i < people.length; i++)
    {
        addNewFriends.innerHTML += `
                        <div id="newFriend" class="row no-gutters flex-nowrap align-items-center p-1">
                            <div>
                                <img src="public/home/assets/img/pexels-photo-${ people[i].img }.jpeg" alt="image" class="rounded">
                            </div>
                            <div class="py-1 pl-2 flex-grow-1" style="max-width:85%;">
                                <div>
                                    <h6 class="mb-0 font-weight-bolder text-truncate">${ people[i].name }</h6>
                                </div>
                                <p class="small my-0 text-muted text-truncate pr-2">
                                Student
                                </p>
                                <a class="small my-0 text-truncate pr-2" style="color: lightgreen;">
                                Connect
                                </a>
                            </div> 
                            <div style="width:10px;">
                                <p class="m-0 text-right mr-3"><span class="mdi mdi-close float-right"></span></p>
                            </div>
                        </div>
                        <hr class="my-1">
        `
    }

    let topics = document.querySelector("#cat .slots")
    for (let i = 0; i < dummyTopics.length; i++)
    {
        topics.innerHTML += `
            <div>
                <img src="public/home/assets/${dummyTopics[i].img }.jpg" alt="image">
                <span>${dummyTopics[i].title }</span>
            </div>        
        `
    }

    let vendors = document.querySelector("#vendors")
    for (let i = 0; i < 8; i++)
    {
        vendors.innerHTML += `
            <div class="row no-gutters flex-nowrap align-items-center p-1">
                <div class="py-1 pl-2 flex-grow-1" style="max-width:85%;">
                    <div>
                        <h6 class="mb-0 font-weight-bolder text-truncate">New Iris D9 Drone</h6>
                    </div>
                    <p class="small my-0 text-muted text-truncate pr-2">
                        #265,000
                    </p>
                </div>
                <div>
                    <img src="public/home/assets/img_1.jpg" alt="image" class="rounded"
                        style="width: 3rem; height: 3rem;">
                </div>
            </div>
            <hr class="my-1">      
        `
    }
}
