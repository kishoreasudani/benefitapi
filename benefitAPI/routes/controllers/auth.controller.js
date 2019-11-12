const jwt = require('../../middleware/jwt');
const authService = require('../../services/v1/auth.service');
const utils = require('../../utils/util');
const message = require('../../config/message');
const enums = require('../../utils/enums');

//Login user with Email& Password / Facebook / Google
login = async (req, reply) => {
    if (!utils.validateField(req.body.email)) {
        utils.sendErrorResponse(message.user_validation.statusCode, message.user_validation.email, reply);
    } else if (!utils.validateField(req.body.password) && !utils.validateField(req.body.token)) {
        utils.sendErrorResponse(message.user_validation.statusCode, message.user_validation.password, reply);
    } else {

        authService.Login(req.body).then(response => {
            if (response && response.length > 0) {
                const data = response[0];

                //check account active
                if (data.status.toLowerCase() == enums.enmUserStatus.active) {

                    const encryptPassword = utils.encryptPassword(req.body.password);
                    console.log(encryptPassword)
                    //check with password login
                    if (req.body.password != "" && req.body.password != null && data.password == encryptPassword
                        && (data.fb_token == "" || data.fb_token == null)
                        && (data.g_token == "" || data.g_token == null)) {

                        const token = jwt.generateToken({ id: data.id })
                        data["token"] = token;
                        utils.sendSuccessResponse(1, data, reply);
                    }
                    //check with facebook login
                    else if (data.fb_token == req.body.token && data.fb_token != "" && data.fb_token != null) {
                        const token = jwt.generateToken({ id: data.id })
                        data["token"] = token;
                        utils.sendSuccessResponse(1, data, reply);
                    }
                    //check with google login
                    else if (data.g_token == req.body.token && data.g_token != "" && data.g_token != null) {
                        const token = jwt.generateToken({ id: data.id })
                        data["token"] = token;
                        utils.sendSuccessResponse(1, data, reply);
                    } else if (data.g_token != "" && data.g_token != null) {
                        utils.sendErrorResponse(message.login_error.statusCode, message.login_error.google_account, reply)
                    }
                    //Invalid password 
                    else if (data.fb_token != "" && data.fb_token != null) {
                        utils.sendErrorResponse(message.login_error.statusCode, message.login_error.facebook_account, reply)
                    }
                    //Invalid password 
                    else {
                        utils.sendErrorResponse(message.login_error.statusCode, message.login_error.message, reply)
                    }

                } else if (data.status.toLowerCase() == enums.enmUserStatus.inactive) {
                    utils.sendErrorResponse(message.login_error.statusCode, message.login_error.inactive_message, reply)
                } else if (data.status.toLowerCase() == enums.enmUserStatus.deleted) {
                    utils.sendErrorResponse(message.login_error.statusCode, message.login_error.deleted_message, reply)
                } else if (data.status.toLowerCase() == enums.enmUserStatus.blocked) {
                    utils.sendErrorResponse(message.login_error.statusCode, message.login_error.blocked_message, reply)
                }
            } else {
                utils.sendErrorResponse(message.login_error.statusCode, message.login_error.not_found, reply)
            }
        }).catch(err => {
            utils.sendAndWriteErrorResponse(err, reply);
        })
    }
}

register = (req, reply) => {
    if (req.body.fb_token=="" && !utils.validateField(req.body.email)) {
        utils.sendErrorResponse(message.user_validation.statusCode, message.user_validation.email, reply);
    } else {

        authService.register(req.body).then(response => {

              //utils.sendSuccessResponse(1, response, reply);

            if (response!=null) {
                response.newCreated = response.newCreated;
                const data = response.user[0];

                //check with facebook login
                if (data.fb_token == req.body.fb_token && data.fb_token != "" && data.fb_token != null) {
                    const token = jwt.generateToken({ id: data.id })
                    data["token"] = token;
                    utils.sendSuccessResponse(1, data, reply);
                }
                //check with google login
                else if (data.g_token == req.body.g_token && data.g_token != "" && data.g_token != null) {
                    const token = jwt.generateToken({ id: data.id })
                    data["token"] = token;
                    utils.sendSuccessResponse(1, data, reply);
                }
                else if (response.newCreated == true) {
                    const token = jwt.generateToken({ id: data.id })
                    data["token"] = token;
                    utils.sendSuccessResponse(1, data, reply);
                } else if (response.newCreated == false && data.email.toLowerCase() == req.body.email.toLowerCase()) {
                    utils.sendErrorResponse(message.user_validation.statusCode, message.user_validation.email_already_exists, reply)
                } else if (response.newCreated == false && data.email.toLowerCase() != req.body.email.toLowerCase()
                    && data.mobile == req.body.mobile) {
                    utils.sendErrorResponse(message.user_validation.statusCode, message.user_validation.mobile_already_exists, reply)
                } else {
                    utils.sendErrorResponse(message.user_validation.statusCode, message.user_validation.mobile_email_already_exists, reply)
                }
            } else {
                utils.sendErrorResponse(message.login_error.statusCode, message.login_error.not_found, reply)
            }
            
        }).catch(err => {
            utils.sendAndWriteErrorResponse(err, reply);
        })
    }
}

//export functions
module.exports = {
    login,
    register
}
