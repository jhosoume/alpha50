#!/usr/bin/env python3

from yahoo_finance import Share
import sys
import arrow
from decimal import Decimal
from retrying import retry
from models.stock import Stock
from models.daily_quote import DailyQuote

try:
    BEG = sys.argv[2]
except:
    BEG = '2009-01-01'

try:
    BEG = sys.argv[3]
except:
    END = '2016-07-11'

@retry(stop_max_attempt_number = 10,
       wait_random_min = 1000,
       wait_random_max = 2000)
def get_stock_history(ticker, beg, end):
    history = Share(ticker).get_historical(beg, end)
    prep_history = []
    for day in history:
        info = {'date': arrow.get(*[ int(num) for num in day['Date'].split('-') ]), 
                'close_price': Decimal(day['Close'])}
        prep_history.append(info)
    return prep_history

def populate_single_stock_history(ticker):
    stock = Stock.where('ticker', ticker).first()

def populate_stock_history(beg, end):
    for stock in Stock.all():
        try: 
            stock_history = get_stock_history(stock.ticker, BEG, END)
        except:
            print('ERROR: could not get stock history for \n {}'.format(stock.ticker))
            print(sys.exc_info())
            continue
        for day in stock_history:
            try:
                stock_quotes = stock.daily_quotes()
            except:
                print('ERROR: could not get stocks for \n {}'.format(stock.ticker))
                raise sys.exc_info()
            if not stock_quotes.save(DailyQuote(day)):
                print('ERROR: could not save daily quote for \n {}'.format(day))
    
if __name__ == '__main__':
    populate_stock_history(BEG, END)
