
var cookieParser = require('cookie-parser');
const fastify = require('fastify')()
const logger = require("./helpers/logger").Logger;
const config = require('./config/message.json');// get our config file
const helmet = require('fastify-helmet')
//const mySqlConnections = require('./database/mysql.connection');
//const mongoConnections = require('./database/mongo.connection');

//middleware
const jwt = require('./middleware/jwt');
const path = require('path')

fastify.register(require('fastify-static'), {
  root: path.join(__dirname, 'data'),
  prefix: '/public/', // optional: default '/'
})

//Routing
const routes = require('./routes/routing');

routes.forEach((route, index) => {
  fastify.route(route)
})

//register helmet security patch
fastify.register(helmet)

fastify.use(cookieParser());

// Handle user request and identity request
fastify.use(function (req, res, next) {

  req.headers['Access-Control-Allow-Origin'] = '*';
  req.headers['Access-Control-Allow-Headers'] = 'Origin, X-Requested-With,Content-Type, Accept';
  req.headers['Access-Control-Allow-Methods'] = 'PUT,POST,DELETE,GET';

  if (req.url.toLowerCase() != '/api/v1/auth/login'
    && req.url.toLowerCase() != '/api/v1/user/sendotp'
    && req.url.toLowerCase() != '/api/v1/user/verifyotp'
    && req.url.toLowerCase() != '/api/v1/user/resetpassword'
    && req.url.toLowerCase() != '/api/v1/auth/register'
  ) {
    if (req.headers.authorization != null && req.headers.authorization != "") {
      if (jwt.verifyToken(req.headers.authorization)) {
        next()
      } else {
        const err = new Error();
        err.statusCode = config.unAuthorize.statusCode;
        err.message = config.unAuthorize.message;
        next(err)
      }
    } else {
      const err = new Error();
      err.statusCode = config.unAuthorize.statusCode;
      err.message = config.unAuthorize.message;
      next(err)
    }
  } else {
    next()
  }
});

//error handler
fastify.setErrorHandler(function (error, request, reply) {
  logger.error("app", "setErrorHandler", error);
  reply.send(error)
});

//fastify start
fastify.listen(3002, '127.0.0.1', function (err, res) {
  console.log('Pedometer api running on ' + res)
})