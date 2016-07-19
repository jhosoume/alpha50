<?php
use PHPUnit\Framework\TestCase;

class PortfolioTest extends TestCase {
	public function testCanReferenceParent()
    {
    	$user = User::create([
    	  	'email'=>'asdf@gmail.com',
    	  	'password'=>'asdfasdf'
    	]);

    	$portfolio = Portfolio::create([
    		'name'=>'Awesome Port',
    		'user_id'=>$user->id,
            'total_cash'=>10000,
    	]);

        $portfolio->reload();
        $monkey_portfolio = $portfolio->portfolio;

    	$this->assertEquals('Awesome Port', $monkey_portfolio->parent_portfolio->name);
    	$this->assertEquals('Monkey Awesome Port', $portfolio->portfolio->name);  	
    }

    public function testCreatesStocksPortfolios() {
        $user = User::create([
            'email'=>'asdf@gmail.com',
            'password'=>'asdfasdf'
        ]);

        $portfolio = Portfolio::create([
            'name'=>'port',
            'user_id'=>$user->id,
            'total_cash'=>1000
        ]);
        $user->reload();

        $this->assertEquals(50, count($user->portfolios[0]->stocks_portfolios));
    }

    public static function tearDownAfterClass()
    {
    	echo("\nDeleting all that was added to database...\n");
    	User::query('SET FOREIGN_KEY_CHECKS=0;');
        Portfolio::delete_all();
        StocksPortfolio::delete_all();
        User::delete_all();
        Trade::delete_all();
        User::query('SET FOREIGN_KEY_CHECKS=1;');
    }

}