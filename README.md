# What is this?
    This is a project for practice and learning.It can be cofigured, used or packaged for later use, but for now this mainly considered as a practice project.
## What are we doing here?
    Here we are creating a **Forum** app using **Laravel 6** nd **Vue js** .We are implementing the  Object Oriented Programming concept in this app.

## How to use this?
    This project is version controlled via Azure Devops platform and Git.
    Every change is done in a seprate branch, after completing its merged with master branch.
    This means after completion there will be 102 commits and as many branches as nessecerry.

## Installation:
    Clone this repository using git from the master branch.
    Cd into the directory.
    Use this commands
        ```PHP
            $ composer install
            npm install
            create a .env file using .env.example and edit it.
            php artisan migrate
            php artisan serve
            
        ```

## Seeding Database
    For seeding database fire up tinker and user factory to create a bunch of threads

    ```PHP
        $ php artisan tinker

        $threads = factory('App\Thread', 20)->create();
        $threads->each(function($thread){factory('App\Reply', 10)->create(['thread_id' => $thread->id]);})
    ```

## Documentation
    This project is documented using infile documents and Doc.md file.
    