var mongoose = require('mongoose');
var mongoCon = require('../mongo.connection.js');
var Schema = mongoose.Schema;

var questionSchema = new Schema({
    _id: Object
    , audit_schedule_id: Number
    , audit_schedule_department_id: Number
    , audit_questionnaire: Object
}, { versionKey: false });

questionSchema.set('collection', 'audit_schedule_questionnaires');
var questionModel = mongoCon.model("audit_schedule_questionnaires", questionSchema);
exports.questionModel = questionModel;