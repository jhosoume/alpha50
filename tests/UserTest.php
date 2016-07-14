<?php
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase {
	public function testCreate()
    {
    	$user = new User();
    	$user->password = "asdf";
    	$user->email="asdf@hotmail.com";
    	$user->save();

    	// Make sure save fails and there is a password length error.
    	$this->assertEquals('must be at least 8 characters long', $user->errors->on('plain_text_password'));	

    	// Make sure the password with a length of 8 works on save.
    	$user->password = "asdfasdf";
    	$this->assertEquals(true, $user->save());

    	// Make sure the email can't be blank.
    	$user2 = User::create([
    		'password'=>'asdfasdf',
    	]);
    	$this->assertEquals("can't be blank", $user2->errors->on('email'));
    }

    public function testAuthenticate() {
    	$user = User::create([
    		'password'=>'asdfasdf',
    		'email'=>'asdf@hotmail.com'
    	]);

    	// Make sure the authentication matches.
    	$this->assertEquals(true, $user->authenticate('asdfasdf'));
    	$this->assertEquals(false, $user->authenticate('asdfasdfasdf'));
    }


    public static function tearDownAfterClass()
    {
    	echo("\nDeleting all that was added to database...\n");
    	User::query('SET FOREIGN_KEY_CHECKS=0;');
        User::delete_all();
        User::query('SET FOREIGN_KEY_CHECKS=1;');
    }
}