# Documentation

### 1.setting up a factory
    Here after creating the models for thread and reply and their stuff, we can go to UserFactory file in /database/factory and setup our factory for thread there.
    
    As it is in the file for **body** and **title** just a faker instance is ok, but for a **user_id** we need to create a user instance and use its **id** (this is the easiest way)


    ```PHP
        $factory->define(Thread::class, function(Faker $faker){
            return [
                'user_id' => function(){
                    return factory('App\User')->create()->id;
                },
                'title' => $faker->sentence,
                'body' => $faker->paragraph
            ];
        });
    ```

    and in order to use this factories, look at Readme file, **Seeding Database** section.


### 2.What is that path() method in models?
    because some urls are complicated and are hard to setup in views, we will setup a path() method on Thread or Reply models. this will make the code clean  and now anywhere in this project if we have a thread or reply and we want to link to it , we just call the path() method of it and it will return usa proper URI.

    the structure of it just returns a string of desired URI.

    On Thread Model :
    ```PHP 
        public function path()
        {
            return '/threads/' . $this->id ;
        }
    ```

    for example on threads/index.blade.php , for linking the title of thread to its show method on controller , instead of using 
    src="/threads/{{ $thread->id }}, we will use the path method and path()
    will return the code abodve.

    this is useful when in near future wew switch from using **id** to **slug**, we can simply change the **id** in path() method to **slug**.
    

### 3.why in reply and thread model we specified the user_id on relationships (owner,creator)?
    Because we used the **owner** for the name of the relationship instead of **user**
    we need to specify that the foreign key is **user_id** and not **owner_id**, cause laravel would search for foreign-key based on the methods name.
    we could use **user** and leave it as it was, but **owner** seems better for clean code. 


### 4.What is addReply in thread model?
    So when we want to add a new reply for a thread, instead of throwing around variablesa or 
    making our controllers filled with shit code, we can make laravel do our heavy lifting.
    so here when we hit the route **/threads/{thread}/replies** with a post request,
    the controller will take the **thread** instance, then we add the **addReply** method to the **Thread** model. that **addReply** method will use the relation defined on model
    to instanciate a new **reply** instance and then calls to **create** method on it.

    so in **Replycontroller** when **store** method takes the instance of given **thread**
    **addReply** method is already called, it takes 2 extra prameters like **user_id** and **body**, then creates a new reply.


### 5.A thread blongs to a channel (configuring channel or category concept):
    Thus far we have thread and reply, but now we want to assign each thread to a **channel** or a **category**, meaning a **thread** needs to **belongTo** a **channel**.

    so lets create a model and migration for channel.
    then we create a table for it and add a factory for it, then in thread factroy we add a **channel_id** field and use the factory created to add a id to it.

    then we want to make all the thread routes to be subcategorized with channels.
    then we fix the controller methods assosiated with those routes. now the **path()** method in models should be updated.

    now if we seed database using factory and tinker we should be able to see the threads and add replies to them.

    then for creating new threads, we can go to the **create** route and do the selecting stuff.
    

### 6.Sharing a varible with views (specefic ones or all )
    Here we want to share the channels varible to some views,
     cause we dont want to query them for every view that needs it.

    We will use ServiceProviders, in this case AppServiceProvider,
    but we can add a dedicated service provider from artisan ,
    then in boot() method we will add this code.

    ```PHP
        View::composer( 'the/views/that/we/want' , function ($view){
            $view->with('var/name', 'query or var here');
        });

        //example
        View::composer( 'create.thread' , function ($view){
            $view->with('channels', \App\Channel::all());
        });
    ```
    
    Note that in first parameter we can specify a view or a array of views (['thread.create','thread.show'])  or pass a star ('*') for every view.

    ```PHP
        View::composer( '*' , function ($view){
            $view->with('channels', \App\Channel::all());
        });
    ```

    Or you can  use this format eigther.


    ```PHP
        View::share('channels, \App\Channel::all());
    ```



### 7.Adding a Global scope
    So We want to have a query every time an instance of  a model is initiated
    In order to do that we can fire up the boot() method on the desired model,
    (note that boot method fires up automaticaly), then we can add a gloabal scope query 
    in boot method and have it run every time.
    In the thread model we added a repliesCount global scope , so we can have a the 
    number of replies on every Thread instance. 



### 8.Adding a $with array to Models.
	When we want to add a global scope to all the querys for a model, we can use the boot() method of
	the model and add a query for all instances and disable it for certain ones.as we did for
	thread and replies count .
	but when we want a relation to be queried with every instance and there is not a exeption
	we can use the    $with  array on the model. this is  the same as saying I want to eager 
	load this relation with every query.



### 9.Adding an Admin Or superUser that every policy will check for it
	We can have specefic rules for each policy method,
	also we can have a general rule for a specefic policy .
	for example we have 'ThreadPolicy'  so we can add this method to it.

	```PHP
	  public function before($user)
	  {
		if($user->is_admin === 0 )
		{
		  return true;
		}
	  }
	```

	this will return true for the user if he/she is a Author before any other methods.



	Similarly we can add a user as Admin so he/she would be returned for all policies

	In AuthServiceProvider in boot() we can add him.

	```PHP
	  
	  Gate::before(function($user){
			if($user->name === 'Amir') return true;
		  });

	  Or :

	  Gate::before(function($user){
			if($user->is_admin === 0) return true;
		  });

	```



### 10.A Cool Trick for boot methods on Traits
	For every trait that a model uses we can add the following method to it,
	then Laravel would treat it as you have added the content of it to the 
	models boot method itself.



	```PHP
	  protected static function boot<NameOFTrait>()
	  {
		#code
	  }
	```

### 11. Spam detection now can be easily done
    Visit App\Inspections folder, add a new class for your Spam type.
    handle the logic inside a detect() method.
    then add your class to Spam.php array of inspections.
    it will automatically be done.
