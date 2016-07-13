#!/usr/bin/env python3

import os, sys, inspect
currentdir = os.path.dirname(os.path.abspath(inspect.getfile(inspect.currentframe())))
parentdir = os.path.dirname(currentdir)
sys.path.insert(0,parentdir)

import requests
import json
import arrow
from googlefinance import getQuotes
from decimal import Decimal
from retrying import retry
from models.stock import Stock 
from models.half_hourly_quote import HalfHourlyQuote
from yahoo_scraper import scrape_yahoo_site

YAHOO_URL = 'http://finance.yahoo.com/webservice/v1/symbols/{}/quote?format=json&view=detail'
MAX_ATTEMPS = 25
INTERVAL = 1000 # in ms

@retry(stop_max_attempt_number = MAX_ATTEMPS,
       wait_random_min = INTERVAL - 10000,
       wait_random_max = INTERVAL)
def reach_google(tickers_list):
    return getQuotes(tickers_list)

def get_stocks_real_time_google(tickers_list):
    stocks_info = reach_google(tickers_list)
    stocks_prices = []
    for stock in stocks_info:
        time = stock['LastTradeDateTime'][:-1] 
        if not time:
            continue
        info = {'datetime': arrow.get(time + '-04:00').to('PST'),
                'price': Decimal(stock['LastTradePrice']) } 
        stocks_prices.append({'ticker': stock['StockSymbol'], 'info': info})
    return stocks_prices

@retry(stop_max_attempt_number = MAX_ATTEMPS,
       wait_random_min = INTERVAL - 50,
       wait_random_max = INTERVAL)
def reach_url(url):
    return requests.get(url) 

def get_stocks_real_time(tickers_list):
    stocks_info = reach_url(YAHOO_URL.format(','.join([ str(ticker) for ticker in tickers_list ])))
    stocks_list = json.loads(stocks_info.text)['list']['resources']
    stocks_prices = []
    for stock in stocks_list:
        stock = stock['resource']['fields']
        info = {'datetime': arrow.get(stock['utctime']).to('PST'),
                'price': Decimal(stock['price']) } 
        stocks_prices.append({'ticker': stock['symbol'], 'info': info})
    return stocks_prices

def populate_stock_real_time():
    try:
        stocks_prices = get_stocks_real_time([stock.ticker for stock in Stock.all()])
    except:
        try:
            stocks_prices = scrape_yahoo_site([stock.ticker for stock in Stock.all()])
        except:
            try:
                stocks_prices = get_stocks_real_time_google([stock.ticker for stock in Stock.all()])
            except:
                return
    for stock_price in stocks_prices:
        stock = Stock.where('ticker', stock_price['ticker']).first()
        if stock:
            stock.half_hourly_quotes().save(HalfHourlyQuote(stock_price['info']))

if __name__ == '__main__':
    populate_stock_real_time()

# Set up cron as (it is in EDT time):
# 10 8-17 * * 1-5
# PST HalfHourly
