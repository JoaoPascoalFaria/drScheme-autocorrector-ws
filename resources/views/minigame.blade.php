
<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Programming Minigame</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->

        <link href="../css/minigame.css" rel="stylesheet" type="text/css">

    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <form id="minigame">
                    <h3>Colorlib Contact Form</h3>
                    <h4>Contact us for custom quote</h4>
                    <fieldset>
                        <input placeholder="Your name" type="text" tabindex="1" required autofocus>
                    </fieldset>
                    <fieldset>
                        <input placeholder="Your Email Address" type="email" tabindex="2" required>
                    </fieldset>
                    <fieldset>
                        <input placeholder="Your Phone Number (optional)" type="tel" tabindex="3" required>
                    </fieldset>
                    <fieldset>
                        <input placeholder="Your Web Site (optional)" type="url" tabindex="4" required>
                    </fieldset>
                    <fieldset>
                        <textarea placeholder="Type your message here...." tabindex="5" required></textarea>
                    </fieldset>
                    <fieldset>
                        <button name="submit" type="submit" id="contact-submit" data-submit="...Sending">Submit</button>
                    </fieldset>
                    <p class="copyright">Designed by <a href="https://colorlib.com" target="_blank" title="Colorlib">Colorlib</a></p>
                </form>
            </div>
        </div>
    </body>
    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../../js/minigame_loader.js"></script>
</html>

