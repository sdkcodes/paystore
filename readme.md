<p align="center">PAYSTORE</p>


## About Paystore

Paystore is a simplistic store management app to help a store owner pay ther suppliers with ease using paystack. With Paystore, store owners no longer have to deal with the problem of failed payments or double transfers.

## Installing the app

Clone this repo to your server or download as zip, then unzip in your server directory

Run `composer install` from the project root directory

Run `cp .env.example .env` to generate your .env file

Fill the generated .env file with your database details and with your paystack keys as well

Run `php artisan key:generate` to generate your app key

Then run `php artisan migrate` to set up your database tables

You can as well run `php artisan db:seed --class=UsersTableSeeder` to generate the admin account

You can also run the command `php artisan naijabanks:create` to get and store all the supported banks by paystack

Finally, enter your `[yourdomainurl]` in your browser to see the app



## License

The app is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
