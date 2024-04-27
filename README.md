# laravel-jwt-auth

1.Clone The git repository<br>
2.Rename The .env file. Run this <pre>cp .env.example .env</pre><br>
3.create a database and set the database details in the .env file.<br>
4.Run <pre>composer update</pre>
5.Run <pre>php artisan key:generate</pre>
6.Run <pre>php artisan jwt:secret</pre>
7.Run <pre>php artisan migrate</pre>
8.Run <pre>php artisan db:seed</pre>
9.Run <pre>php artisan serve</pre>
10.Set Mail Details <pre>php artisan serve</pre>
11.For Email Please Set Your Mail config in the .env<pre>
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=148f6c14bdeccc
MAIL_PASSWORD=4cb302993caf91
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"</pre>
12.For running the schedule for the command ($schedule->command('reminder:send')->dailyAt('00:00');) <pre>php artisan schedule:run</pre>
13.Or you can simply run the command for sending Reminder  Email <pre>php artisan reminder:send</pre>
14.Import the postman collection attached
5You can see the postman doc. :https://documenter.getpostman.com/view/6464397/2sA3BuUo5T



