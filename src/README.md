# Migrations Schema


## Useful Commands
From inside `/src(branchname)$`, (`$ cd /src`) run the following commands:

1 - Generate the key
```
docker compose run --rm artisan key:generate
```
2 - Install dependences with composer
```
docker compose run --rm composer install
```
3 - Update composer
```
docker compose run --rm composer update
```
4 - Run npm
```
docker compose run --rm npm run dev
```
5 - Run migrations
```
docker compose run --rm artisan migrate
```
6 - To SSH into the postgres container
```
docker exec -it <postgres container ID>  /bin/bash
```
7 - Rolling Back Migrations
```
docker compose run --rm artisan migrate:rollback

docker compose run --rm artisan migrate:rollback --step=1

```
8 - Get the Laravel Framework Version
```
docker compose run --rm artisan --version
```


## References

[Rolling Back Migrations](https://laravel.com/docs/10.x/migrations#rolling-back-migrations)

[Column Modifiers](https://laravel.com/docs/10.x/migrations#column-modifiers)



## Migrations and Schemas

### 00 user

```
$table->bigIncrements('id')->autoIncrement();
$table->index(['id']);
            
$table->string('name')->nullable(false);
$table->string('middle_name')->nullable();
$table->string('last_name')->nullable();
$table->string('email')->unique();
$table->timestamp('email_verified_at')->nullable()->useCurrentOnUpdate();
$table->boolean('is_active')->nullable(false)->default(1);
$table->string('password')->nullable(false);
$table->rememberToken();

$table->timestamp('created_at')->useCurrent();
$table->timestamp('updated_at')->useCurrent();
$table->softDeletes()->nullable()->useCurrentOnUpdate();
```

### 00 create_password_reset_tokens
```
$table->string('email')->primary();
            
$table->string('token');

$table->index(['email']);
$table->timestamp('created_at')->useCurrent();
$table->timestamp('updated_at')->useCurrent();
$table->softDeletes()->nullable()->useCurrentOnUpdate();
```


### 00 failed_jobs
```
$table->bigIncrements('id')->autoIncrement();
$table->index(['id']);

$table->string('uuid')->unique();
$table->text('connection');
$table->text('queue');
$table->longText('payload');
$table->longText('exception');

$table->timestamp('created_at')->useCurrent();
$table->timestamp('updated_at')->useCurrent();
$table->softDeletes()->nullable()->useCurrentOnUpdate();
```

### 00 personal_access_tokens
```
$table->bigIncrements('id')->autoIncrement();
$table->index(['id']);

$table->morphs('tokenable');
$table->string('name');
$table->string('token', 64)->unique();
$table->text('abilities')->nullable();
$table->timestamp('last_used_at')->nullable();
$table->timestamp('expires_at')->nullable();

$table->timestamp('created_at')->useCurrent();
$table->timestamp('updated_at')->useCurrent();
$table->softDeletes()->nullable()->useCurrentOnUpdate();
```


### 1 countries
Only when using full Laravel:
```
php artisan make:migration create_countries_table  
php artisan make:model App\\\Models\\\Country  
php artisan make:controller -r CountryController 
```
 
When using Docker dbVersion-control:
```
docker compose run --rm artisan make:migration create_countries_table

$table->bigIncrements('id')->autoIncrement();
$table->index(['id']);

$table->char('name', 50)          ->nullable(false);
$table->char('iso3_code', 3)->nullable();
$table->char('iso2_code', 2)->nullable();
$table->char('geocode', 50)->nullable();
$table->decimal('lat', 10,8)->nullable();
$table->decimal('long', 11,8)->nullable();


$table->timestamp('created_at')->useCurrent();
$table->timestamp('updated_at')->useCurrent();
$table->softDeletes()->nullable()->useCurrentOnUpdate();
```

### 2 provinces
Only when using full Laravel:
```
php artisan make:migration create_provinces_table  
php artisan make:model App\\\Models\\\Province  
php artisan make:controller -r ProvinceController  
```

When using Docker dbVersion-control:
```
docker compose run --rm artisan make:migration create_provinces_table

$table->bigIncrements('id')->autoIncrement();
$table->index(['id']);

$table->bigInteger('country_id')  ->unsigned()->nullable(false);

$table->char('name', 50)          ->nullable(false);
$table->char('uf', 5)             ->nullable();
$table->char('geocode', 50)       ->nullable();
$table->decimal('lat', 10,8)      ->nullable();
$table->decimal('long', 11,8)     ->nullable();

$table->foreign('country_id')
      ->references('id')
      ->on('countries')
      ->onDelete('cascade');

$table->timestamp('created_at')->useCurrent();
$table->timestamp('updated_at')->useCurrent();
$table->softDeletes()->nullable()->useCurrentOnUpdate();
```


### 3 cities
Only when using full Laravel:
``` 
php artisan make:migration create_cities_table  
php artisan make:model App\\\Models\\\City  
php artisan make:controller -r CityController  
```

When using Docker dbVersion-control:
```
docker compose run --rm artisan make:migration create_cities_table

$table->bigIncrements('id')->autoIncrement();
$table->index(['id']);

$table->bigInteger('province_id')  ->unsigned()->nullable(false);

$table->char('name', 50)          ->nullable(false);
$table->char('geocode', 50)       ->nullable();
$table->decimal('lat', 10,8)      ->nullable();
$table->decimal('long', 11,8)     ->nullable();

$table->foreign('province_id')
    ->references('id')
    ->on('provinces')
    ->onDelete('cascade');

$table->timestamp('created_at')->useCurrent();
$table->timestamp('updated_at')->useCurrent();
$table->softDeletes()->nullable()->useCurrentOnUpdate();
```


### 4 address_types
Only when using full Laravel:
```
php artisan make:migration create_address_types_table  
php artisan make:model App\\\Models\\\AddressType  
php artisan make:controller -r AddressTypeController  
```

When using Docker dbVersion-control:
```
docker compose run --rm artisan make:migration create_address_types_table

$table->bigIncrements('id')->autoIncrement();
$table->index(['id']);

$table->char('name', 50)      ->nullable(false);
$table->text('description')   ->nullable();

$table->timestamp('created_at')->useCurrent();
$table->timestamp('updated_at')->useCurrent();
$table->softDeletes()->nullable()->useCurrentOnUpdate();
```

### 5 addresses
Only when using full Laravel:
```
php artisan make:migration create_addresses_table  
php artisan make:model App\\\Models\\\Address  
php artisan make:controller -r AddressController  
```
When using Docker dbVersion-control:
```
docker compose run --rm artisan make:migration create_addresses_table 

$table->bigIncrements('id')->autoIncrement();
$table->index(['id']);

$table->bigInteger('city_id')           ->unsigned()->nullable(false);
$table->bigInteger('address_type_id')   ->unsigned()->nullable(false);

$table->char('nb_civic', 50)      ->nullable();
$table->char('nb_room', 50)       ->nullable();
$table->char('nb_office', 50)     ->nullable();
$table->char('name', 50)          ->nullable();
$table->char('street', 100)       ->nullable();
$table->char('zip', 20)           ->nullable();
$table->char('complement', 200)   ->nullable();
$table->text('description')             ->nullable();
$table->decimal('lat', 10,8) ->nullable();
$table->decimal('long', 11,8)->nullable();

$table->foreign('city_id')
    ->references('id')
    ->on('cities')
    ->onDelete('cascade');

$table->foreign('address_type_id')
    ->references('id')
    ->on('address_types')
    ->onDelete('cascade');

$table->timestamp('created_at')->useCurrent();
$table->timestamp('updated_at')->useCurrent();
$table->softDeletes()->nullable()->useCurrentOnUpdate();
```

### 6 
Only when using full Laravel:
```
php artisan make:migration create_phones_table  
php artisan make:model App\\\Models\\\Phone  
php artisan make:controller -r PhoneController  
```

When using Docker dbVersion-control:
```
docker compose run --rm artisan make:migration create_phones_table

$table->bigIncrements('id')->autoIncrement();
$table->index(['id']);

$table->bigInteger('address_id')->unsigned()->nullable(false);

$table->char('number', 20)          ->nullable(false);
$table->text('note')                      ->nullable();

$table->foreign('address_id')
    ->references('id')
    ->on('addresses')
    ->onDelete('cascade');

$table->timestamp('created_at')->useCurrent();
$table->timestamp('updated_at')->useCurrent();
$table->softDeletes()->nullable()->useCurrentOnUpdate();
```

### 7
Only when using full Laravel:
```
php artisan make:migration create_faxes_table
php artisan make:model App\\Models\\Fax
php artisan make:controller -r FaxController
```

When using Docker dbVersion-control:
```
docker compose run --rm artisan make:migration create_faxes_table

$table->bigIncrements('id')->autoIncrement();
$table->index(['id']);

$table->bigInteger('address_id')->unsigned()->nullable(false);

$table->char('number', 20)->nullable(false);
$table->text('note')->nullable();

$table->foreign('address_id')
    ->references('id')
    ->on('addresses')
    ->onDelete('cascade');

$table->timestamp('created_at')->useCurrent();
$table->timestamp('updated_at')->useCurrent();
$table->softDeletes()->nullable()->useCurrentOnUpdate();
```


### 8 
Only when using full Laravel:
```
php artisan make:migration create_cell_phones_table  
php artisan make:model App\\\Models\\\CellPhone  
php artisan make:controller -r CellPhoneController  
```

When using Docker dbVersion-control:
```
docker compose run --rm artisan make:migration create_cell_phones_table

$table->bigIncrements('id')->autoIncrement();
$table->index(['id']);

$table->bigInteger('address_id')->unsigned()->nullable(false);

$table->char('number', 20)                ->nullable(false);
$table->text('note')                      ->nullable();

$table->foreign('address_id')
    ->references('id')
    ->on('addresses')
    ->onDelete('cascade');

$table->timestamp('created_at')->useCurrent();
$table->timestamp('updated_at')->useCurrent();
$table->softDeletes()->nullable()->useCurrentOnUpdate();
```

### 9 
- https://en.wikipedia.org/wiki/Language_localisation
- https://en.wikipedia.org/wiki/List_of_ISO_639-1_codes
- https://www.andiamo.co.uk/resources/iso-language-codes/

Only when using full Laravel:
```
php artisan make:migration create_languages_table  
php artisan make:model App\\\Models\\\Language  
php artisan make:controller -r LanguageController  
```

When using Docker dbVersion-control:
```
docker compose run --rm artisan make:migration create_languages_table

$table->bigIncrements('id')->autoIncrement();
$table->index(['id']);

$table->bigInteger('country_id')       ->unsigned()->nullable(false);

$table->char('family', 200)     ->nullable(false);
$table->char('iso_name', 200)   ->nullable(false);
$table->char('native_name', 200)->nullable(false);
$table->char('iso_639_1', 10)   ->nullable();
$table->char('iso_639_2T', 10)  ->nullable();
$table->char('iso_639_2B', 10)  ->nullable();
$table->char('iso_639_3', 10)   ->nullable();
$table->char('tag', 10)         ->nullable();
$table->text('note')                  ->nullable();

$table->foreign('country_id')
    ->references('id')
    ->on('countries')
    ->onDelete('cascade');

$table->timestamp('created_at')->useCurrent();
$table->timestamp('updated_at')->useCurrent();
$table->softDeletes()->nullable()->useCurrentOnUpdate();
```

### 10 
Only when using full Laravel:
```
php artisan make:migration create_user_types_table  
php artisan make:model App\\\Models\\\UserType  
php artisan make:controller -r UserTypeController  
```

When using Docker dbVersion-control:
```
docker compose run --rm artisan make:migration create_user_types_table

$table->bigIncrements('id')->autoIncrement();
$table->index(['id']);

$table->bigInteger('language_id') ->unsigned()->nullable(false);

$table->char('type', 50)->nullable(false);
$table->text('note')               ->nullable();

$table->foreign('language_id')
    ->references('id')
    ->on('languages')
    ->onDelete('cascade');

$table->timestamp('created_at')->useCurrent();
$table->timestamp('updated_at')->useCurrent();
$table->softDeletes()->nullable()->useCurrentOnUpdate();
```

### 11 
Only when using full Laravel:
```
php artisan make:migration create_user_groups_table  
php artisan make:model App\\\Models\\\UserGroup  
php artisan make:controller -r UserGroupController  
```

When using Docker dbVersion-control:
```
docker compose run --rm artisan make:migration create_user_groups_table

$table->bigIncrements('id')->autoIncrement();
$table->index(['id']);

$table->bigInteger('language_id') ->unsigned()->nullable(false);

$table->char('group', 50)   ->nullable(false);
$table->text('note')              ->nullable();

$table->foreign('language_id')
    ->references('id')
    ->on('languages')
    ->onDelete('cascade');

$table->timestamp('created_at')->useCurrent();
$table->timestamp('updated_at')->useCurrent();
$table->softDeletes()->nullable()->useCurrentOnUpdate();
```

### 12 - Pivot table - Only Migration
Only when using full Laravel:
```
php artisan make:migration create_address_user_table  
```

When using Docker dbVersion-control:
```
docker compose run --rm artisan make:migration create_address_user_table

$table->bigInteger('user_id')                ->unsigned()->nullable(false);
$table->bigInteger('address_id')   ->unsigned()->nullable(false);
            

$table->foreign('user_id')
    ->references('id')
    ->on('users')
    ->onDelete('cascade');
    
    
$table->foreign('address_id', 'fk_adrrs_usr')
    ->references('id')
    ->on('addresses')
    ->onDelete('cascade');    
    
$table->primary(['user_id', 'address_id']);

$table->timestamp('created_at')->useCurrent();
$table->timestamp('updated_at')->useCurrent();
$table->softDeletes()->nullable()->useCurrentOnUpdate();
```



### 13 - Pivot table - Only Migration
Only when using full Laravel:
```
php artisan make:migration create_country_user_table    
php artisan make:model App\\\Models\\\CountryUser  
php artisan make:controller -r CountryUserController  
```

When using Docker dbVersion-control:
```
docker compose run --rm artisan make:migration create_country_user_table

$table->bigInteger('user_id')->unsigned()->nullable(false);
$table->bigInteger('country_id')->unsigned()->nullable(false);
            

$table->foreign('user_id')
    ->references('id')
    ->on('users')
    ->onDelete('cascade');
    
    
$table->foreign('country_id', 'fk_country_usr')
    ->references('id')
    ->on('countries')
    ->onDelete('cascade');    
    
$table->primary(['user_id', 'country_id']);

$table->timestamp('created_at')->useCurrent();
$table->timestamp('updated_at')->useCurrent();
$table->softDeletes()->nullable()->useCurrentOnUpdate();
```

### 14 - Pivot table - Only Migration
Only when using full Laravel:
```
php artisan make:migration create_language_user_table  
php artisan make:model App\\\Models\\\LanguageUser  
php artisan make:controller -r LanguageUserController      
```

When using Docker dbVersion-control:
```
docker compose run --rm artisan make:migration create_language_user_table

$table->bigInteger('user_id')->unsigned()->nullable(false);
$table->bigInteger('language_id')->unsigned()->nullable(false);


$table->foreign('user_id')
    ->references('id')
    ->on('users')
    ->onDelete('cascade');

$table->foreign('language_id')
    ->references('id')
    ->on('languages')
    ->onDelete('cascade');
    
$table->primary(['user_id', 'language_id']);

$table->timestamp('created_at')->useCurrent();
$table->timestamp('updated_at')->useCurrent();
$table->softDeletes()->nullable()->useCurrentOnUpdate();
```

### 15 - Pivot table - Only Migration
Only when using full Laravel:
```
php artisan make:migration create_user_group_user_table  
```

When using Docker dbVersion-control:
```
docker compose run --rm artisan make:migration create_user_group_user_table

$table->bigInteger('user_id')->unsigned()->nullable(false);
$table->bigInteger('user_group_id')->unsigned()->nullable(false);


$table->foreign('user_id')
    ->references('id')
    ->on('users')
    ->onDelete('cascade');

$table->foreign('user_group_id','usr_grp_usr')
    ->references('id')
    ->on('user_groups')
    ->onDelete('cascade');
    
$table->primary(['user_id', 'user_group_id']);

$table->timestamp('created_at')->useCurrent();
$table->timestamp('updated_at')->useCurrent();
$table->softDeletes()->nullable()->useCurrentOnUpdate();
```

### 16 - Pivot table - Only Migration
Only when using full Laravel:
```
php artisan make:migration create_user_type_user_table  
php artisan make:model App\\\Models\\\UserTypeUser  
php artisan make:controller -r UserTypeUserController  
```

When using Docker dbVersion-control:
```
docker compose run --rm artisan make:migration create_user_type_user_table

$table->bigInteger('user_id')->unsigned()->nullable(false);
$table->bigInteger('user_type_id')->unsigned()->nullable(false);


$table->foreign('user_id')
    ->references('id')
    ->on('users')
    ->onDelete('cascade');

$table->foreign('user_type_id','usr_type_usr')
    ->references('id')
    ->on('user_types')
    ->onDelete('cascade');
    
$table->primary(['user_id', 'user_type_id']);

$table->timestamp('created_at')->useCurrent();
$table->timestamp('updated_at')->useCurrent();
$table->softDeletes()->nullable()->useCurrentOnUpdate();
```









