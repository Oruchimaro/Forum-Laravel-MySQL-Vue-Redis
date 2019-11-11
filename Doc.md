# Documentation

### setting up a factory
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

    