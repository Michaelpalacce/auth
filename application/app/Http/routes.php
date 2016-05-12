<?php

Route::get('/', function () {
    echo 'Welcome to my Application';
});

Route::get('hello/{name}',function($name){
    echo 'Hello There '.$name;
});

//create an item

Route::post('test',function(){
    echo 'Post';
});

//Read an item
Route::get('test',function(){
    echo '<form method="POST" action="test">
        <input type="submit">
        </form>';

});

//Update an item
Route::put('test',function(){
    echo 'Put';
});

//Deelte an item
Route::delete('test',function(){
    echo 'Delete';
});