const userService = require('../../services/v1/user.service');
const utils = require('../../utils/util');
const message = require('../../config/message');
const otpService = require('../../services/v1/otp.service');

//change password 
changePassword = async (req, reply) => {
    if (!utils.validateNumericField(req.body.id)) {
        utils.sendErrorResponse(message.user_validation.statusCode, message.user_validation.user_id, reply);
    } else if (!utils.validateField(req.body.old_password)) {
        utils.sendErrorResponse(message.user_validation.statusCode, message.user_validation.old_password, reply);
    } else if (!utils.validateField(req.body.new_password)) {
        utils.sendErrorResponse(message.user_validation.statusCode, message.user_validation.new_password, reply);
    } else if (req.body.new_password == req.body.old_password) {
        utils.sendErrorResponse(message.user_validation.statusCode, message.user_validation.new_old_password, reply);
    } else {
        userService.getById(req.body.id).then(response => {
            if (response && response.length > 0) {
                var data = response[0];
                const encryptPassword = utils.encryptPassword(req.body.old_password);
                if (encryptPassword == data.password) {

                    //update password
                    req.body["password"] = req.body.new_password;
                    userService.updatePassword(req.body).then(response => {
                        utils.sendSuccessResponse(1, response, reply);
                    }).catch(err => {
                        utils.sendAndWriteErrorResponse(err, reply);
                    })

                } else {
                    utils.sendErrorResponse(message.user_validation.statusCode, message.user_validation.invalid_old_password, reply)
                }
            } else {
                utils.sendErrorResponse(message.user_validation.statusCode, message.user_validation.not_found, reply)
            }
        }).catch(err => {
            utils.sendAndWriteErrorResponse(err, reply);
        })
    }
}

//generate otp for forget password
sendOTP = async (req, reply) => {
    if (!utils.validateNumericField(req.body.mobile)) {
        utils.sendErrorResponse(message.user_validation.statusCode, message.user_validation.mobile, reply);
    } else {
        userService.getByMobileOrEmail(req.body.mobile).then(response => {
            if (response && response.length > 0) {
                var data = response[0];

                var otp = utils.generateRndInteger(999999, 100000);
                var postData = {
                    user_id: data.id,
                    mobile: data.mobile,
                    email: data.email,
                    otp: otp,
                    otp_type: req.body.otp_type,
   
                }

                //Generate otp
                otpService.create(postData).then(response => {
                    utils.sendSuccessResponse(1, postData, reply);
                }).catch(err => {
                    utils.sendAndWriteErrorResponse(err, reply);
                })

            } else {
                utils.sendErrorResponse(message.user_validation.statusCode, message.user_validation.not_found, reply)
            }
        }).catch(err => {
            utils.sendAndWriteErrorResponse(err, reply);
        })
    }
}

//Verify otp
verifyOTP = async (req, reply) => {
    if (!utils.validateNumericField(req.body.mobile)) {
        utils.sendErrorResponse(message.user_validation.statusCode, message.user_validation.mobile, reply);
    } if (!utils.validateNumericField(req.body.otp)) {
        utils.sendErrorResponse(message.user_validation.statusCode, message.user_validation.otp, reply);
    } else {
             var postData = {
                    mobile: req.body.mobile,
                    otp: req.body.otp,
                    otp_type: req.body.otp_type
                }
        otpService.verifyOTP(postData).then(response => {
            if (response && response.length > 0) {
                var data = response[0];
                utils.sendSuccessResponse(1, data, reply);
            } else {
                utils.sendErrorResponse(message.user_validation.statusCode, message.user_validation.otp_verify, reply)
            }
        }).catch(err => {
            utils.sendAndWriteErrorResponse(err, reply);
        })
    }
}

//Update new password from forget password
updatePassword = async (req, reply) => {
    if (!utils.validateNumericField(req.body.id)) {
        utils.sendErrorResponse(message.user_validation.statusCode, message.user_validation.user_id, reply);
    } else if (!utils.validateField(req.body.password)) {
        utils.sendErrorResponse(message.user_validation.statusCode, message.user_validation.password, reply);
    } else {

        //update password
        userService.updatePassword(req.body).then(response => {
            utils.sendSuccessResponse(1, response, reply);
        }).catch(err => {
            utils.sendAndWriteErrorResponse(err, reply);
        })

    }
}

//update profile  
updateProfile = async (req, reply) => {
    if (!utils.validateNumericField(req.body.id)) {
        utils.sendErrorResponse(message.user_validation.statusCode, message.user_validation.user_id, reply);
    } else if (!utils.validateField(req.body.first_name)) {
        utils.sendErrorResponse(message.user_validation.statusCode, message.user_validation.first_name, reply);
    } else {
        userService.updateProfile(req.body).then(response => {
            utils.sendSuccessResponse(1, response, reply);
        }).catch(err => {
            utils.sendAndWriteErrorResponse(err, reply);
        })

    }
}

//update profile  picture
updateImage = async (req, reply) => {
    if (!utils.validateNumericField(req.body.id)) {
        utils.sendErrorResponse(message.user_validation.statusCode, message.user_validation.user_id, reply);
    } else {
        
        userService.updateImage(req.body).then(response => {
            utils.sendSuccessResponse(1, response, reply);
        }).catch(err => {
            utils.sendAndWriteErrorResponse(err, reply);
        })

    }
}

// get user profile data

getUserProfile = async (req, reply) => {
        userService.getUserProfile(req.body.id).then(response => {
            utils.sendSuccessResponse(1, response, reply);
        }).catch(err => {
            utils.sendAndWriteErrorResponse(err, reply);
        })    
}



// get setting table data
getSetting = async (req, reply) => {
        userService.getSetting(req.body).then(response => {
            utils.sendSuccessResponse(1, response, reply);
        }).catch(err => {
            utils.sendAndWriteErrorResponse(err, reply);
        })    
}


updateNotificationStatus = async (req, reply) => {
    userService.updateNotificationStatus(req.body).then(response => {
        utils.sendSuccessResponse(response[0], response[0], reply);
    }).catch(err => {
        utils.sendAndWriteErrorResponse(err, reply);
    })
}





//export functions
module.exports = {
    changePassword,
    sendOTP,
    verifyOTP,
    updatePassword,
    updateProfile,
    updateImage,
    getSetting,
    getUserProfile,
    updateNotificationStatus
}