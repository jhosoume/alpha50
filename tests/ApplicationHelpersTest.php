<?php
use PHPUnit\Framework\TestCase;

class ApplicationHelpersTest extends TestCase {
	public function testCurrentUser()
    {
    	$this->assertEquals(false, current_user());

    	$user = User::create(['email'=>'asdf@gmail.com', 'password'=>'asdfasdf']);
    	$_SESSION['user_id'] = User::first()->id;
    	$this->assertEquals(User::first(), current_user());
    	$user->delete();
    }
}