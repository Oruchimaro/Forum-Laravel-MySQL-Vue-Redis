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
    

### 3.why in reply model we specified the user_id ?
    Because we used the **owner** for the name of the relationship instead of **user**
    we need to specify that the foreign key is **user_id** and not **owner_id**, cause laravel would search for foreign-key based on the methods name.
    we could use **user** and leave it as it was, but **owner** seems better for clean code. 