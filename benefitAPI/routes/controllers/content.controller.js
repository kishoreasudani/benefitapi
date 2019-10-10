const pageService = require('../../services/v1/content.service');
const utils = require('../../utils/util');
const message = require('../../config/message');

getBySlug = async (req, reply) => {
    pageService.getBySlug(req.params.slug).then(response => {
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

//export functions
module.exports = {
    getBySlug
}