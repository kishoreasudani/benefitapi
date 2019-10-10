const faqsService = require('../../services/v1/faqs.service');
const utils = require('../../utils/util');
const message = require('../../config/message');

getList = async (req, reply) => {
    faqsService.getList(req.body).then(response => {
        utils.sendSuccessResponse(response.length, response, reply);
    }).catch(err => {
        utils.sendAndWriteErrorResponse(err, reply);
    })
}

getById = async (req, reply) => {
    if (!utils.validateField(req.params.id)) {
        utils.sendErrorResponse(message.faq_validation.statusCode, message.faq_validation.voucher_id, reply);
    } else {
        faqsService.getById(req.params.id).then(response => {
            if (response != null && response.length > 0) {
                utils.sendSuccessResponse(response.length, response[0], reply);
            }
            else {
                utils.sendErrorResponse(message.faq_validation.statusCode, message.faq_validation.not_found, reply)
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