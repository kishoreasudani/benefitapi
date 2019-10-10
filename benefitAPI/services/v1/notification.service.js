
const connections = require('../../database/mysql.connection');
const dates = require('../../utils/date');
const config = require('../../config/config');
var FCM = require('fcm-node');
var serverKey = config.fcm.serverKey; //put your server key here
var fcm = new FCM(serverKey);

//Get user notifications
getNotification = (user_id) => {
    return new Promise(function (resolve, reject) {
        // mySQl query
        const sqlQuery = "Select * from user_notifications WHERE receiver_id='" + user_id + "' AND status='active'";
        //Execute query
        //AND read_status='unread'
        connections.ExecuteSelectQuery(sqlQuery)
            .then(data => {
                resolve(data);
            }).catch(err => {
                reject(err);
            });
    })
}

//Update notification
update = (params) => {
    return new Promise(function (resolve, reject) {

        var timeStamp = dates.getUTCTimestamp();
        var sqlQuery = "";
        if (params.id > 0) {
            // mySQl query
            sqlQuery = "Update user_notifications SET modified=UTC_TIMESTAMP(), read_status='" + params.read_status
                + "', status='" + params.status
                + "' WHERE id=" + params.id;
        } else {
            sqlQuery = "Update user_notifications SET modified=UTC_TIMESTAMP(), read_status='" + params.read_status
                + "', status='" + params.status
                + "' WHERE read_status='unread' and receiver_id=" + params.user_id;
        }

        //Execute query
        connections.ExecuteUpdateQuery(sqlQuery)
            .then(data => {
                resolve(data);
            }).catch(err => {
                reject(err);
            });
    })
}

//Create notification
create = (params) => {
    return new Promise(function (resolve, reject) {

        var timeStamp = dates.getUTCTimestamp();
        var sqlQuery = "";

        // mySQl query
        sqlQuery = "INSERT INTO user_notifications (type,reference_id,sender_id,receiver_id,message,read_status,status,created,modified)"
        sqlQuery = sqlQuery + " VALUES('" + params.type + "', '" + params.reference_id
            + "', '" + params.sender_id + "', '" + params.receiver_id + "', '" + params.message + "', '" + params.read_status + "', '" + params.status + "','" + timeStamp + "',UTC_TIMESTAMP())";

        //Execute query
        connections.ExecuteUpdateQuery(sqlQuery)
            .then(data => {
                const sqlQuery = "Select * from user_devices WHERE user_id='" + params.receiver_id + "'";
                //Execute query
                connections.ExecuteSelectQuery(sqlQuery)
                    .then(data => {
                        data.map(users => {
                            var message = {
                                to: users.device_token,
                                notification: {
                                    title: 'Pedometer',
                                    body: params.message
                                },
                            };
                            fcm.send(message, function (err, response) {
                                if (err) {
                                    reject(err);
                                } else {
                                    resolve(response);
                                }
                            });
                        })
                    }).catch(err => {
                        reject(err);
                    });
                resolve(data);
            }).catch(err => {
                reject(err);
            });
    })
}

//count unread user notifications
countNotification = (params) => {
    return new Promise(function (resolve, reject) {
        let user_id = params.user_id;
        // mySQl query
        const sqlQuery = "Select count(id) as totalCount from user_notifications WHERE receiver_id='" + user_id + "' AND status='active' AND read_status='unread'";
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
    getNotification,
    update,
    create,
    countNotification
}