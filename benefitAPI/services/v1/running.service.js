
const connections = require('../../database/mysql.connection');
const enums = require('../../utils/enums');

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

        let sqlQuery = "Select * from running_history WHERE user_id=" + postParams.user_id;
        sqlQuery = sqlQuery + pagingCondition;

        //Execute query
        connections.ExecuteSelectQuery(sqlQuery)
            .then(data => {
                resolve(data);
            }).catch(err => {
                reject(err);
            });
    })
}


//export functions
module.exports = {
    getList
}