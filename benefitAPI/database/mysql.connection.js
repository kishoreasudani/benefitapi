
const Sequelize = require('sequelize');
const config = require('../config/config.json');// get our config file
const logger = require("../helpers/logger").Logger;

const moduleName = "mySql Connection"

// Option 1: Passing parameters separately
const sequelize = new Sequelize(config.mysql.database, config.mysql.username, config.mysql.password, {
    host: config.mysql.host,
    dialect: config.mysql.dialect,
    operatorsAliases: false
});

module.exports = {
    ExecuteSelectQuery,
    ExecuteInsertQuery,
    ExecuteUpdateQuery,
    sequelize,
    ExecuteDeleteQuery
};

//Execute query
function ExecuteSelectQuery(sqlQuery) {
    return new Promise(function (resolve, reject) {
        sequelize.query(sqlQuery, { type: sequelize.QueryTypes.SELECT })
            .then(data => {
                resolve(data);
            }).catch(err => {
                logger.error(moduleName, "ExecuteSelectQuery", err);
                reject(err);
            });
    })
}

//Execute query - insert new records
function ExecuteInsertQuery(sqlQuery) {
    return new Promise(function (resolve, reject) {
        sequelize.query(sqlQuery, { type: sequelize.QueryTypes.INSERT })
            .then(data => {
                resolve(data);
            }).catch(err => {
                logger.error(moduleName, "ExecuteInsertQuery", err);
                reject(err);
            });
    })
}

//Execute query - update records
function ExecuteUpdateQuery(sqlQuery) {
    return new Promise(function (resolve, reject) {
        sequelize.query(sqlQuery, { type: sequelize.QueryTypes.UPDATE })
            .then(data => {
                resolve(data);
            }).catch(err => {

                logger.error(moduleName, "ExecuteUpdateQuery", err);
                reject(err);
            });
    })
}

//Execute query - update records
function ExecuteDeleteQuery(sqlQuery) {
    return new Promise(function (resolve, reject) {
        sequelize.query(sqlQuery, { type: sequelize.QueryTypes.DELETE })
            .then(data => {
                resolve(data);
            }).catch(err => {

                logger.error(moduleName, "ExecuteUpdateQuery", err);
                reject(err);
            });
    })
}

// sequelize.authenticate().then(() => {
//     console.log('Connection has been established successfully.');
// }).catch(err => {
//     console.error('Unable to connect to the database:', err);
// });


// module.exports = {
//     SELECT: 'SELECT',
//     INSERT: 'INSERT',
//     UPDATE: 'UPDATE',
//     BULKUPDATE: 'BULKUPDATE',
//     BULKDELETE: 'BULKDELETE',
//     DELETE: 'DELETE',
//     UPSERT: 'UPSERT',
//     VERSION: 'VERSION',
//     SHOWTABLES: 'SHOWTABLES',
//     SHOWINDEXES: 'SHOWINDEXES',
//     DESCRIBE: 'DESCRIBE',
//     RAW: 'RAW',
//     FOREIGNKEYS: 'FOREIGNKEYS',
// };