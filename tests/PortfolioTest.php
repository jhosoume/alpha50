<?php
use PHPUnit\Framework\TestCase;

class PortfolioTest extends TestCase {
	public function testCanReferenceParent()
    {
    	$user = User::create([
    	  	'email'=>'asdf@gmail.com',
    	  	'password_hash'=>'asdf'
    	]);

    	$monkey = User::create([
    	  	'email'=>'monkey@ahhah.com',
    	  	'password_hash'=>'asdf'
    	]);

    	$portfolio_parent = Portfolio::create([
    		'name'=>'Awesome Port',
    		'user_id'=>$user->id,
    	]);

    	$portfolio_monkey = Portfolio::create([
    		'name'=>'Awesome Port [Monkey]',
    		'user_id'=>$monkey->id,
    		'parent'=>$portfolio_parent->id
    	]);

    	$this->assertEquals('Awesome Port', $monkey->portfolios[0]->parent_portfolio->name);
    	$this->assertEquals('Awesome Port [Monkey]', $user->portfolios[0]->portfolio->name);   	
    }


    public static function tearDownAfterClass()
    {
    	echo("\nDeleting all that was added to database...\n");
    	User::query('SET FOREIGN_KEY_CHECKS=0;');
        Portfolio::delete_all();
        User::delete_all();
        Trade::delete_all();
        User::query('SET FOREIGN_KEY_CHECKS=1;');
    }
}