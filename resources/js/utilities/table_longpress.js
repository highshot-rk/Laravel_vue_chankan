require('./jquery.longpress.js');

$(function () {
    // ユーザーログイン時の長押し処理
    $('.table_longpress.user td').longpress(function() {
    // longpress callback
        var $cur_td = $(this)[0];
        window.location.href = '/projects/add?' + $cur_td.id;
    },
        function(){},
        800
    );

    // 担当者ログイン時の長押し処理
    $('.table_longpress.charge td').longpress(function() {
    // longpress callback
        var $cur_td = $(this)[0];
        window.location.href = '/charge/projects/add?' + $cur_td.id;
    },
        function(){},
        800
    );
});
