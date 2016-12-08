$(document).ready(function() {

    bootbox.setLocale('pl');

    $('a[data-toggle="confirm"]').click(function() {
        var href = $(this).attr('href');
        var title = $(this).attr('title') != undefined ? $(this).attr('title') : "Jesteś pewien?!";
        bootbox.confirm(title, function(result) {
            if (result) window.location.href = href;
        });
        return false;
    });

});