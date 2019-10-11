
const connections = require('../../database/mysql.connection');
const utils = require('../../utils/util');
const dates = require('../../utils/date');
const enums = require('../../utils/enums');

// Get user by id
getById = (id) => {
    return new Promise(function (resolve, reject) {
        // mySQl query
        const sqlQuery = "Select * from users WHERE id='" + id + "'";
        //Execute query
        connections.ExecuteSelectQuery(sqlQuery)
            .then(data => {
                resolve(data);
            }).catch(err => {
                reject(err);
            });
    })
}

// Get user by filters
getByFilter = (params) => {
    return new Promise(function (resolve, reject) {
        // mySQl query

        let sqlQuery = "Select * from users WHERE id=id ";
        if (params.mobile != null && params.mobile != "") {
            sqlQuery = sqlQuery + " AND mobile='" + params.mobile + "'"
        }
        if (params.email != null && params.email != "") {
            sqlQuery = sqlQuery + " AND email='" + params.email + "'"
        }
        sqlQuery = sqlQuery + " LIMIT 1"

        //Execute query
        connections.ExecuteSelectQuery(sqlQuery)
            .then(data => {
                resolve(data);
            }).catch(err => {
                reject(err);
            });
    })
}

// Get register with fb using email
checkFacebookUser_WithEmail = (params) => {
    return new Promise(function (resolve, reject) {
        // mySQl query

        let sqlQuery = "Select * from users WHERE email='" + params.email + "' AND fb_token='" + params.fb_token + "'";

        //Execute query
        connections.ExecuteSelectQuery(sqlQuery)
            .then(data => {
                resolve(data);
            }).catch(err => {
                reject(err);
            });
    })
}

// Get register with fb using mobile
checkFacebookUser_WithMobile = (params) => {
    return new Promise(function (resolve, reject) {
        // mySQl query

        let sqlQuery = "Select * from users WHERE mobile='" + params.email + "' AND fb_token='" + params.fb_token + "'";

        //Execute query
        connections.ExecuteSelectQuery(sqlQuery)
            .then(data => {
                resolve(data);
            }).catch(err => {
                reject(err);
            });
    })
}

// Get user by filters
checkGoogleUser = (params) => {
    return new Promise(function (resolve, reject) {
        // mySQl query

        let sqlQuery = "Select * from users WHERE email='" + params.email + "' AND g_token='" + params.g_token + "'";

        //Execute query
        connections.ExecuteSelectQuery(sqlQuery)
            .then(data => {
                resolve(data);
            }).catch(err => {
                reject(err);
            });
    })
}

//User by mobile number
getByMobileOrEmail = (mobile) => {
    return new Promise(function (resolve, reject) {
        // mySQl query
        const sqlQuery = "Select * from users WHERE mobile='" + mobile + "' OR email='" + mobile + "'";
        //Execute query
        connections.ExecuteSelectQuery(sqlQuery)
            .then(data => {
                resolve(data);
            }).catch(err => {
                reject(err);
            });
    })
}

//User by mobile number
getByMobile = (mobile) => {
    return new Promise(function (resolve, reject) {
        // mySQl query
        const sqlQuery = "Select * from users WHERE mobile='" + mobile + "'";
        //Execute query
        connections.ExecuteSelectQuery(sqlQuery)
            .then(data => {
                resolve(data);
            }).catch(err => {
                reject(err);
            });
    })
}

//User by email
getByEmail = (email) => {
    return new Promise(function (resolve, reject) {
        // mySQl query
        const sqlQuery = "Select * from users WHERE email='" + email + "'";
        //Execute query
        connections.ExecuteSelectQuery(sqlQuery)
            .then(data => {
                resolve(data);
            }).catch(err => {
                reject(err);
            });
    })
}



getByEmailorPassword = (userParam) => {
    return new Promise(function (resolve, reject) {
        // mySQl query
          const encryptPassword = utils.encryptPassword(userParam.password);
        const sqlQuery = "Select * from users WHERE email='" + userParam.email + "' and password = '"+encryptPassword+"'";
        //Execute query
        connections.ExecuteSelectQuery(sqlQuery)
            .then(data => {
                resolve(data);
            }).catch(err => {
                reject(err);
            });
    })
}





//Update password
updatePassword = (userParam) => {
    return new Promise(function (resolve, reject) {

        var timeStamp = dates.getUTCTimestamp();
        const encryptPassword = utils.encryptPassword(userParam.password);

        // mySQl query
        var sqlQuery = "Update users SET modified=UTC_TIMESTAMP(), password='" + encryptPassword
            + "', modified_by='" + userParam.id + "' WHERE id='" + userParam.id + "'";

        //Execute query
        connections.ExecuteUpdateQuery(sqlQuery)
            .then(data => {

                var query = "INSERT INTO user_passwords(user_id,password,created)"
                query = query + " SELECT " + userParam.id + ",'" + userParam.password + "',UTC_TIMESTAMP()";

                connections.ExecuteUpdateQuery(query)
                    .then(data => {
                    }).catch(err => {
                    });

                resolve(data);
            }).catch(err => {
                reject(err);
            });
    })
}

//Update profile
updateProfile = (userParam) => {
    return new Promise(function (resolve, reject) {

        var timeStamp = dates.getUTCTimestamp();

        // mySQl query
        var sqlQuery = "Update users SET modified=UTC_TIMESTAMP(), first_name='" + userParam.first_name
            + "', last_name='" + userParam.last_name
			+ "', mobile='" + userParam.mobile
            + "', dob ='" + userParam.dob
            + "', modified_by='" + userParam.id
			+ "' WHERE id='" + userParam.id + "'" ;

        //Execute query
        connections.ExecuteUpdateQuery(sqlQuery).then(data => {
            resolve(data);
        }).catch(err => {
            reject(err);
        });

    })
}

//Update image
updateImage = (userParam) => {
    return new Promise(function (resolve, reject) {
                       //benefitadmin/data/user
    	 resolve(userParam);

    	 return false;

        // mySQl query
        var sqlQuery = "Update users SET modified=UTC_TIMESTAMP(), avatar='" + userParam.avatar
            + "', modified_by='" + userParam.id + "' WHERE id='" + userParam.id + "'";

        //Execute query
        connections.ExecuteUpdateQuery(sqlQuery)
            .then(data => {
                resolve(data);
            }).catch(err => {
                reject(err);
            });
    })
}

createUser = (userParam) => {
    return new Promise(function (resolve, reject) {

        // mySQl query
        var sqlQuery = "INSERT INTO users(first_name,last_name,password,email,modified,created,status,fb_token,g_token,email_notifications,push_notifications,user_role_type,mobile) "
        sqlQuery = sqlQuery + " VALUES('" + userParam.first_name + "','" + userParam.last_name + "','" + userParam.password + "','" + userParam.email + "',UTC_TIMESTAMP,UTC_TIMESTAMP,'" + enums.enmUserStatus.active + "','" + userParam.fb_token + "','" + userParam.g_token + "','" + enums.enmEmailNotifications.yes + "','" + enums.enmPushNotifications.yes + "','" + enums.enmRoles.user + "','" + userParam.mobile + "')";

        //Execute query
        connections.ExecuteInsertQuery(sqlQuery)
            .then(data => {
                resolve(data);
            }).catch(err => {
                reject(err);
            });
    })
}


getUserProfile = (user_id) => {
    return new Promise(function (resolve, reject) {
        // mySQl query
        const sqlQuery = "Select * from users where id = "+user_id;
        //Execute query
        connections.ExecuteSelectQuery(sqlQuery)
            .then(data => {
                resolve(data);
            }).catch(err => {
                reject(err);
            });
    })
}



getSetting = (user) => {
    return new Promise(function (resolve, reject) {
        // mySQl query
        const sqlQuery = "Select * from settings limit 1 ";
        //Execute query
        connections.ExecuteSelectQuery(sqlQuery)
            .then(data => {
                resolve(data);
            }).catch(err => {
                reject(err);
            });
    })
}


updateNotificationStatus = (params) => {
    return new Promise(function (resolve, reject) {
        let user_id = params.id;
        let status = params.notificationStatus;
        // mySQl query
       var sqlQuery = "Update users SET modified=UTC_TIMESTAMP(), push_notifications='" +status
            + "', modified_by='" + user_id + "' WHERE id='" + user_id + "'";
    
        connections.ExecuteUpdateQuery(sqlQuery)
            .then(data => {
                resolve(data);
            }).catch(err => {
                reject(err);
            });
    })
}





//export functions
module.exports = {
    getById,
    getByMobile,
    getByEmail,
    updatePassword,
    updateProfile,
    updateImage,
    getByMobileOrEmail,
    getByFilter,
    checkFacebookUser_WithEmail,
    checkFacebookUser_WithMobile,
    checkGoogleUser,
    createUser,
    getSetting,
    getByEmailorPassword,
    getUserProfile,
    updateNotificationStatus
}