<p><font face="Arial"><b><font size="6">About</font></b><br>
<font size="2"><br>
Task Manager System allows users create/update/delete tasks. Users that are 
attached to a task or the owner of the task can manage messages on a task. Used 
Laravel framework as an API (no web routes). App returns data in JSON format.
<font color="#FF0000">Use &quot;POSTMAN&quot; or similar to see how app works!</font><br>
<br>
</font><font size="6"><b>Install</b></font></font></p>
<p><font size="2" face="Arial"><br>
Clone the git repository on your computer<br>
<br>
<font color="#000080">$ git clone 
https://github.com/lupikas/Task-Manager-System.git</font><br>
<br>
You can also download the entire repository as a zip file and unpack in on your 
computer if you do not have git<br>
<br>
After cloning the application, you need to install it's dependencies.<br>
<br>
<font color="#000080">$ cd Task-Manager-System<br>
$ composer install</font><br>
<br>
</font><font face="Arial" size="6"><b>Setup</b></font></p>
<p><font size="2" face="Arial"><br>
When you are done with installation, copy the .env.example file to .env<br>
<br>
<font color="#000080">$ cp .env.example .env</font><br>
<br>
Connect app with database (edit .env file).<br>
<br>
Generate the application key<br>
<br>
<font color="#000080">$ php artisan key:generate</font><br>
<br>
Generate JWT secret<br>
<br>
<font color="#000080">$ php artisan jwt:secret<br>
</font><br>
Migrate the application<br>
<br>
<font color="#000080">$ php artisan migrate<br>
</font><br>
Run the application<br>
<br>
<font color="#000080">$ php artisan serve<br>
</font><br>
</font><font face="Arial" size="6"><b>Url</b></font><font size="2" face="Arial"><br>
<br>
<font color="#FF0000">{task} - task id<br>
{message} - message id</font><br>
<br>
/createtask - create task <br>
/mytasks - show all tasks<br>
/task/{task}/update - update task. <br>
/task/{task}/delete - delete task <br>
/task/{task} - show task details<br>
/task/{task}/createmessage - create messege<br>
/task/{task}/message/{message}/update - update messege <br>
/task/{task}/message/{message}/delete - delete messege <br>
/task/{task}/view/{message} - show messege<br>
/viewlog - show messege log</font></p>
