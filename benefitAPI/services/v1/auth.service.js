
const connections = require('../../database/mysql.connection');
const loginLogService = require('./login.log.service');
const deviceService = require('./user.device.service');
const dates = require('../../utils/date');
const userService = require('./user.service');
const utils = require('../../utils/util');
const message = require('../../config/message');


//update login history
updateLastLogin = (userParam) => {
    return new Promise(function (resolve, reject) {

        // mySQl query
        var sqlQuery = "Update users SET last_login=UTC_TIMESTAMP(), last_login_ip='" + userParam.ip_address + "' WHERE id='" + userParam.user_id + "'";

        //Execute query
        connections.ExecuteUpdateQuery(sqlQuery)
            .then(data => {
                resolve(data);
            }).catch(err => {
                reject(err);
            });
    })
}

//Login user
Login = (userParam) => {
    return new Promise(function (resolve, reject) {
        //Check email user
        userService.getByEmailorPassword(userParam).then(response => {
            if (response != null && response.length > 0) {
                var data = response[0]
                userParam.user_id = data.id;
                createUserLogs(userParam);
                resolve(response);
            } else {
                resolve(response);
            }
        }).catch(err => {
            reject(err);
        });
    })
}

createUserLogs = (userParams) => {
    //save login history
    loginLogService.create({ user_id: userParams.user_id, ip_address: userParams.ip_address })

    //save device details
    deviceService.create({
        user_id: userParams.user_id, device_type: userParams.device_type
        , device_token: userParams.device_token, device_id: userParams.device_id
    })

    //update - last login and ip info
    updateLastLogin({ user_id: userParams.user_id, ip_address: userParams.ip_address })
}

//Register user
register = (userParam) => {

    return new Promise(function (resolve, reject) {   

        userParam.fb_token = userParam.fb_token!=''? userParam.fb_token : "";
        userParam.g_token = userParam.g_token!=''? userParam.g_token : "";

        if (userParam.fb_token != "") {
            userParam.password = "";
            userService.getByEmail(userParam.email).then(response => {
                if (response != null && response.length > 0) {
                    userParam.user_id = response[0].id;

                    //Write login logs
                    createUserLogs(userParam);

                    //Get created user
                    userService.getById(userParam.user_id).then(user => {
                          let result = {
                                        'newCreated': true,
                                         'user': user
                                      }
                             resolve(result);

                    }).catch(err => {
                        reject(err);
                    })

                } else {
                    userService.createUser(userParam).then(item => {
                        userParam.user_id = item[0]

                        //Write login logs
                        createUserLogs(userParam);

                        //Get created user
                        userService.getById(userParam.user_id).then(user => {
                             let result = {
                                        'newCreated': true,
                                         'user': user
                                      }
                             resolve(result);
                        }).catch(err => {
                            reject(err);
                        })

                    }).catch(err => {
                        reject(err);
                    })
                }
            }).catch(err => {
                reject(err);
            })
        } else if (userParam.g_token != "") {
            userParam.password = ""; 

            userService.getByEmail(userParam.email).then(response => {

                //resolve(response);

                if (response != null && response.length > 0) {
                    userParam.user_id = response[0].id
                    createUserLogs(userParam);

                    userService.getById(userParam.user_id).then(user => {
                            let result = {
                                        'newCreated': true,
                                         'user': user
                                      }
                            resolve(result);
                        }).catch(err => {
                            reject(err);
                        })
                     
                } else {
                    userService.createUser(userParam).then(item => {
                       // console.log(item)
                        userParam.user_id = item[0]
                        //Write login logs
                        createUserLogs(userParam);
                        //Get created user
                        userService.getById(userParam.user_id).then(user => {
                            let result = {
                                        'newCreated': true,
                                         'user': user
                                      }
                            resolve(result);
                        }).catch(err => {
                            reject(err);
                        })

                    }).catch(err => {
                        reject(err);
                    })
                }
            }).catch(err => {
                reject(err);
            })
        } else if (utils.validateField(userParam.password)) {

            //Encrypt password
            userParam.password = utils.encryptPassword(userParam.password);

            //Get user by email
            userService.getByEmail(userParam.email).then(response => {
                if (response != null && response.length > 0) {
                    let err = utils.errorResponse(message.user_validation.statusCode, message.user_validation.email_already_exists)
                    reject(err);
                } else {

                    userService.getByMobile(userParam.mobile).then(response => {
                        if (response != null && response.length > 0) {
                            let err = utils.errorResponse(message.user_validation.statusCode, message.user_validation.mobile_already_exists)
                            reject(err);
                        } else {

                            //Create user if not exist
                            userService.createUser(userParam).then(item => {
                               // console.log(item)
                                userParam.user_id = item[0]
                                //Write login logs
                                createUserLogs(userParam);

                                //Get created user
                                userService.getById(userParam.user_id).then(user => {
                                     let result = {
                                        'newCreated': true,
                                         'user': user
                                      }
                                    resolve(result);
                                }).catch(err => {
                                    reject(err);
                                })

                            }).catch(err => {
                                reject(err);
                            })
                        }
                    }).catch(err => {
                        reject(err);
                    })
                }
            }).catch(err => {
                reject(err);
            })
        } else {
            let err = utils.errorResponse(message.user_validation.statusCode, message.user_validation.password)
            reject(err);
        }
      
    })
}

//Register user old register api
register1 = (userParam) => {

    return new Promise(function (resolve, reject) {

        userParam.fb_token = userParam.fb_token ? userParam.fb_token : "";
        userParam.g_token = userParam.g_token ? userParam.g_token : ""

        //Encrypt password
        if (userParam.fb_token != "" || userParam.fb_token != "") {
            userParam.password = ""
        }
        else {
            userParam.password = utils.encryptPassword(userParam.password);
        }

        //Get user by email
        userService.getByEmail(userParam.email).then(response => {
            if (response != null && response.length > 0) {
                userParam.user_id = response[0].id
                //Write login logs
                createUserLogs(userParam);

                let result = {
                    'newCreated': false,
                    'user': response
                }

                resolve(result);
            } else {
                if (utils.validateField(userParam.mobile)) {
                    userService.getByMobile(userParam.mobile).then(response => {
                        if (response != null && response.length > 0) {
                            userParam.user_id = response[0].id
                            //Write login logs
                            createUserLogs(userParam);
                            let result = {
                                'newCreated': false,
                                'user': response
                            }
                            resolve(result);
                        } else {
                            //Create user if not exist
                            userService.createUser(userParam).then(item => {

                                userParam.user_id = item[0]
                                //Write login logs
                                createUserLogs(userParam);

                                //Get created user
                                userService.getById(userParam.user_id).then(user => {
                                    let result = {
                                        'newCreated': true,
                                        'user': user
                                    }
                                    resolve(result)
                                }).catch(err => {
                                    reject(err);
                                })

                            }).catch(err => {
                                reject(err);
                            })
                        }
                    }).catch(err => {
                        reject(err);
                    })
                } else {
                    //Create user if not exist
                    userService.createUser(userParam).then(item => {

                        userParam.user_id = item[0]
                        //Write login logs
                        createUserLogs(userParam);

                        //Get created user
                        userService.getById(userParam.user_id).then(user => {
                            let result = {
                                'newCreated': true,
                                'user': user
                            }
                            resolve(result)
                        }).catch(err => {
                            reject(err);
                        })

                    }).catch(err => {
                        reject(err);
                    })
                }
            }
        }).catch(err => {
            reject(err);
        })
    })
}


//export functions
module.exports = {
    Login,
    updateLastLogin,
    register,
    register1
}