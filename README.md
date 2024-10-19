

## Backend repository 
Here's the [Repository](https://github.com/ahmed-ibrahim1998/scandiweb-assignment-).

## Deployment
My app is deployed at [infinity free](https://prodify.lovestoblog.com).


## Get example
```php
DB::table('products')->where('id', '>', '0')->get();
```
## First example
```php
DB::table('products')->where('id', '>', '0')->first();
```
## Create exampel
```php
 $x = DB::table('products')->create([
    'title'=>'hello title',
     'content'=>'hello content',
 ]);
```
## Delete example
 ```php
 $x = DB::table('products')->delete('id', [20,21]);
 ```
