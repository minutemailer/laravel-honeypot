# Credits for Laravel

Honeypot is a simple credit system for Laravel. With Honeypot, users can have credit buckets where credits can be deposited to or withdrawn from. It's perfect for creating simple virtual currency systems or implementing reward programs.

With Honeypot, you can easily manage credits for your users and keep track of all transactions. Whether you're building an e-commerce platform or a social network, Honeypot makes it easy to add a credit system to your Laravel application.

## Installation

You can install the package via composer:

```bash
composer require minutemailer/laravel-honeypot
```

The `HoneypotServiceProvider` will be auto-discovered and registered by Laravel.

Next, create and run the database migration:

```bash
php artisan honeypot:migration:make
php artisan migrate
```

Finally add the `CanHaveCredits` trait to your `User` model:

```php
use Minutemailer\Honeypot\Traits\CanHaveCredits;

class User extends Authenticatable
{
    use CanHaveCredits;
}
```

## Usage

In Honeypot, credit buckets must have a name, but you can also choose to set an expiration date for each bucket. If no expiration date is set, the bucket will remain active indefinitely. Additionally, you have the option to set a validity date for each bucket.

### Creating a bucket

To create a bucket, use the `addCreditBucket` method on the `User` model:

```php
$user->addCreditBucket('credits', [
    'expires_at' => now()->addYear(), // Optional, defaults to null
    'valid_from' => now()->subYear(), // Optional, defaults to null
    'amount' => 1000 // Optional, defaults to 0
]);
```

The name is unique for each user, so you can't create two buckets with the same name for the same user.

### Depositing credits

To deposit credits to a bucket, you need to select the bucket by name and then call the `add` method on the bucket:

```php
$user->getCreditBucket('credits')->add(100);
```

### Using credits

Same as depositing, but use the `use` method instead:

```php
$user->getCreditBucket('credits')->use(100);
```

Using credits will increment the `used` column on the bucket and keep the `amount` column intact.

### Default bucket

Depending on your application, you might want to utilize the default bucket. You might only have one type of credits but multiple types of buckets. Say for example **earned credits** and **bought credits**.
The default bucket is the bucket with the shortest expiration date. This helps the user to use the credits that are about to expire first.

Therefor, you could use this logic to dynamically withdraw credits from the user:

```php
$creditsToWithdraw = 100;

while ($creditsToWithdraw > 0) {
    $bucket = $user->getDefaultCreditBucket();

    if ($bucket->amount > $creditsToWithdraw) {
        $bucket->use($creditsToWithdraw);
        $creditsToWithdraw = 0;
    } else {
        $creditsToWithdraw -= $bucket->amount;
        $bucket->use($bucket->amount);
    }
}
```