## Installation

Laravel 5.0.0 or later is required.

To get the latest version of Laravel Markdown, simply require the project using Composer:

```
$ composer require tinyada/rsa
```

Or you can add following to `require` key in compser.json.

```json
"tinyada/rsa": "~1.0"
```

then run

```
$ composer update
```

Next, You should need to register the service provider. Open up `config/app.php` and add following into the `providers` key.

```php
TinyAda\RSA\RSAServiceProvider::class,
```

And you can register the RSA Facade in the `aliases` of `config/app.php` if you want.

```php
'RSA' =>  TinyAda\RSA\RSA::class,
```

## Configuration

To get started, you need to publish all vendor assets using following command.

```
$ php artisan vendor:publish
```

This will create a config file named `config/rsa.php` which you can configure RSA as you like.

## Usage

首先，你要使用RSATool2生成rsa秘钥对

Then configure the in your `.env` file because you'd better not make them public.

Add following to `.env`.

```
RSA_PRIVATE_EXP=2C3FDBF70E3F8959BE79DFBE1EF93C8891AE79EBD665C965D545CC3B30D0F04716607ADFD5550FB9D03E050BF46149DD4BB492F863F6C9A0857594E5368E7B93FE5DAD6394997773B548ED357252430BE8724B02007A64E0EEF3F78EF2618FECE452454B4511C1938C6E11B5D0438ADEDC19B4689BDF5285FA93F4DA37EDA659
RSA_PUBLIC_EXP=10001
RSA_MODULUS=97D0B8B70B3637D26E884C7185B6C42C0A7E81D03D90032860014E8547EA5B81E5FEAD35509C2BD5DD5066A1528B687CDF231F21BB36157CB44EF0E4BBC7F4ACAE75AC8BB0B0B9CBF4C678E605D0A227E80A635212967779AD31FE7CF73421A9B1A74E1290794590ABBC905D18490E54019FAE64BA9E1963B318938F6D260CE1
```

```php
#加密
$ciphertext = RSA::encrypt($plaintext);
#解密
RSA::decrypt($ciphertext);
```

## Contribution

If you find something wrong with this package, you can send an email to `mradxz@gmail.com`

Or just send a pull request to this repository. 

Pull Requests are welcome.

## Author

[Mradxz](http://www.mradxz.com) , from Beijing China

## License

Laravel RSA is licensed under [The MIT License (MIT)](https://github.com/TinyAda/RSA/blob/master/LICENSE).
