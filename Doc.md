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

    then for creating new threads, 
