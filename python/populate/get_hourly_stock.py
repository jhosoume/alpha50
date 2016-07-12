#!/usr/bin/env python3

import requests
import json
from decimal import Decimal
from retrying import retry
import arrow
from stocks_list import stocks
from models.stock import Stock 
from models.hourly_quote import HourlyQuote

YAHOO_URL = 'http://finance.yahoo.com/webservice/v1/symbols/{}/quote?format=json&view=detail'
MAX_ATTEMPS = 25
INTERVAL = 60000 # in ms

@retry(stop_max_attempt_number = MAX_ATTEMPS,
       wait_random_min = INTERVAL - 10000,
       wait_random_max = INTERVAL)
def reach_url(url):
    return requests.get(url) 

def get_stocks_real_time(tickers_list):
    stocks_info = reach_url(YAHOO_URL.format(','.join([ str(ticker) for ticker in tickers_list ])))
    stocks_list = json.loads(stocks_info.text)['list']['resources']
    stocks_prices = []
    for stock in stocks_list:
        stock = stock['resource']['fields']
        info = {'datetime': arrow.get(stock['utctime']).to('PST').floor('hour'),
                'price': Decimal(stock['price']) } 
        stocks_prices.append({'ticker': stock['symbol'], 'info': info})
    return stocks_prices

def populate_stock_real_time():
    try:
        stocks_prices = get_stocks_real_time([stock.ticker for stock in Stock.all()])
    except:
        return
    for stock_price in stocks_prices:
        stock = Stock.where('ticker', stock_price['ticker']).first()
        if stock:
            stock.hourly_quotes().save(HourlyQuote(stock_price['info']))

if __name__ == '__main__':
    populate_stock_real_time()

# Set up cron as (it is in EDT time):
# 10 8-17 * * 1-5
# PST 5-14


