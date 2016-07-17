<?php
use PHPUnit\Framework\TestCase;

class TradeTest extends TestCase {

    public function testValidatePortfolioCash() {
        $user = User::create(['email'=>'asdf@gmail.com','password'=>'asdfasdf']);
        $portfolio = Portfolio::create(['name'=>'PortPortPort','user_id'=>$user->id,'cash'=>200]);
        $stocks_portfolio = $portfolio->stocks_portfolios[0];

        $trade_buy = Trade::create([
            'stocks_portfolio_id'=>$stocks_portfolio->id,
            'quantity'=>10,
            'price'=>10,
        ]);
        // Test that a portfolio can trade if it has enough money.
        $this->assertEquals(100, $user->portfolios[0]->total_cash);

        $trade_buy_fail = new Trade([
            'stocks_portfolio_id'=>$stocks_portfolio->id,
            'quantity'=>10,
            'price'=>1000
        ]);
        $trade_buy_fail->save();

        // Test that a portfolio can't trade if it doesn't have enough money.
        $this->assertEquals('portfolio does not have enough cash', $trade_buy_fail->errors->on('portfolio_cash'));


        $trade_sell = Trade::create([
            'stocks_portfolio_id'=>$stocks_portfolio->id,
            'quantity'=>-10,
            'price'=>10,
        ]);
        $user->reload();

        // Test that a portfolio's cash raises when it sells.
        $this->assertEquals(200, $user->portfolios[0]->total_cash);
    }

	public function testAfterCreateCallback()
    {
        $user = User::create(['email'=>'asdf@gmail.com','password'=>'asdfasdf']);
        $portfolio = Portfolio::create(['name'=>'Awesome Port','user_id'=>$user->id,'cash'=>30000]);
        $stocks_portfolio = $portfolio->stocks_portfolios[0];

    	$trade_1 = Trade::create([
    		'stocks_portfolio_id'=>$stocks_portfolio->id,
    		'quantity'=>10,
    		'price'=>100,
    	]);

    	$trade_2 = Trade::create([
    		'stocks_portfolio_id'=>$stocks_portfolio->id,
    		'quantity'=>-5,
    		'price'=>100,
    	]);
    	$stocks_portfolio = $user->portfolios[0]->stocks_portfolios[0];

        // Test that trades change the portfolio's quantity held.
    	$this->assertEquals(5, $stocks_portfolio->quantity_held);

	    $trade_fail = Trade::create([
            'stocks_portfolio_id'=>$stocks_portfolio->id,
            'quantity'=>-6,
            'price'=>100,
        ]);

        // Test that you can't sell more than you have.
        $this->assertEquals('can not short security', $trade_fail->errors->on('portfolio_quantity_held'));
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