import $ from "jquery"
import { AJYPost } from '../../scripts/AjuwayaRequests'


export class Networks {

    constructor(){
        //this.initiator()
    }


    UserNetworksForMessages = () => {

        const uid = $('#uid').val()
        const token = $('#token').val()
        const username = $('#username').val()
        let rowsPerPage = 8;

        const encodedata = {
            uid: uid,
            token: token,
            rowsPerPage: rowsPerPage
        }

        $.baseUrl = $('#BASE_URL').val()
        let apiBaseUrl = $.baseUrl + 'Aapi/friendsList'

        AJYPost(apiBaseUrl, encodedata).then((result) => {
            if (result.friendsList.length) {
                $.each(result.friendsList, function(i, data) {
                    const friendsList = `
                            <div id="msgList" key="${ data.uid }" class="row no-gutters flex-nowrap align-items-center p-1">
                                <div>
                                    <img src="${ data.profile_pic }" alt="${ data.username }" class="rounded">
                                </div>
                                <div class="py-1 pl-2 flex-grow-1" style="max-width:85%;">
                                    <div class="row no-gutters flex-nowrap justify-content-between align-items-center">
                                        <h6 class="mb-1 font-weight-bolder text-truncate" style="max-width:60%;">${ data.name }</h6>
                                   </div>
                                    <p class="small my-0 text-muted text-truncate pr-2">
                                    ${ data.status }
                                    </p>
                                </div> 
                            </div>
                            <hr class="my-3">
                    `
                    let msgBox = document.getElementById('displayUserFriendsList')
                    msgBox.innerHTML += friendsList
                })
            }
        })




    }

}

export default Networks

