
const connections = require('../../database/mysql.connection');
const enums = require('../../utils/enums');

//Get faqs list
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
            condition = " AND ( question LIKE '%" + postParams.search_text + "%'  OR answer LIKE '%" + postParams.search_text
                + "%') ";
        }

        let sqlQuery = "Select * from faqs WHERE status='" + enums.enmVoucherStatus.active + "'";
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


//Get faq details by id
getById = (id) => {
    return new Promise(function (resolve, reject) {
        // mySQl query      
        const sqlQuery = "Select * from faqs WHERE id=" + id;

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
    getList,
    getById
}