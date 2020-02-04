
/*****************************************************************************
                THIS FUNCTION CONVERT TIMESTARP TO READABLE TIME
*****************************************************************************/
export function TimeConverter(timestarp) {     
    let a = new Date(timestarp * 1000);
    let today = new Date();
    let yesterday = new Date(Date.now() - 86400000);
    let months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    let year = a.getFullYear();
    let month = months[a.getMonth()];
    let date = a.getDate();
    let hour = a.getHours();
    let min = a.getMinutes();
    if (a.setHours(0,0,0,0) == today.setHours(0,0,0,0))
        return 'today at ' + hour + ':' + min;
    else if (a.setHours(0,0,0,0) == yesterday.setHours(0,0,0,0))
        return 'yesterday at ' + hour + ':' + min;
    else if (year == today.getFullYear())
        return date + ' ' + month + ', ' + hour + ':' + min;
    else
        return date + ' ' + month + ' ' + year + ', ' + hour + ':' + min;
}