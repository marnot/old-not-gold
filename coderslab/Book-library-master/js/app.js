$(function () {
    $.ajax({
        url: 'api/books.php',
        type: 'GET',
        dataType: 'json',
        success: function (json) {
            for (var x in json) {
                $('table').append('<tr><td><p data-id="' + json[x].id + '">#' + json[x].id + ' ' + json[x].name + '</p><div></div></td></tr>');
            }
        }
    });



    $('table').on('click', 'p', function () {
        var id = $(this).data('id');
        var div = $(this).next();
        $.ajax({
            url: "api/books.php?id=" + $(this).data('id'),
            type: 'GET',
            data: {},

            dataType: 'json',
            success: function (json) {
                div.slideToggle("slow").html(json[id].description + '<br>' + json[id].author +
                        '<br><button data-id="' + json[id].id + '" id="delete">DELETE id:' + json[id].id + '</button>');

            }
        });
    });

    var name = $('#name');
    var author = $('#author');
    var description = $('#desc');

    var btn = $('#submit');
    btn.on('click', function () {
        $(this).preventDefault;
        $.ajax({
            url: "api/books.php",
            data: {
                name: name.val(),
                author: author.val(),
                description: description.val()
            },
            type: "POST",
            dataType: "json"
        });
    });
    $('#update').on('click', function () {

        var bookId = $(this).data('id');

        $.ajax({
            url: 'api/books.php',
            type: 'GET',
            dataType: "json",
            success: function (json) {
                $('#id').attr('value', json[bookId].id);
                $('#name').attr('value', json[bookId].name);
                $('#author').attr('value', json[bookId].author);
                $('#desc').attr('value', json[bookId].description);
            }
        });
        $('form').on('click', '#update', function () {
            $(this).preventDefault;
            $.ajax({
                url: "api/books.php",
                type: "PUT",
                data: {
                    id: $('#id').val(),
                    name: $('#name').val(),
                    author: $('#author').val(),
                    description: $('#desc').val()
                },
                dataType: "json",
                
            });
        });
    });
    $('table').on('click', '#delete', function () {
        var btn = $(this).parent().parent().parent();
        
        $.ajax({
            url: "api/books.php?id=",
            data: {
                id: $(this).data('id')
            },
            type: "DELETE",
            success: function(){
                btn.remove();
                location.reload();
            }
        });
    });
});