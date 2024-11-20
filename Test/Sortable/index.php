<!DOCTYPE html>
<html>
<head>
    <title>Verschachtelte sortierbare Elemente mit Fomantic UI</title>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.8.8/semantic.min.css">
    <style>
        body {
            padding: 20px;
        }

        .sortable {
            list-style-type: none;
            margin: 0;
            padding: 0;
            width: 200px;
        }

        .sortable li {
            margin: 0 0 3px;
            padding: 0.4em;
            padding-left: 1.5em;
            font-size: 1.4em;
        }

        .sortable li span {
            position: absolute;
            margin-left: -1.3em;
        }

        .nested-sortable {
            padding-left: 20px;
            border: 1px solid #ccc;
        }

        .ui-state-highlight {
            background-color: #ffeaa7 !important;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.8.8/semantic.min.js"></script>
    <script>
        $(document).ready(function () {
            $(".sortable").sortable({
                connectWith: ".sortable, .nested-sortable",
                placeholder: "ui-state-highlight",
                update: function (event, ui) {
                    var parentList = ui.item.parent().closest("li");
                    if (parentList.hasClass("nested-sortable")) {
                        parentList.addClass("ui-state-highlight");
                    }
                }
            });
            $(".sortable").disableSelection();
        });
    </script>
</head>
<body>
    <div class="ui container">
        <ul class="sortable">
            <li><span class="ui icon"></span>Element 1
                <ul class="nested-sortable">
                    <li><span class="ui icon"></span>Unterelement 1</li>
                    <li><span class="ui icon"></span>Unterelement 2</li>
                    <li><span class="ui icon"></span>Unterelement 3</li>
                </ul>
            </li>
            <li><span class="ui icon"></span>Element 2</li>
            <li><span class="ui icon"></span>Element 3</li>
            <li><span class="ui icon"></span>Element 4</li>
            <li><span class="ui icon"></span>Element 5</li>
        </ul>
    </div>
</body>
</html>
