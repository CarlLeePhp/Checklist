# Check List Project

## Installation

+ Apache2, mySQL, Php
+ Package 'Postfix'

#### hard code
Review.php -> get_pictures()
-> $path = '/var/www/html/dealers/'.$dealer_name.'/'.$serial.'/';

## Code Igniter Configuration

#### application/config
**config.php**
$config['base_url']

+ 'http://localhost' for development,
+ 'http://ipaddress' or 'http://domain' for production.


**database.php**
Database information should be here.

#### html
The dealer folder should be checked. Its permission should be 777. So, subfolders can be created freely.

## Gitee Feature

1. You can use Readme\_XXX.md to support different languages, such as Readme\_en.md, Readme\_zh.md
2. Gitee blog [blog.gitee.com](https://blog.gitee.com)
3. Explore open source project [https://gitee.com/explore](https://gitee.com/explore)
4. The most valuable open source project [GVP](https://gitee.com/gvp)
5. The manual of Gitee [https://gitee.com/help](https://gitee.com/help)
6. The most popular members  [https://gitee.com/gitee-stars/](https://gitee.com/gitee-stars/)
