## Backend Assignment

## Task
You were given a sample [Laravel][laravel] project which implements sort of a personal wishlist
where user can add their wanted products with some basic information (price, link etc.) and
view the list.

#### Refactoring
The `ItemController` is messy. Please use your best judgement to improve the code. Your task
is to identify the imperfect areas and improve them whilst keeping the backwards compatibility.

#### New feature
Please modify the project to add statistics for the wishlist items. Statistics should include:

- total items count
- average price of an item
- the website with the highest total price of its items
- total price of items added this month

The statistics should be exposed using an API endpoint. **Moreover**, user should be able to
display the statistics using a CLI command.

Please also include a way for the command to display a single information from the statistics,
for example just the average price. You can add a command parameter/option to specify which
statistic should be displayed.

## Open questions
Please write your answers to following questions.

> **Please briefly explain your implementation of the new feature**  
>  
> 1- Creating an controller name `StatisticsController` has method `items`
> 2- Add a api endpoint to api.php file connected with this request using GET request this request can pass single parameter `type` type can only on this list ['count', 'avg', 'website_max_price', 'price_in_current_month'] default type is "*" means retrieving all stats.
> 3- In Item Model implement a new method `statistics(string $type = "*")`, Iam implement the stats functionality in the model because i will need it gain in the StatisticsCommand CLI.
> 4- Testing the function in the browser direct call
> 5- Implement a new Case Test for this function
> 6- Implement a new Command name StatisticsCommand in this command we can retrieving the stats for all modules 
 in the application, so I pass to this command two argument's first one is required this should is module name like ['items', 'users', ...etc] 
 and the second one is any **optional** data. 
 to test the stats CLI please following this syntax `php artisan stats:get items count` the second argument option and|or is one of this list ['count', 'avg', 'website_max_price', 'price_in_current_month'] default as I mentioned before is "*".

> **For the refactoring, would you change something else if you had more time?**  
>  
> N

## Running the project
This project requires a database to run. For the server part, you can use `php artisan serve`
or whatever you're most comfortable with.

You can use the attached DB seeder to get data to work with.

#### Running tests
The attached test suite can be run using `php artisan test` command.

[laravel]: https://laravel.com/docs/8.x
