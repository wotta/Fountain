<p align="center"><a href="https://getfountain.co" target="_blank"><img width="150"src="https://avatars0.githubusercontent.com/u/24256656?v=4&s=200"></a></p>

<p><h2 align="center">Fountain for Laravel</h2></p>

<p align="center">
<a href="https://packagist.org/packages/getfountain/basin"><img src="https://poser.pugx.org/getfountain/basin/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/getfountain/basin"><img src="https://poser.pugx.org/getfountain/basin/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/getfountain/basin"><img src="https://poser.pugx.org/getfountain/basin/license.svg" alt="License"></a>
<a href="https://styleci.io/repos/89487412"><img src="https://styleci.io/repos/89487412/shield?branch=master" alt="StyleCI"></a>
 <span class="badge-patreon"><a href="https://patreon.com/danrovito" title="Donate to this project using Patreon"><img src="https://img.shields.io/badge/patreon-donate-yellow.svg" alt="Patreon donate button" /></a></span>
</p>

## About Fountain

## Installation

Install via Composer:

`composer create-project getfountain/fountain project-name`

Your Fountain project will be installed in `project-name`.

### Configuration

1. update `.env` file with your settings, such as database credentials, hostname, etc.
2. set your web server's document root to `project-name/public/`.
3. if you're using the utf8m4 encoding, add the following to AppServiceProvider.php:
```php

public function boot()
{
    Illuminate\Support\Facades\Schema\Schema::defaultStringLength(191);
}
````
4. migrate the DB:
`php artisan migrate`
5. generate an admin user:
`php artisan fountain:make-user <email>`
Then, go to the DB and set `is_admin` to 1.

Visit your website (ex.: http://localhost) to get started.

# Contributions

We use the PSR-2 coding style.  We also use <a href="styleci.io">styleci.io</a> so don't worry too much. 

# Bug Reports

Our goal is to have active collaboration on Fountain.  We strongly encourage submitting bug reports.

When you submit a bug report please be as clear and descriptive as possible.  Include a relevant title and a description.  Your description should include a detailed explanation of the bug you are reporting.  Also, please provide steps to replicate the bug.  We also encourage including a code snippet of where the bug takes place.  Including all relevant information helps others replicate and fix the bug thats being reported.

Please remember that when submitting a bug report it may not be resolved right away.  The goal of the bug report is to begin the process for yourself and others to fix the bug being reported.

Fountain source code is managed entirely on GitHub.  Here is a list of repositories for the project.

 - [https://github.com/GetFountain/Fountain](https://github.com/GetFountain/Fountain)
 - [https://github.com/GetFountain/Basin](https://github.com/GetFountain/Basin)
 - [https://github.com/GetFountain/fountain-teams](https://github.com/GetFountain/fountain-teams)
 - [https://github.com/GetFountain/fountain-two-factor](https://github.com/GetFountain/fountain-two-factor)


## License

MIT License

Copyright (c) 2017 GetFountain

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
