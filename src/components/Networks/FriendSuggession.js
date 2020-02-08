import $ from "jquery"
import { AJYPost } from '../../scripts/AjuwayaRequests' 
import { addFriend } from './addFriend'

export class FriendSuggession {

    constructor(){
        this.initiator()
    }


    initiator = () => {
        this.FriendSuggessionList()
    }

    FriendSuggessionList = () => {

        let uid = $('#uid').val();
        let token =  $('#token').val();

        let encodedata = {
            uid: uid,
            token: token
        }
    
        $.baseUrl = $('#BASE_URL').val()
        let apiBaseUrl = $.baseUrl + 'Aapi/suggestedFriends'

        AJYPost(apiBaseUrl,encodedata).then((result) => {
            if (result.welcomeFriends.length) {
                $.each(result.welcomeFriends, (i, data) => {
                    if (data.role != "fri") {
                        let friendButton = '<button class="addButton" id="add' + data.uid + '">Follow</button>' +
                                            '<button class="removeButton display_none" id="remove' + data.uid + '" disabled="" >Following</button>';

                        let friendsList = `
                            <div class="card" style="height: auto; width: 200px; margin-bottom: 25px;">
                                <p>${data.name}</p>
                                ${friendButton}
                            </div>
                        `

                        $('#friendSuggestion').append(friendsList)
                    }
                })
            }
        })

        $('body').on("click", '.addButton', function() {
            var x = $(this).attr("id");
            var sid = x.split("add");
            var fid = sid[1];
            addFriend(uid, fid, token);
            return false;
        })
    }

}

export default FriendSuggession

