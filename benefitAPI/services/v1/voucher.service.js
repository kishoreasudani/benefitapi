
const connections = require('../../database/mysql.connection');
const enums = require('../../utils/enums');

//Get vouchers
getList = (postParams) => {
    return new Promise(function (resolve, reject) {
        // mySQl query

        /* two differnt query 
         SELECT * FROM vendors ORDER BY id DESC

        SELECT * FROM vouchers 
        WHERE vendor_id=28 AND id NOT IN (SELECT reference_id FROM user_orders WHERE reference_type="voucher")
        ORDER BY id DESC
        LIMIT 1
         end */

        //Pagination
        let pagingCondition = "";
        if (postParams.page_size > 0 && postParams.page_no > 0) {
            let offSet = parseInt(postParams.page_size) * (parseInt(postParams.page_no) - 1);
            pagingCondition = " LIMIT " + postParams.page_size + " OFFSET " + offSet
        }

        let condition = ""
        if (postParams.search_text != "" && postParams.search_text != null) {
            condition = " AND (A.name LIKE '%" + postParams.search_text + "%'  OR A.description LIKE '%" + postParams.search_text + "%'  OR B.name LIKE '%" + postParams.search_text + "%'  OR B.code LIKE '%" + postParams.search_text
                + "%' OR B.description LIKE '%" + postParams.search_text + "%' ) ";
        }


        let sqlQuery = "SELECT A.id AS vendorID, A.vendor_url , A.logo AS image , A.background_logo AS bg_image,A.name AS vendorName, B.id, MAX(B.id) AS maxid ,B.name, B.code,B.coins_required,B.discount_type,B.amount,B.max_discount,B.min_purchase,B.start_date,B.end_date,B.descriptions,B.terms_and_conditions,B.created,B.modified FROM vendors AS A JOIN vouchers AS B ON A.id=B.vendor_id  WHERE B.status='" + enums.enmVoucherStatus.active + "' AND B.end_date>=UTC_DATE()  AND B.id NOT IN (SELECT reference_id FROM user_orders WHERE reference_type='voucher') GROUP BY B.vendor_id ORDER BY maxid DESC";

        sqlQuery = sqlQuery + condition + pagingCondition;
         // console.log(sqlQuery)

        //Execute query
        connections.ExecuteSelectQuery(sqlQuery)
            .then(data => {
                resolve(data);
            }).catch(err => {
                reject(err);
            });
    })
}

/*



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
                + "%' OR description LIKE '%" + postParams.search_text + "%' ) ";
        }

        let sqlQuery = "Select * from vouchers WHERE status='" + enums.enmVoucherStatus.active + "' AND end_date>=UTC_DATE() ORDER BY id DESC ";
        sqlQuery = sqlQuery + condition + pagingCondition;
        console.log(sqlQuery)

        //Execute query
        connections.ExecuteSelectQuery(sqlQuery)
            .then(data => {
                resolve(data);
            }).catch(err => {
                reject(err);
            });
    })
}




*/


//Get voucher details by id
getById = (id) => {
    return new Promise(function (resolve, reject) {
        // mySQl query      
        const sqlQuery = "Select * from vouchers WHERE id=" + id;

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