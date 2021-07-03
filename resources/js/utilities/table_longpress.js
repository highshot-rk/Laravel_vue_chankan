require('./jquery.longpress.js');

$(function () {
    // ユーザーログイン時の長押し処理
    $('.table_longpress.user td').longpress(function() {
    // longpress callback
        var $cur_td = $(this)[0];
        console.log($cur_td)
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


    // ユーザーログイン時の長押し処理
    // Create variable for setTimeout
    var delay;

    // Set number of milliseconds for longpress
    var longpress = 800;

    var listItems = document.querySelectorAll(".table_longpress.user td");
    var listItem;

    for (var i = 0, j = listItems.length; i < j; i++) {
      listItem = listItems[i];
      listItem.addEventListener('touchstart', function (e) {
        var _this = this;
        delay = setTimeout(check, longpress);

        function check() {
            window.location.href = '/projects/add?' + _this.id;
        }

      }, true);

        listItem.addEventListener('touchend', function (e) {
            // On mouse up, we know it is no longer a longpress
            clearTimeout(delay);
        });

    }

    var listItems2 = document.querySelectorAll(".table_longpress.charge td");
    var listItem2;

    for (var i = 0, j = listItems2.length; i < j; i++) {
        listItem2 = listItems2[i];
        listItem2.addEventListener('touchstart', function (e) {
            var _this = this;
            delay = setTimeout(check, longpress);

            function check() {
                window.location.href = '/charge/projects/add?' + _this.id;
            }

        }, true);

        listItem2.addEventListener('touchend', function (e) {
            // On mouse up, we know it is no longer a longpress
            clearTimeout(delay);
        });

    }
});
