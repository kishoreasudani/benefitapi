
const connections = require('../../database/mysql.connection');
const enums = require('../../utils/enums');

//Get page by slug
getBySlug = (slug) => {
    return new Promise(function (resolve, reject) {
        // mySQl query      
        const sqlQuery = "Select * from pages WHERE slug='" + slug + "'";

        //Execute query
        connections.ExecuteSelectQuery(sqlQuery)
            .then(data => {
                resolve(data);
            }).catch(err => {
                reject(err);
            });
    })
}


getCities = (slug) => {
    return new Promise(function (resolve, reject) {
        // mySQl query      
        const sqlQuery = "Select * from cities order by city_name ASC";
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
    getBySlug,
    getCities
}