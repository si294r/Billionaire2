
Please refer to [Documentation](https://github.com/si294r/Documentation/blob/master/setup_apache_php_with_mongodb_extension.md) file

#### Example Create User Admin in mongo shell
```
> db.admin.insert({username: 'admin', password: hex_md5('password'), status: 'active'})
```