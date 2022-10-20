<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Righteous');

        body {
            background-color: #000;
            color: red;
            padding: 10% 0;
        }

        .Wrapper {
            width: 540px;
            height: 200px;
            display: none;
            margin: 4% auto 0;
            max-width: 100%;
            max-height: 100%;
            position: relative;
            overflow: hidden;
        }

        #five {
            z-index: 10;
            position: absolute;
        }

        .left {
            z-index: 1;
            width: 550px;
            height: 200px;
            position: absolute;
            overflow: hidden;
        }

        .right {
            z-index: 1;
            width: 550px;
            height: 200px;
            position: absolute;
            overflow: hidden;
            left: 80%;
        }


        h1 {
            color: #000;
            background: red;
            padding: 10px;
            border-radius: 50px;
            width: 150px;
            margin: 30px auto 10px;
            text-align: center;
            font-size: 1em;
            font-family: 'Righteous', sans-serif;
            display: none;
        }

        p {
            width: 350px;
            margin: 0px auto;
            text-align: center;
            font-family: 'Righteous', sans-serif;
            display: none;
        }
    </style>
</head>

<body>
    <div class="Wrapper">
        <div class="left">Error</div>
        <div class="right">Error</div><canvas id="five" width="550" height="205"></canvas>
    </div>
    <h1>Error :(</h1>
    <p>It's always time for a coffee break. </p>
    <p>We should be back by the time you finish your coffee.</p>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script>
        // experiments http://bit.ly/2QCjk6a

        WebFontConfig = {
            google: {
                families: ['Righteous']
            },
            active: function() {
                FiveOhFiveFont();
            },
        };
        (function() {
            var wf = document.createElement("script");
            wf.src = 'https://ajax.googleapis.com/ajax/libs/webfont/1.5.10/webfont.js';
            wf.async = 'true';
            document.head.appendChild(wf);
        })();


        var FiveOhFive = document.getElementById("five");
        var FiveOhFiveContext = FiveOhFive.getContext("2d");
        FiveOhFiveFont(FiveOhFiveContext, FiveOhFive);
        FiveOhFiveContext.globalCompositeOperation = 'destination-out';

        function FiveOhFiveFont(ctx, canvas) {
            FiveOhFiveContext.fillText("500", 275, 100);
            var grad = ctx.createLinearGradient(0, 0, canvas.width, canvas.height);
            grad.addColorStop(0, '#000');
            ctx.rect(0, 0, canvas.width, canvas.height);
            ctx.fillStyle = grad;
            ctx.fill();
            ctx.fillStyle = "red";
            ctx.font = "15em Righteous";
            ctx.textAlign = "center";
            ctx.textBaseline = "middle";
        }


        var WrapperW = $('.Wrapper').width();
        var WrapperH = $('.Wrapper').height();

        $('.left').click(function() {
            for (var j = 1; j <= 500; j++) {
                var X = (Math.random() * WrapperW) % (WrapperW >> 0);
                var Y = (Math.random() * WrapperH) % (WrapperH >> 0);
                var nTop = Math.floor((Math.random() * WrapperW));
                var nLeft = Math.floor(((Math.random() * WrapperH)));
                var $child = $(this).clone();

                $('.Wrapper').append($child);
                $child.css({
                        top: X,
                        left: -200 + Y
                    })
                    .animate({
                        top: nTop + 'px',
                        left: 50 + nLeft + 'px'
                    }, 8000)
            }
        });

        $('.right').click(function() {
            for (var j = 1; j <= 500; j++) {
                var X = (Math.random() * WrapperW) % (WrapperW >> 0);
                var Y = (Math.random() * WrapperH) % (WrapperH >> 0);
                var nTop = Math.floor((Math.random() * WrapperW));
                var nLeft = Math.floor(((Math.random() * WrapperH)));
                var $child = $(this).clone();

                $('.Wrapper').append($child);
                $child.css({
                        top: X,
                        left: 500 + Y
                    })
                    .animate({
                        top: nTop + 'px',
                        left: 270 + nLeft + 'px'
                    }, 8000)
            }
        });


        $("document").ready(function() {
            $(".Wrapper,h1,p").fadeIn(100);
            setTimeout(function() {
                $(".right, .left").trigger('click');
            }, 0);
        });
    </script>
</body>

</html>
