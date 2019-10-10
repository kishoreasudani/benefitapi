const coinService = require('../../services/v1/coins.service');
const utils = require('../../utils/util');
const message = require('../../config/message');

getList = async (req, reply) => {
    coinService.getList(req.body).then(response => {
        utils.sendSuccessResponse(response.length, response, reply);
    }).catch(err => {
        utils.sendAndWriteErrorResponse(err, reply);
    })
}


getTodayList = async (req, reply) => {
    coinService.getTodayList(req.body).then(response => {
        utils.sendSuccessResponse(response.length, response, reply);
    }).catch(err => {
        utils.sendAndWriteErrorResponse(err, reply);
    })
}




// earn coin by counting steps
earnCoin = async (req, reply) => {
    coinService.earnCoin(req.body).then(response => {
        utils.sendSuccessResponse(0, response, reply);
    }).catch(err => {
        utils.sendAndWriteErrorResponse(err, reply);
    })
}


//export functions
module.exports = {
    getList,
    earnCoin,
    getTodayList
}

