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


This library was created only for the purpose of familiarizing and facilitating the work of programmers in this field, and all its intellectual and material rights belong to Zarin Pal!


### Config.php

``` PHP
$usernamedb = "-----_---"; // username Database
$passworddb = "---------"; // password Database
$dbname = "-----_---"; //Database Name
$Merchent_ID = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx'; //Merchent_ID 36 character
$callback = 'https://example.com/VerifyPayment.php'; //Callback address
$sandbox = false; //sandbox
```

### data.sql

``` SQL
CREATE TABLE `Transaction` (
  `PayID` int(11) NOT NULL,
  `username` text NOT NULL,
  `Authority` text NOT NULL,
  `Amount` text NOT NULL,
  `Status` text NOT NULL,
  `Message` text NOT NULL,
  `ref_id` text NOT NULL,
  `Date` text NOT NULL,
  `DatePayed` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


--
-- Indexes for table `Transaction`
--
ALTER TABLE `Transaction`
  ADD PRIMARY KEY (`PayID`);

--
-- AUTO_INCREMENT for table `Transaction`
--
ALTER TABLE `Transaction`
  MODIFY `PayID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;
```


### CreatePayment.php

``` PHP
$username = '-----'; // input username
$amount = '-----'; // input money
```
To create a portal, you only need to enter your user's username and the amount of the payment gateway in IRT


### Codes

| Code | Message |
| ---- | ------------- |
| 100 |     The operation was successful    |
| 101 |     The transaction has already been confirmed     |
| 39 |     Problem creating payment gateway    |
| 52 |      Non-payment or cancellation of payment   |
| 55 |     There is no transaction in the system    |
| 40 |     System error    |
| 500 |     DB error    |

### Resources

- Check out the docs at https://www.zarinpal.com/docs/
away and discover more in-depth material for building your client applications.
- Join the official channel at https://rubika.ir/clientapi and stay tuned for news, updates and announcements.
