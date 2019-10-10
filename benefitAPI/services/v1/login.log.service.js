
const connections = require('../../database/mysql.connection');
const dates = require('../../utils/date');

create = (userParam) => {
    return new Promise(function (resolve, reject) {

        var timeStamp = dates.getUTCTimestamp();

        // mySQl query
        var sqlQuery = "INSERT INTO user_login_logs(user_id,ip_address,created)"
        sqlQuery = sqlQuery + " VALUES(" + userParam.user_id + ", '" + userParam.ip_address + "',UTC_TIMESTAMP())";

        //Execute query
        connections.ExecuteInsertQuery(sqlQuery)
            .then(data => {
                resolve(data);
            }).catch(err => {
                reject(err);
            });
    })
}


//export functions
module.exports = {
    create
}