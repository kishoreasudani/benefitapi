

mongoose = require('mongoose');
dbMongoSaveConn = mongoose.createConnection('mongodb://192.168.1.3:27017/cinema_audit', { useNewUrlParser: true });
module.exports = dbMongoSaveConn;