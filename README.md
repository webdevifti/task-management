# Welcome to Task Management System
# About Project
>> Task Management System where admin assigned user a task to completed on task's due time . This system has two type of user 1. Admin and 2. User

>> ### Admin Capabilities:
>> - #### Manage Tasks: Admins can Create, Edit, View, Delete, Update Status, Assign task.
>> - #### Dashboard: Admins has a dashboard where they can view statistices .
>> - #### Admin can create,edit,delete, view user

>> ### User Capabilities:
>> - #### user can create,edit,delete,view and update status on task: 

## Installation commands , open project directory cmd or powershell
``composer update``

 ``copy .env.example .env ``
 
``php artisan key:generate``
#### go to .env file and put your database information
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
```

## database migrate and generate new data: 
``php artisan migrate:refresh --seed``
## after this commad you get some customer and admin as demo
## Then start the server
``php artisan serve``

``npm install && npm run dev``
>> you can see the server running url and go to the url to see the application interface
>> ### Now you can login as Admin and user
>> #### check the database who is admin and user, you can login with email and password, default password is ``1234567890`` 