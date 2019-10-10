
const connections = require('../../database/mysql.connection');
const dates = require('../../utils/date');

create = (userParam) => {
    return new Promise(function (resolve, reject) {

        // mySQl query
        var sqlQuery = "INSERT INTO user_devices(user_id,device_type,device_id,device_token,created)"
        sqlQuery = sqlQuery + " VALUES('" + userParam.user_id + "', '" + userParam.device_type
            + "', '" + userParam.device_id + "', '" + userParam.device_token + "',UTC_TIMESTAMP())";

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