
const connections = require('../../database/mysql.connection');
const dates = require('../../utils/date');

create = (userParam) => {
    return new Promise(function (resolve, reject) {

        // mySQl query
        var sqlQuery = "INSERT INTO user_otps(user_id,otp,end_date,mobile,email,created)"
        sqlQuery = sqlQuery + " VALUES('" + userParam.user_id + "', '" + userParam.otp
            + "', DATE_ADD(NOW(), INTERVAL 60 MINUTE), '" + userParam.mobile + "', '" + userParam.email + "',UTC_TIMESTAMP())";

        //Execute query
        connections.ExecuteInsertQuery(sqlQuery)
            .then(data => {
                resolve(data);
            }).catch(err => {
                reject(err);
            });
    })
}

verifyOTP = (userParam) => {
    return new Promise(function (resolve, reject) {

        // mySQl query
        var sqlQuery = "Select * from user_otps WHERE mobile='" + userParam.mobile + "' AND otp = '" + userParam.otp + "' and end_date >= UTC_TIMESTAMP() ORDER BY id DESC LIMIT 1";

        //Execute query
        connections.ExecuteSelectQuery(sqlQuery)
            .then(data => {
                resolve(data);
            }).catch(err => {
                reject(err);
            });
    })
}


//export functions
module.exports = {
    create,
    verifyOTP
}