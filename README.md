# Amazon Transparency Labels

<ul> 
<li>This is for Generate Amazon Transparency Labels using it's apis.</li>
<li>Ensure that you have used PHP version 8.4 and Node version 22.*.*.</li>
</ul>

# How to setup base project ?

``` bash
git clone https://github.com/reCommerceBrands/transparency-labels.git
cd foldername
```


Install Composer
```bash
composer install
npm install
```

Change .env.example into .env file and add database related changes

```bash
php artisan key:generate
php artisan migrate:fresh --seed // add default tables
```

In .env file make sure you've defined APP_URL like:

```bash
APP_URL=http://{domain_name}/{folder_name if exists}/public // This is for when you have not used the `php artisan serve` command to run the project.
```

If you want to make changes to the project and see the results immediately, perform the following command:

```bash
npm run dev
```

If you do not want to make any changes to the project, run the following command.

```bash
npm run build
```

Below are steps to the Generate Dynamic Form with validation using JSON Schema.

```bash
1. Ensure that you have configured account settings such as client ID and client secret and brand name.
```
