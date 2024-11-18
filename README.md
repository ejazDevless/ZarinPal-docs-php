<p align="center">
    <a href="https://github.com/ejazDevless/ZarinPal-docs-php/">
        <img src="https://raw.githubusercontent.com/ejazDevless/ZarinPal-docs-php/refs/heads/main/assets/logo.png" alt="ZarinPal" width="128">
    </a>
    <br>
    <b>ZarinPal docs api with php</b>
    <br>
</p>

## ZarinPal

> easy, fast and elegant library for making payments

``` PHP
from rubika import Bot, Socket
from rubika.filters import filters

bot = Bot("MyApp")
app = Socket(bot.auth)

@app.handler(filters.PV)
def hello(message):
    message.reply("Hello from Rubikalib!")
```


### Config.php

``` PHP
$usernamedb = "-----_---"; // username Database
$passworddb = "---------"; // password Database
$dbname = "-----_---"; //Database Name
$Merchent_ID = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx'; //Merchent_ID 36 character
$callback = 'https://example.com/VerifyPayment.php'; //Callback address
$sandbox = false; //sandbox
```

### CreatePayment.php

``` PHP
$username = '-----'; // input username
$amount = '-----'; // input money
```

### Resources

- Check out the docs at https://www.zarinpal.com/docs/
away and discover more in-depth material for building your client applications.
- Join the official channel at https://rubika.ir/clientapi and stay tuned for news, updates and announcements.
