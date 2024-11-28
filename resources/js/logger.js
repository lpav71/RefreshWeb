const createLog = function (json_data, description, tab_name, user_id) {
    var myHeaders = new Headers();
    myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

    var urlencoded = new URLSearchParams();
    urlencoded.append("data", json_data);
    urlencoded.append("description", description);
    urlencoded.append("tab_name", tab_name);
    urlencoded.append("user_id", user_id);

    var requestOptions = {
        method  : 'POST',
        headers : myHeaders,
        body    : urlencoded,
        redirect: 'follow'
    };

    fetch("api/log/create", requestOptions);
};


export {createLog};
