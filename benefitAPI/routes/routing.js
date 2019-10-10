
const authController = require('./controllers/auth.controller');
const userController = require('./controllers/user.controller');
const notificationController = require('./controllers/notification.controller');
const voucherController = require('./controllers/voucher.controller');
const userOrderController = require('./controllers/user.order.controller');
const faqController = require('./controllers/faqs.controller');
const runningController = require('./controllers/running.controller');
const coinController = require('./controllers/coin.controller');
const pageController = require('./controllers/content.controller');

const basePath = '/api/v1/'

const routes = [

    //User Routing
    {
        method: 'POST',
        url: basePath + 'auth/login',
        handler: authController.login
    },
    {
        method: 'POST',
        url: basePath + 'auth/register',
        handler: authController.register
    },

    {
        method: 'PUT',
        url: basePath + 'user/changepassword',
        handler: userController.changePassword
    },
    {
        method: 'POST',
        url: basePath + 'user/sendotp',
        handler: userController.sendOTP
    },
    {
        method: 'POST',
        url: basePath + 'user/verifyotp',
        handler: userController.verifyOTP
    },
    {
        method: 'PUT',
        url: basePath + 'user/resetpassword',
        handler: userController.updatePassword
    },
    {
        method: 'PUT',
        url: basePath + 'user/updateprofile',
        handler: userController.updateProfile
    },
    {
        method: 'PUT',
        url: basePath + 'user/updateimage',
        handler: userController.updateImage
    }, 

     {
        method: 'POST',
        url: basePath + 'user/getUserProfile',
        handler: userController.getUserProfile
    },
 
   
    // notifications

    {
        method: 'GET',
        url: basePath + 'notification/:id',
        handler: notificationController.getUserNotification
    },
     {
        method: 'POST',
        url: basePath + 'notification',
        handler: notificationController.createNotification
    }, 
    {
        method: 'PUT',
        url: basePath + 'notification',
        handler: notificationController.updateNotification
    },

     {
        method: 'POST',
        url: basePath + 'notification/countNotification',
        handler: notificationController.countNotification
    },

    //Vouchers
    {
        method: 'GET',
        url: basePath + 'voucher/:id',
        handler: voucherController.getById
    },
    {
        method: 'POST',
        url: basePath + 'voucher/list',
        handler: voucherController.getList
    }

    //user Voucher
    ,
    {
        method: 'POST',
        url: basePath + 'userorder/list',
        handler: userOrderController.getList
    },
    {
        method: 'POST',
        url: basePath + 'userorder/buy',
        handler: userOrderController.buyVoucher
    }

    //Faqs
    , {
        method: 'POST',
        url: basePath + 'faqs/list',
        handler: faqController.getList
    }, {
        method: 'GET',
        url: basePath + 'faqs/:id',
        handler: faqController.getById
    }

    //Running
    , {
        method: 'POST',
        url: basePath + 'running/list',
        handler: runningController.getList
    },

    //Coins
    {
        method: 'POST',
        url: basePath + 'coins/list',
        handler: coinController.getList
    },

     {
        method: 'POST',
        url: basePath + 'coins/getTodayList',
        handler: coinController.getTodayList
    },

    {
        method: 'POST',
        url: basePath + 'coins/earnCoin',
        handler: coinController.earnCoin
    },

    //Static pages
    {
        method: 'GET',
        url: basePath + 'content/:slug',
        handler: pageController.getBySlug
    },

    // settings
 
    {
        method: 'GET',
        url: basePath + 'user/getSetting',
        handler: userController.getSetting
    },
]

module.exports = routes;