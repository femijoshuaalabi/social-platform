/*****************************************************************************
                            Ajax Post Request
*****************************************************************************/
export function AJYPost(URL, userData){
    return new Promise((resolve, reject) =>{
        fetch(URL, {
            method: 'POST',
            body: JSON.stringify(userData)
          })
          .then((response) => response.json())
          .then((res) => {
            resolve(res);
          })
          .catch((error) => {
            reject(error);
          });
      });
}

/*****************************************************************************
                            Ajax Get Request
*****************************************************************************/
export function AJYGet(){
    $('#login').on('click', function(){
        console.log('Hello from here');
    })
}