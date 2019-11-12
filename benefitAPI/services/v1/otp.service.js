
const connections = require('../../database/mysql.connection');
const dates = require('../../utils/date');


create = (userParam) => {
    return new Promise(function (resolve, reject) {

           // send otp
            var otpMessage = "Verification OTP for Benefit App is "+ userParam.otp;
            var request = require("request");
            var options = {
                    method: 'GET',
                    url: 'http://sms.appcomlabs.com/api.php',
                    qs: 
                    {
                        username: 'Bikeshine',
                        password: 'bshine@17',
                        sender: 'BENFIT',
                        sendto: userParam.mobile,
                        message: otpMessage 
                    },
            };

            request(options, function (error, response, body) {
                if (error){ 
                    throw new Error(error);  
                     reject(error);

                }else{     
                    // mySQl query
                    var sqlQuery = "INSERT INTO user_otps(user_id,otp,end_date,mobile,email,otp_type,created)"
                    sqlQuery = sqlQuery + " VALUES('" + userParam.user_id + "', '" + userParam.otp
                        + "', DATE_ADD(NOW(), INTERVAL 10 MINUTE), '" + userParam.mobile + "', '" + userParam.email + "','" + userParam.otp_type + "',UTC_TIMESTAMP())";
                    //Execute query
                    connections.ExecuteInsertQuery(sqlQuery)
                        .then(data => {
                            resolve(data);
                        }).catch(err => {
                            reject(err);
                        });
                
                }
            });
  
    })
}



verifyOTP = (userParam) => {
    return new Promise(function (resolve, reject) {





        // mySQl query
        var sqlQuery = "Select * from user_otps WHERE mobile='" + userParam.mobile + "' AND otp = '" + userParam.otp + "' AND otp_type = '" + userParam.otp_type + "' AND end_date >= UTC_TIMESTAMP() ORDER BY id DESC LIMIT 1";

  

        //Execute query
        connections.ExecuteSelectQuery(sqlQuery)
            .then(data => {
                 

                if(userParam.otp_type == 'register'){
                   var updateUser = "UPDATE users SET verified = 'Yes' WHERE mobile ="+ userParam.mobile;
                    connections.ExecuteUpdateQuery(updateUser)
                        .then(updateData => {
                             resolve(data);
                        }).catch(err => {
                        });
                }else{
                   resolve(data);
                }
            }).catch(err => {
                reject(err);
            });
    })
}


//export functions
module.exports = {
    create,
    verifyOTP
}