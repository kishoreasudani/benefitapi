
const connections = require('../../database/mysql.connection');
const enums = require('../../utils/enums');
const utils = require('../../utils/util');
const dates = require('../../utils/date');

//Get Coin History
getList = (postParams) => {
    return new Promise(function (resolve, reject) {
        let totalcoin = "select total_coins from coins WHERE user_id=" + postParams.user_id;
         connections.ExecuteSelectQuery(totalcoin)
            .then(totalcoinData => {
              let last7Days = "select sum(coins) as totalCoins ,DAYNAME(created) as DateOnly , created from coin_history WHERE user_id=" + postParams.user_id +" And created >= (DATE(NOW()) - INTERVAL 7 DAY) GROUP BY DateOnly order by created DESC ";
                connections.ExecuteSelectQuery(last7Days)
                .then(last7DaysData => {

                  let currentMonth = "SELECT SUM(coins) AS totalCoins FROM coin_history WHERE user_id=" + postParams.user_id +" AND  MONTH(created) = MONTH(NOW())";

                    connections.ExecuteSelectQuery(currentMonth)
                    .then(currentMonthData => {
                         
                         let todayQuery = "select sum(coins) as totalCoins from coin_history WHERE user_id=" + postParams.user_id +" And created >= DATE(NOW())";

                          connections.ExecuteSelectQuery(todayQuery)
                             .then(todayData => {

                          let finalData = new Object();
                          finalData['totalCoin'] = totalcoinData.length>0?totalcoinData[0].total_coins:0;
                          finalData['currentMonth'] = currentMonthData[0].totalCoins!=null?currentMonthData[0].totalCoins:0;
                          finalData['todayCoin'] = todayData[0].totalCoins!=null?todayData[0].totalCoins:0;
                          finalData['last7days'] = last7DaysData;
                           resolve(finalData);
                          }).catch(err => {
                              reject(err);
                           });


                    }).catch(err => {
                         reject(err);
                    });
                }).catch(err => {
                    reject(err);
                });
            }).catch(err => {
                reject(err);
            });




    })
}




//Get today Coin and steps History
getTodayList = (postParams) => {
    return new Promise(function (resolve, reject) {
          let todayAvgCoin = "SELECT AVG(coins) AS avgcoin from coin_history  WHERE user_id=" + postParams.user_id +" And type='earn' And created >= DATE(NOW())";
            connections.ExecuteSelectQuery(todayAvgCoin)
            .then(avgCoin => {
            	  let todayAvgSteps = "SELECT AVG(steps) AS avgsteps from user_steps  WHERE user_id=" + postParams.user_id +" AND  created >= DATE(NOW())";
            	 connections.ExecuteSelectQuery(todayAvgSteps)
                 .then(avgsteps => {
                          let finalData = new Object();
                          finalData['avgCoin'] = avgCoin[0].avgcoin!=null?avgCoin[0].avgcoin:0;
                          finalData['avgsteps'] = avgsteps[0].avgsteps!=null?avgsteps[0].avgsteps:0;
                          resolve(finalData);

                   }).catch(err => {
                    reject(err);
                 });



            }).catch(err => {
                 reject(err);
            });

    })
}




//Get coins for user using user id
getUserCoins = (user_id) => {
    return new Promise(function (resolve, reject) {
        // mySQl query.
        let sqlQuery = "Select * from coins WHERE user_id=" + user_id;

        //Execute query
        connections.ExecuteSelectQuery(sqlQuery)
            .then(data => {
                resolve(data);
            }).catch(err => {
                reject(err);
            });
    })
}


// entry of earn coin by user
earnCoin= (postParams) => {
    return new Promise(function (resolve, reject) {
        // mySQl query
        let user_id = postParams.user_id;
        let steps = postParams.steps;
        let selectPreviousSteps = "Select * from user_steps where user_id ="+user_id + " AND DATE(created) = DATE(UTC_TIMESTAMP()) order by id desc limit 1";
        connections.ExecuteSelectQuery(selectPreviousSteps)
            .then(selectPreviousStepsData => { 
                  let previousSetps = 0;
                  let newSteps = steps;
                  if(selectPreviousStepsData!=null && selectPreviousStepsData.length>0){
                  	  previousSetps = selectPreviousStepsData[0].steps;
                        newSteps = steps-previousSetps;
                  }   

                  let sqlQuery = "Select coins,coins_step from settings WHERE id= 1";
                    connections.ExecuteSelectQuery(sqlQuery)
                      .then(data => {
                            let  settingCoinStep = data[0].coins_step;
                            let settingCoin =  data[0].coins;
                            let tenthPosSteps = 0;
                            let finalCoinStep = 0;
                            if(previousSetps == 0){
                              tenthPosSteps = Math.floor(steps/settingCoinStep)*100;
                              finalCoinStep = steps;
                            }else{
                              tenthPosSteps = Math.floor(previousSetps/settingCoinStep)*100;
                              finalCoinStep = steps - tenthPosSteps;
                            }
                            if(newSteps > 0 && finalCoinStep >= settingCoinStep){

                               let insertSteps = "INSERT INTO user_steps(user_id,steps,created)";
                                                insertSteps = insertSteps + " VALUES('" + user_id + "','" + steps + "',UTC_TIMESTAMP())";  
                                 connections.ExecuteInsertQuery(insertSteps)
                                  .then(insertStepsData => {
                                            let checkStep = finalCoinStep/settingCoinStep;
                                            let coin = 0;
                                            checkStep =  Math.floor(checkStep);
                                            coin = checkStep*settingCoin;
                                            var query = "INSERT INTO coin_history(user_id,coins,type,created)";
                                            query = query + " VALUES('" + user_id + "','" + coin + "','earn',UTC_TIMESTAMP())";  
                                            connections.ExecuteInsertQuery(query)
                                                .then(data1 => {
                                                 let getPreviousCoin = "select total_coins from coins where user_id = "+user_id;
                                                    connections.ExecuteSelectQuery(getPreviousCoin)
                                                    .then(data2 => {
                                                        if(data2.length>0){
                                                            let totalCoin = coin+data2[0].total_coins; 
                                                           var updateCoin = "Update coins SET modified=UTC_TIMESTAMP(), total_coins='" + totalCoin
                                                                + "' WHERE user_id='" + user_id+"'";

                                                            connections.ExecuteUpdateQuery(updateCoin)
                                                                .then(data => {
                                                                     resolve(totalCoin);
                                                                }).catch(err => {
                                                                });
                                          
                                                           
                                                        }else{

                                                         let totalCoin = coin;
                                                         var insertCoin = "INSERT INTO coins(user_id,total_coins,created)";
                                                         insertCoin = insertCoin + " VALUES('" + user_id + "','" + totalCoin + "',UTC_TIMESTAMP())";  
                                                         connections.ExecuteInsertQuery(insertCoin)
                                                                .then(data => {
                                                                     resolve(totalCoin);
                                                                }).catch(err => {
                                                                });
                                                        }
                                                       
                                                    }).catch(err => {
                                                           reject(err);
                                                    });

                                                }).catch(err => {
                                                     reject(err);
                                                });
                                }).catch(err => {
                                      reject(err);
                                  });

                            }else{
                              resolve(0);
                            }

                       }).catch(err => {
                            reject(err);
                        });
                  	                 
       }).catch(err => {
            reject(err);
       });
        

    })
}


//export functions
module.exports = {
    getList,
    getUserCoins,
    earnCoin,
    getTodayList
}