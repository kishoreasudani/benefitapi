
const connections = require('../../database/mysql.connection');
const voucherService = require('./voucher.service');
const coinService = require('./coins.service');
const enums = require('../../utils/enums');
const utils = require('../../utils/util');
const message = require('../../config/message');

//Get vouchers
getList = (postParams) => {
    return new Promise(function (resolve, reject) {
        // mySQl query

        //Pagination
        let pagingCondition = "";
        if (postParams.page_size > 0 && postParams.page_no > 0) {
            let offSet = parseInt(postParams.page_size) * (parseInt(postParams.page_no) - 1);
            pagingCondition = " LIMIT " + postParams.page_size + " OFFSET " + offSet
        }

        let condition = ""
        if (postParams.search_text != "" && postParams.search_text != null) {
            condition = " AND ( name LIKE '%" + postParams.search_text + "%'  OR code LIKE '%" + postParams.search_text
                + "%' OR vendors.description LIKE '%" + postParams.search_text + "%' ) ";
        }

        let sqlQuery = "Select vouchers.*,user_orders.id AS user_order_id ,vendors.logo as image, vendors.background_logo as bg_image,vendors.description as descriptions,vendors.terms_and_conditions from user_orders "
        sqlQuery = sqlQuery + " INNER JOIN vouchers on user_orders.reference_id=vouchers.id AND user_orders.reference_type='" + enums.enmReferenceType.voucher + "'"
          sqlQuery = sqlQuery + " INNER JOIN vendors on vendors.id=vouchers.vendor_id"
        sqlQuery = sqlQuery + " WHERE user_orders.user_id=" + postParams.user_id;
        sqlQuery = sqlQuery + condition + pagingCondition;

        //Execute query
        connections.ExecuteSelectQuery(sqlQuery)
            .then(data => {
                resolve(data);
            }).catch(err => {
                reject(err);
            });
    })
}


//buy boucher
//postParams.user_id
//postParams.reference_id
buyBoucher = (postParams) => {
    return new Promise(function (resolve, reject) {

        //Get boucher detail
        voucherService.getById(postParams.reference_id).then(voucherResult => {
            if (voucherResult != null && voucherResult.length > 0) {

                coinService.getUserCoins(postParams.user_id).then(coinResult => {
                    if (coinResult != null && coinResult.length > 0) {

                        let coins = coinResult[0].total_coins;
                        let postData = {
                            user_id: postParams.user_id
                            , coin_id: postParams.coin_id
                            , reference_id: postParams.reference_id
                            , coins: voucherResult[0].coins_required ? voucherResult[0].coins_required : 0
                            , type: enums.enmCoinTransType.used
                            , reference_type: enums.enmReferenceType.voucher
                        }
                        if (voucherResult[0].coins_required != null && voucherResult[0].coins_required > 0) {
                            if (coins >= voucherResult[0].coins_required) {


                               var checkExistenceCoucher = "Select count(id) as total from user_orders where reference_id =" +postParams.reference_id;
                               connections.ExecuteSelectQuery(checkExistenceCoucher)
                                .then(checkexistanceData => {
                                    if(checkexistanceData[0].total==0){
                                         updateUsedCoin(postData).then(saveResult => {
                                            createUserOrder(postData).then(res => {
                                                resolve(res);
                                            }).catch(err => {
                                                reject(err);
                                            })
                                        }).catch(err => {
                                            reject(err);
                                        })
                                    }else{
                                         let messagedata = 'This reward is no longer available.';
                                         let err = utils.errorResponse(message.coin_validation.statusCode, messagedata)
                                         reject(err);
                                    }
                                        


                                }).catch(err => {
                                      reject(err);
                                });
                           
                            }
                            else {
                                let err = utils.errorResponse(message.coin_validation.statusCode, message.coin_validation.not_enough_coin)
                                reject(err);
                            }
                        } else {
                            createUserOrder(postData).then(res => {
                                resolve(res);
                            }).catch(err => {
                                reject(err);
                            })
                        }
                    } else {
                        let err = utils.errorResponse(message.coin_validation.statusCode, message.coin_validation.not_enough_coin)
                        reject(err);
                    }
                }).catch(err => {
                    reject(err);
                })
            }
            else {
                let err = utils.errorResponse(message.voucher_validation.statusCode, message.voucher_validation.not_found)
                reject(err);
            }
        }).catch(err => {
            reject(err);
        })

    })
}



createUserOrder = (postData) => {
    return new Promise(function (resolve, reject) {

        let sqlQuery = "INSERT INTO user_orders(user_id,reference_id,reference_type,created)"
        sqlQuery = sqlQuery + " VALUES(" + postData.user_id + "," + postData.reference_id
            + ",'" + postData.reference_type + "',UTC_TIMESTAMP())"

        connections.ExecuteInsertQuery(sqlQuery)
            .then(data => {
                resolve(data);
            }).catch(err => {
                reject(err);
            });

    })
}

//CreateCoin History

//postParams.reference_id
//postParams.reference_type  //enum
//postParams.user_id
//postParams.coins
//postParams.type   //enum

createHistory = (postData) => {
    return new Promise(function (resolve, reject) {

        let sqlQuery = "INSERT INTO coin_history(user_id,reference_id,coins,type,reference_type,created)"
        sqlQuery = sqlQuery + " VALUES(" + postData.user_id + "," + postData.reference_id
            + "," + postData.coins + ",'" + postData.type + "','" + postData.reference_type + "',UTC_TIMESTAMP())"

        connections.ExecuteInsertQuery(sqlQuery)
            .then(data => {
                resolve(data);
            }).catch(err => {
                reject(err);
            });

    })
}

//Create initial user coins
//postParams.total_coins
//postParams.total_used
//postParams.user_id
createUserCoin = (postData) => {
    return new Promise(function (resolve, reject) {

        let sqlQuery = "INSERT INTO coins(user_id,total_coins,total_used,created,modified)"
        sqlQuery = sqlQuery + " VALUES(" + postData.user_id + "," + postData.total_coins
            + "," + postData.total_used + ",UTC_TIMESTAMP(),UTC_TIMESTAMP())"

        connections.ExecuteInsertQuery(sqlQuery)
            .then(data => {
                resolve(data);
            }).catch(err => {
                reject(err);
            });

    })
}

//update Earn Coins
///params///
//postParams.reference_id (Optional)
//postParams.reference_type (Optional)
//postParams.user_id
//postParams.coins
updateEarnCoin = (postParams) => {
    return new Promise(function (resolve, reject) {
        let historyData = {
            user_id: postParams.user_id
            , voucher_id: postParams.voucher_id
            , coins: postParams.coins
            , type: enums.enmCoinTransType.earn
        }

        let queryUserCoin = "Select * from coins WHERE user_id=" + postParams.user_id
        connections.ExecuteSelectQuery(queryUserCoin).then(data => {
            console.log(data)
            if (data != null && data.length > 0) {

                let sqlQuery = "UPDATE coins SET total_coins=((NULLIF(total_coins,0)) +" + postParams.coins + ")"
                sqlQuery = sqlQuery + " WHERE id=" + data[0].id

                connections.ExecuteUpdateQuery(sqlQuery).then(data => {

                    createHistory(historyData).then(item => {
                        resolve(item)
                    }).catch(err => {
                        reject(item)
                    })

                }).catch(err => {
                    reject(err);
                });

            }
            else {

                let userCoinData = {
                    user_id: postParams.user_id,
                    total_coins: postParams.coins,
                    total_used: 0
                }
                createUserCoin(userCoinData).then(items => {
                    resolve(items)
                }).catch(err => {
                    reject(err)
                })
            }
        }).catch(err => {
            reject(err)
        })

    })
}

//Update Used coins
///params///
//postParams.reference_id
//postParams.reference_type
//postParams.user_id
//postParams.coins
updateUsedCoin = (postParams) => {
    return new Promise(function (resolve, reject) {
        let historyData = {
            user_id: postParams.user_id
            , reference_id: postParams.reference_id ? postParams.reference_id : 0
            , coins: postParams.coins
            , type: enums.enmCoinTransType.used
            , reference_type: postParams.reference_type
        }

        //user Coins
        let queryUserCoin = "Select * from coins WHERE user_id=" + postParams.user_id
        connections.ExecuteSelectQuery(queryUserCoin).then(data => {

            if (data != null && data.length > 0) {
                let updateUsercoin =  data[0].total_coins-postParams.coins;
                 if(updateUsercoin<0){
                     updateUsercoin = 0;
                 }

               let total_used =   data[0].total_used+postParams.coins;

                let sqlQuery = "UPDATE coins SET total_used = " + total_used + " ,total_coins = "+updateUsercoin;
                sqlQuery = sqlQuery + " WHERE id=" + data[0].id

                //Update user coins
                connections.ExecuteUpdateQuery(sqlQuery).then(data => {

                    //Create Coin history
                    createHistory(historyData).then(item => {
                        resolve(item)
                    }).catch(err => {
                        reject(err)
                    })

                }).catch(err => {
                    reject(err);
                });
            }
            else {

                let userCoinData = {
                    user_id: postParams.user_id,
                    total_coins: 0,
                    total_used: postParams.coins
                }
                createUserCoin(userCoinData).then(items => {
                    resolve(items)
                }).catch(err => {
                    reject(err)
                })
            }
        }).catch(err => {
            reject(err)
        })
    })
}

//export functions
module.exports = {
    getList,
    buyBoucher
}