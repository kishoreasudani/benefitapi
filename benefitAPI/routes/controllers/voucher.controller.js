const voucherService = require('../../services/v1/voucher.service');
const utils = require('../../utils/util');
const message = require('../../config/message');

getList = async (req, reply) => {
    voucherService.getList(req.body).then(response => {
        utils.sendSuccessResponse(response.length, response, reply);
    }).catch(err => {
        utils.sendAndWriteErrorResponse(err, reply);
    })
}

getById = async (req, reply) => {
    if (!utils.validateField(req.params.id)) {
        utils.sendErrorResponse(message.voucher_validation.statusCode, message.voucher_validation.voucher_id, reply);
    } else {
        voucherService.getById(req.params.id).then(response => {
            if (response != null && response.length > 0) {
                utils.sendSuccessResponse(response.length, response[0], reply);
            }
            else {
                utils.sendErrorResponse(message.voucher_validation.statusCode, message.voucher_validation.not_found, reply)
            }
        }).catch(err => {
            utils.sendAndWriteErrorResponse(err, reply);
        })
    }
}

//export functions
module.exports = {
    getList,
    getById
}