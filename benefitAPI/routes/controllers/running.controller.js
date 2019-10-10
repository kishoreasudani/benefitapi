const runningService = require('../../services/v1/running.service');
const utils = require('../../utils/util');
const message = require('../../config/message');

getList = async (req, reply) => {
    runningService.getList(req.body).then(response => {
        utils.sendSuccessResponse(response.length, response, reply);
    }).catch(err => {
        utils.sendAndWriteErrorResponse(err, reply);
    })
}


//export functions
module.exports = {
    getList
}