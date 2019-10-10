const userOrderService = require('../../services/v1/user.order.service');
const utils = require('../../utils/util');
const message = require('../../config/message');

getList = (req, reply) => {
    userOrderService.getList(req.body).then(response => {
        utils.sendSuccessResponse(response.length, response, reply);
    }).catch(err => {
        utils.sendAndWriteErrorResponse(err, reply);
    })
}

buyVoucher = (req, reply) => {
    if (!utils.validateNumericField(req.body.reference_id)) {
        utils.sendErrorResponse(message.coin_validation.statusCode, message.coin_validation.reference_id, reply);
    } if (!utils.validateNumericField(req.body.user_id)) {
        utils.sendErrorResponse(message.coin_validation.statusCode, message.coin_validation.user_id, reply);
    } else {
        userOrderService.buyBoucher(req.body).then(response => {
            utils.sendSuccessResponse(0, response, reply);
        }).catch(err => {
            utils.sendAndWriteErrorResponse(err, reply);
        })
    }
}

//export functions
module.exports = {
    getList,
    buyVoucher
}