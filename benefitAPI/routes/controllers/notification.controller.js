const notificationService = require('../../services/v1/notification.service');
const utils = require('../../utils/util');
const message = require('../../config/message');

getUserNotification = async (req, reply) => {
    if (!utils.validateField(req.params.id)) {
        utils.sendErrorResponse(message.user_validation.statusCode, message.user_validation.user_id, reply);
    } else {
        notificationService.getNotification(req.params.id).then(response => {
            utils.sendSuccessResponse(response.length, response, reply);
        }).catch(err => {
            utils.sendAndWriteErrorResponse(err, reply);
        })
    }
}

updateNotification = async (req, reply) => {

    notificationService.update(req.body).then(response => {
        utils.sendSuccessResponse(response, response, reply);
    }).catch(err => {
        utils.sendAndWriteErrorResponse(err, reply);
    })
}

createNotification = async (req, reply) => {
    notificationService.create(req.body).then(response => {
        utils.sendSuccessResponse(response, response, reply);
    }).catch(err => {
        utils.sendAndWriteErrorResponse(err, reply);
    })
}


countNotification = async (req, reply) => {
    notificationService.countNotification(req.body).then(response => {
        utils.sendSuccessResponse(response[0], response[0], reply);
    }).catch(err => {
        utils.sendAndWriteErrorResponse(err, reply);
    })
}

//export functions
module.exports = {
    getUserNotification,
    createNotification,
    updateNotification,
    countNotification
}