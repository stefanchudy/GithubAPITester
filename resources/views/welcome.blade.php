<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>GitHub API Tester</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            input {
                padding: 5px 10px;
                border: 1px solid #ccc;
            }

            button {
                padding: 5px 10px;
                background: #03A9F4;
                border: 1px solid #03A9F4;
                color: white;
            }

            table {
                font-size: 16px;
                font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
                border-collapse: collapse;
                border-spacing: 0;
                width: 100%;
            }
            th {
                padding-top: 11px;
                padding-bottom: 11px;
                background-color: #4CAF50;
                color: white;
            }
            th, td {
                border: 1px solid #ddd;
                text-align: left;
                padding: 8px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <input type="text" name="name" id="name" placeholder="Input GitHub Username to Search" value="taylorotwell">
            <button onclick="getNameList()">Search</button>
        </div>
        <div>
            <p id="search_result">Search result for ""</p>
            <p id="total_count">Total count: </p>
            <table class="table table-striped table-hover ">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>profileURL</th>
                        <th>Avatar</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="user_list"></tbody>
            </table>
            <p id="show_more" style="display: none;"><a href="#" onclick="showMore();">Show more...</a></p>
        </div>
    </body>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script type="text/javascript">
        function getNameList() {
            var keyword = $('#name').val();
            $.ajax({
                url: '/getNameList/' + keyword,
                success: function(res) {
                    var ret = { total_count: 0 };
                    try {
                        eval("ret=" + res + ";");
                    } catch (e) {}
                    console.log(ret);
                    refreshResult(ret);
                }
            });
        }

        var page = 1;
        function refreshResult(res) {
            $('#search_result').html('Search result for "' + $('#name').val() + '"');
            $('#total_count').html("Total count: " + res.total_count);

            if (res.total_count == 0) {
                return;
            }

            var inner_html = ''
            for (var i = 0; i < res.items.length; i++) {
                var user = res.items[i];
                inner_html += '<tr><td>' + (i + 1) +
                    '</td><td>' + user.login +
                    '</td><td>' + user.html_url +
                    '</td><td><img height="50px" src="' + user.avatar_url + '"/>' +
                    '</td><td><a href="/followers/' + user.login + '">View followers</a>'
                    '</td></tr>';
            }

            if ((page - 1) * 30 + res.items.length < res.total_count) {
                page++;
                $('#show_more').show();
            }
            $('#user_list').html(inner_html);
        }

        function showMore() {
            $('#show_more').hide();

            var keyword = $('#name').val();

            $.ajax({
                url: '/getNameList/' + keyword + '?page=' + page,
                success: function(res) {
                    var ret = { total_count: 0 };
                    try {
                        eval("ret=" + res + ";");
                    } catch (e) {}

                    if (ret.total_count == 0) {
                        return;
                    }
                    
                    // show more
                    var inner_html = ''
                    for (var i = 0; i < ret.items.length; i++) {
                        var user = ret.items[i];
                        inner_html += '<tr><td>' + ((page - 1) * 30 + i + 1) +
                            '</td><td>' + user.login +
                            '</td><td>' + user.html_url +
                            '</td><td><img height="50px" src="' + user.avatar_url + '"/>' +
                            '</td></tr>';
                    }

                    if ((page - 1) * 30 + ret.items.length < ret.total_count) {
                        page++;
                        $('#show_more').show();
                    }
                    $('#user_list').append(inner_html);
                }
            });
        }
    </script>
</html>
