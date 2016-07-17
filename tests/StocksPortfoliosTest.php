<?php
use PHPUnit\Framework\TestCase;

class StocksPortfoliosTest extends TestCase {
	public function testValidatesQuantityHeld()
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

        $stock = Stock::find_by_ticker('googl');

        $stocks_portfolio = new StocksPortfolio([
            'stock_id'=>$stock->id,
            'portfolio_id'=>$portfolio->id,
            'quantity_held'=>10
        ]);

    	$this->assertEquals(true, $stocks_portfolio->save());

        $stocks_portfolio_fail = new StocksPortfolio([
            'stock_id'=>$stock->id,
            'portfolio_id'=>$portfolio->id,
            'quantity_held'=>-1
        ]);
        $stocks_portfolio_fail->save();

        $this->assertEquals('can not be less than 0', $stocks_portfolio_fail->errors->on('quantity_held'));
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