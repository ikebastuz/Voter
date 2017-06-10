## Voting application

<p align="center"><img src="http://ikebastuz.info/img/voter.png"></p>

This app allows you to create, delete, modify, activate\deactivate your personal votes. And, of course, you can vote and watch vote stats.

Test app you can here:
- [Vote App Test Page](http://ikebastuz.info/laravel/Voter/public/).

## Installation

At first you have to clone this app to your host

```bash
git clone https://github.com/ikebastuz/Voter
```

This repository doesn't have Laravel vendor folder, so you have copy it from any another project if it's not re-configurated.

After this make sure you set your .env file, especially database settings.
Also, if you want to Password Reset Function to work - set up your smtp settings.

Last thing you have to do - run database migrations.
Proceed to your app folder and run:

```bash
php artisan migrate
```

Thats it, app should work now!