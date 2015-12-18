<html>
    <head>
        <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
        <script src="https://raw.github.com/daneden/animate.css/master/animate.css"></script>

        <script type="text/javascript">
            jQuery(document).ready(function()
            {
                jQuery("#htmlmessage").show('slow');
            });

            jQuery(window).on("load", function()
            {
                jQuery("#imagesmessage").show('slow', function()
                {
                    jQuery("#images").hide('slow');
                });
            })
        </script>
    </head>

    <body>
        <style>
            body {
                text-align: center;
                font-family: arial;
            }

            img {
                width: 140px;
                height: 79px;
                margin: 5px;
                border: dotted 2px;
            }

            h2 {
                color: red;
            }

            h4 {
                color: gray;
            }

            h1 {
                color: #005d00;
            }
        </style>

        <div id="#images">
            @foreach(range(1,$imageCount) as $number)
                <img src="http://lorempixel.com/1920/1080/?{{ $number }}">
            @endforeach
        </div>

        <div id="htmlmessage" hidden>
            <h2>HTML, Javascript e CSS carregados.</h2>

            <h4>Aguarde, carregando as imagens...</h4>
        </div>

        <div id="imagesmessage" hidden>
            <h1>Imagens 100% carregadas.</h1>
        </div>
    </body>
</html>
