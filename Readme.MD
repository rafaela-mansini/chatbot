# Chatbot

Chatbot is a project who can save currency transactions.

## Stack
  - PHP
  - Laravel
  - Mysql
  - React.js
  - Composer
  - Docker

## Features
 - Register your account;
 - Login into your account;
 - Make a deposit;
 - Make a withdraw;
 - See your balance;
 - Set your default currency;
 - Set for your transaction the currency;

## Requirements
To run this project, do you need to have installed:<br/>
[Docker 20.10](https://docs.docker.com/engine/install/ubuntu/);<br/>
[Docker Compose 1.29](https://docs.docker.com/compose/install/);<br/>
[Node 10.19](https://nodejs.org/en/download/package-manager/);<br/>

## Installation
#### If you use linux / ubuntu, can you follow the steps below to install the requirement, if use another one or something is wrong, please follow the links and install before continue.

<i>Docker: (https://docs.docker.com/engine/install/ubuntu/)</i>
~~~bash
Docker: (https://docs.docker.com/engine/install/ubuntu/)
sudo apt-get remove docker docker-engine docker.io containerd runc
sudo apt-get update
sudo apt-get install \
    apt-transport-https \
    ca-certificates \
    curl \
    gnupg \
    lsb-release
curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo gpg --dearmor -o /usr/share/keyrings/docker-archive-keyring.gpg
echo \
  "deb [arch=amd64 signed-by=/usr/share/keyrings/docker-archive-keyring.gpg] https://download.docker.com/linux/ubuntu \
  $(lsb_release -cs) stable" | sudo tee /etc/apt/sources.list.d/docker.list > /dev/null
  
  // install docker engine
  sudo apt-get update
  sudo apt-get install docker-ce docker-ce-cli containerd.io
  
  // manage docker without root user
  sudo groupadd docker
  sudo usermod -aG docker $USER
  newgrp docker 
~~~

<i>Docker compose (https://docs.docker.com/compose/install/)</i>
~~~bash
sudo curl -L "https://github.com/docker/compose/releases/download/1.29.2/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
sudo chmod +x /usr/local/bin/docker-compose
~~~

<i>Npm (https://nodejs.org/en/download/package-manager/)</i>
~~~bash
sudo apt update
sudo apt install nodejs
npm -v
~~~

With all this installed, now you can clone this project: `https://github.com/rafaela-mansini/chatbot.git`

After clonning your project, entry in your server folder with the command:
`cd chatbot` and `cd server`
Inside your server folder, run the command `cp .env.example .env` to copy the .env in your folder, and open the file .env in your editor and set your database information who will use in docker file:

```
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=chatbot
DB_USERNAME=chatbot_user
DB_PASSWORD=password
```
**NOTE**
You can change the database, username and password, but not the host, because he will be used into docker file.

Now you can run `docker-compose build app` to build the project into docker. When the command finished, run `docker-compose up -d` to up your application.

To install the Laravel dependences and your database configuration, please run:

~~~composer
docker exec -it chatbot-app bash
composer install
php artisan key:generate
php artisan passport:install
php artisan migrate
php artisan db:seed
~~~
And now your backend server is running with all configurations!

Now to run the frontend application, back one folder with `cd ..` and open in your terminal the `cd client`, the folder frontend.
Run into your terminal:

`npm install`
and when is finished, to run your application `npm start`

And now, your application it's running!




