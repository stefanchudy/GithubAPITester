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
            <a href="/">Back to Homepage</a>
        </div>
        <div>
            <p id="total_count">Display count: 0</p>
            <table class="table table-striped table-hover ">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Follower's name</th>
                        <th>profileURL</th>
                        <th>Avatar</th>
                    </tr>
                </thead>
                <tbody id="followers_list"></tbody>
            </table>
            <p id="loading">Loading now...Please wait a second...</p>
            <p id="show_more" style="display: none;"><a href="#" onclick="showMore();">Show more...</a></p>
        </div>
    </body>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script type="text/javascript">
        var page = 1;
        var origin_url = "/getFollowersList/{{ $username }}";
        var total = 0;

        function showMore() {
            var get_url = origin_url + '?page=' + page;
            $('#loading').show();
            $.ajax({
                url: get_url,
                success: function(res) {
                    var ret = [];
                    try {
                        eval("ret=" + res + ";");
                    } catch (e) {}
                    total += ret.length;
                    $('#total_count').html('Display count: ' + total);
                    
                    // show more
                    var inner_html = ''
                    for (var i = 0; i < ret.length; i++) {
                        inner_html += '<tr><td>' + ((page - 1) * 30 + i + 1) +
                            '</td><td>' + ret[i].login +
                            '</td><td>' + ret[i].html_url +
                            '</td><td><img height="50px" src="' + ret[i].avatar_url + '"/>' +
                            '</td></tr>';
                    }

                    if (ret.length == 30) {
                        page++;
                        $('#show_more').show();
                    } else {
                        $('#show_more').hide();
                    }
                    $('#loading').hide();
                    $('#followers_list').append(inner_html);
                }
            });
        }

        $(function() {
            showMore();
        })
    </script>
</html>
